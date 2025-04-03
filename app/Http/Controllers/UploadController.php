<?php

namespace App\Http\Controllers;

use App\Actions\HandleFileAction;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class UploadController extends Controller
{
    /**
     * Handle the incoming file upload.
     */
    public function __invoke(FileReceiver $receiver, HandleFileAction $saveFile)
    {
        if (!$receiver->isUploaded()) {
            throw new UploadMissingFileException(
                'File not found. Please check the file upload.'
            );
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            $saveFile->execute($save->getFile());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'File uploaded successfully.',
            'file' => $save->getFile(),
        ]);
    }
}

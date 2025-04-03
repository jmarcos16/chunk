<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;

class HandleFileAction
{
    public function execute(UploadedFile $file): void
    {
        $fileName = $file->hashName();
        $mime = str_replace('/', '-', $file->getMimeType());
        $dateFolder = date('Y/m/d');


        $filePath = "uploads/{$mime}/{$dateFolder}";
        $finalPath = storage_path("app/".$filePath);

        if (!is_dir($finalPath)) {
            mkdir($finalPath, 0755, true);
        }

        $file->move($finalPath, $fileName);
    }
}

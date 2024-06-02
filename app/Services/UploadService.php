<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class UploadService
{
    public static function uploadReturnPath(UploadedFile | string $image, string $folderName)
    {
        $imageName = time() . '_' . uniqid();
        if (gettype($image) === 'string') {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
            $imageName =  "$imageName.jpg";
        } else {
            $mimeToExtension = [
                'image/jpeg' => 'jpg',
                'image/pjpeg' => 'jpg',
                'image/png' => 'png'
            ];

            $mime = $image->getMimeType();
            $extension = $image->getClientOriginalExtension();
            if (trim($extension) == '' && isset($mimeToExtension[$mime])) {
                $extension = $mimeToExtension[$mime];
            }
            $imageName = "$imageName.$extension";
        }

        $folderPath = storage_path("app/public/$folderName");
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        file_put_contents("$folderPath/$imageName", $image);
        return "storage/$folderName/$imageName";
    }
}

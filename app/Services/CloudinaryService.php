<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CloudinaryService
{
    /**
     * Upload a file to Cloudinary.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string Secure URL of the uploaded image
     */
    public static function upload(UploadedFile $file, string $folder = '')
    {
        $cloudinaryUrl = env('CLOUDINARY_URL');
        if (!$cloudinaryUrl) {
            // Fallback to local storage if Cloudinary is not configured
            return $file->store($folder, 'public');
        }

        $cloudinary = new Cloudinary($cloudinaryUrl);
        $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => $folder
        ]);

        return $result['secure_url'];
    }

    /**
     * Delete a file from Cloudinary or local storage.
     *
     * @param string|null $url
     * @return void
     */
    public static function delete(?string $url)
    {
        if (!$url) return;

        if (str_contains($url, 'res.cloudinary.com')) {
            $cloudinaryUrl = env('CLOUDINARY_URL');
            if ($cloudinaryUrl) {
                // Extract public ID from Cloudinary URL
                preg_match('/upload\/(?:v\d+\/)?([^\.]+)/', $url, $matches);
                if (isset($matches[1])) {
                    $cloudinary = new Cloudinary($cloudinaryUrl);
                    try {
                        $cloudinary->uploadApi()->destroy($matches[1]);
                    } catch (\Exception $e) {
                        // Ignore deletion errors
                    }
                }
            }
        } else {
            // It's a local file path
            Storage::disk('public')->delete($url);
        }
    }
}

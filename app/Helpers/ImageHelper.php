<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;

class ImageHelper
{
    /**
     * @param $request
     * @param false $delete_old
     * @param string $field
     * @return string
     */
    public static function uploadImage($request, bool $delete_old = false, string $field = 'banner'): string
    {
        $fullPath = '';

        if ($delete_old) {
            (new ImageHelper)->deleteImage($request->old_banner);
        }

        if ($request->banner) {
            $extension = explode('/', mime_content_type($request->banner))[1];
            $fullPath  = '/uploads/' . time() . '.' . $extension;
            $image     = Image::make($request->banner);
            $image->save(public_path($fullPath));
        }
        return $fullPath;
    }

    /**
     * @param mixed $path
     */
    public function deleteImage($path = null)
    {
        if ($path && file_exists($file_path = public_path($path))) {
            unlink($file_path);
        }
    }
}

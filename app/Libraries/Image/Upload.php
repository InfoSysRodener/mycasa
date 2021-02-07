<?php

namespace App\Libraries\Image;

use Illuminate\Support\Facades\Storage;
use Image;
use App\Libraries\Http\Code;

class Upload
{
    /**
     * Upload to s3 bucket
     *
     * @return string
     */
    public static function upload($picture, $name, $path='/', $isThumbNail = FALSE, $width = null)
    {
        if ($isThumbNail === TRUE) {
            $inputImage = Image::make($picture)->resize(80, 80, function ($constraint) {
                $constraint->aspectRatio();
            })->orientate();

        } else {
            $inputImage = Image::make($picture)->orientate();
        }

        if(is_null($width) === FALSE) {
            $inputImage = Image::make($picture)->resize($width, NULL, function ($constraint) {
                $constraint->aspectRatio();
            })->orientate();
        }

        $storage = Storage::disk(config('filesystems.cloud'));

        $prefix = $path . '/';

        $extension = self::extractExtension($inputImage->mime());

        $filename = $name . '.' . $extension;

        if ($inputImage->mime() === 'image/gif') {
            $storage->write($prefix . $filename, file_get_contents($picture), ['ACL' => 'public-read', 'ContentType' => $inputImage->mime()]);
        } else {
            $storage->write($prefix . $filename, $inputImage->stream()->__toString(), ['ACL' => 'public-read', 'ContentType' => $inputImage->mime()]);
        }

        return [
            'filename'  => $filename,
            'extension' => $extension,
            'image'     => $inputImage
        ];
    }

     /**
     * Get file extension
     *
     * @param  string $mime
     * @return string
     */
    public static function extractExtension($mime)
    {
        if ($mime == 'image/jpeg') {
            $extension = 'jpeg';
        } elseif ($mime == 'image/jpg') {
            $extension = 'jpg';
        } elseif ($mime == 'image/png') {
            $extension = 'png';
        } elseif ($mime == 'image/gif') {
            $extension = 'gif';
        } else {
            abort(Code::HTTP_UNSUPPORTED_MEDIA_TYPE, 'Invalid file type');
        }

        return $extension;
    }

    /**
     * Remove uploaded file
     *
     * @param  string $path
     * @param  string $filename
     * @param  array $sizes
     * @return void
     */
    public static function deleteImage($path='/', $filename, $sizes=[])
    {
        $storage = Storage::disk(self::DRIVER);
        $prefix = config('filesystems.disks.s3.url_prefix') . '/' . $path;
        $pictures = [];
        $pictures[] = $prefix . $filename;

        // check if there are other sizes that needs to
        // be deleted too
        foreach ($sizes as $size) {
            $pictures[] = $prefix . $size . '/' . $filename;
        }
        $storage->delete($pictures);
    }

    public static function delete($path='/', $filename, $sizes=[])
    {
        if ($filename === 'none.jpg') return false;

        $prefix = config('filesystems.disks.s3.prefix') . '/' . $path;
        $file = $path . '/' .    $filename;

        Storage::delete($file);
    }
}

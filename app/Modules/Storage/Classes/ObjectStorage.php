<?php

namespace App\Modules\Storage\Classes;

use App\Modules\Storage\Interfaces\StorageInterface;
use Illuminate\Support\Facades\Storage;

class ObjectStorage implements StorageInterface
{
    public static function getUrl($file_path)
    {
        return asset('uploads/' . $file_path);
    }

    public function store($path, $file, $name = '')
    {
        if ($name) {
            $url = Storage::disk('s3')->putFileAs($path ?? 'files', $file, $name);

            return $url;
        }

        $url = Storage::disk('s3')->put($path ?? 'files', $file);

        return $url;
    }

    public function getUniqueIfHasSameFileName($basename, $same_name_counts)
    {
        $file_name = pathinfo($basename)['filename'];
        $file_type = pathinfo($basename)['extension'] ?? '';

        return $file_name . '-' . $same_name_counts . '.' . $file_type;
    }

    public function delete($path)
    {
        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
        }

        return true;
    }
}

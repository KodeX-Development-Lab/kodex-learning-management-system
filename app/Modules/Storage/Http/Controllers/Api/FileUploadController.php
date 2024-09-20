<?php

namespace App\Modules\Storage\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    private $storage;

    public function __construct(ObjectStorage $storage)
    {
        $this->storage = $storage;
    }

    public function store(Request $request)
    {
        $request->validate([
            "file" => 'required|file',
            "path" => "nullable",
        ]);

        $url = $this->storage->store($request->path ?? 'files', $request->file);

        if ($url) {
            return response()->json([
                'status'  => true,
                'data'    => [
                    'url' => $this->storage->getUrl($url),
                ],
                'message' => 'Successfully saved',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'data'    => null,
                'message' => "Fail",
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        if (Storage::disk('s3')->exists($request->path)) {
            Storage::disk('s3')->delete($request->path);

            return response()->json([], 204);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "File Not Found",
            ], 404);
        }

    }
}

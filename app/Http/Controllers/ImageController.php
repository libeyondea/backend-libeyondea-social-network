<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    use ApiResponser;

    /**
     * Upload image to storage and return the path to the image.
     *
     * @param UploadImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(UploadImageRequest $request)
    {
        if ($request->hasfile('image')) {
            $imageName = Str::random(66) . '.' . $request->file('image')->extension();
            Storage::disk('img')->put($imageName, file_get_contents($request->file('image')));
        }
        return $this->respondSuccess(['name' => $imageName]);
    }
}

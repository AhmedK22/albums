<?php

namespace App\Http\Services;


use App\Http\Repositories\ImageRepository;
use App\Models\Album;
use Illuminate\Http\Request;

class ImageServise
{
    public function __construct(public ImageRepository $imageRepository)
    {
    }

    public function  handleRequest(Request $request, Album $album)
    {

        if ($request->hasFile('file')) {
            $file = $request->file;
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/images',  $fileName);

            if ($path) {
                $newRequest = new Request();
                $newRequest->merge(['name' => $fileName, 'path' => $path, 'album_id' => $album->id]);


                if ($this->imageRepository->fill($newRequest)) {

                    return response()->json(['upload success' => 'success'], 200);
                } else {
                    return response()->json(['upload error' => 'error'], 401);
                }
            }
        }

        return response()->json(['upload error' => 'error'], 404);

    }
}

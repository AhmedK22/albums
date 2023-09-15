<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ImageRepository;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct(public ImageRepository $imageRepository)
    {
    }

    public function index(Request $request)
    {
        $gallaries = $this->imageRepository->search($request)->get();

        return view('albums.index', compact('gallaries'));
    }
    public function store(Request $request, Album $album)
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

        return response()->json(['upload error' => 'error'], 401);
    }


    public function destroy (Image $image)
    {


        if($this->imageRepository->destroy($image)) {

            return redirect()->back()->with('success', 'album deleted successfully');
       }

       return redirect()->back()->with('errors', 'failed to delete');

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Repositories\GalleryRepository;
use App\Http\Repositories\ImageRepository;
use App\Http\Requests\CreateAlbumRequest;
use App\Models\Album;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function __construct(public GalleryRepository $galleryRepository, public ImageRepository $imageRepository)
    {}

    public function index(Request $request)
    {
        $gallaries = $this->galleryRepository->search($request)->get();

        return view('albums.index', compact('gallaries'));
    }

    public function show(Request $request, Album $album)
    {
        $request->merge(['album' => $album->id]);
        $gallery = $album;
        $images = $this->imageRepository->search($request)->get();

        return view('albums.show', compact('gallery', 'images'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(CreateAlbumRequest $request)
    {
       if($this->galleryRepository->fill($request)) {

            return redirect(route('albums.index'))->with('success', 'album created');
       }

       return redirect()->back()->with('errors', 'failed to create');
    }

    public function edit(Album $album)
    {

        return view('albums.edit', compact('album'));
    }

    public function update(CreateAlbumRequest $request, Album $album)
    {
       if($this->galleryRepository->fill($request, $album)) {

            return redirect(route('albums.index'))->with('success', 'album updated');
       }

       return redirect()->back()->with('errors', 'failed to update');
    }

    public function destroy(Request $request, Album $album)
    {

        if($this->galleryRepository->destroy($album)) {

            return redirect(route('albums.index'))->with('success', 'album deleted successfully');
       }

       return redirect()->back()->with('errors', 'failed to delete');

    }

    public function changeAlbum(Request $request, Album $album)
    {

        if($this->imageRepository->changeAlbum($request, $album)) {

            return redirect(route('albums.index'))->with('success', 'album changed successfully');
       }

       return redirect()->back()->with('errors', 'failed to change');

    }


}

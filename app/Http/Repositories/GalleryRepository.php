<?php
namespace App\Http\Repositories;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryRepository
{

    public function __construct( public ImageRepository $imageRepository)
    {}

    public function search(Request $request)
    {
        $album =  Album::query();

        if($request->filled('album')) {
            $album->where('id', $request->album);
        }

        return $album->where('user_id', Auth::id());
    }
    public function fill(Request $request,? Album $album = null)
    {
        if (!isset ($album)) {
            $album = new Album();
        }

        $album->name = $request->name;
        $album->user_id = Auth::id();

        return $album->save();

    }

    public function destroy(Album $album)
    {

       $this->imageRepository->destroyByAlbum($album);

       return $album->delete();

    }


}

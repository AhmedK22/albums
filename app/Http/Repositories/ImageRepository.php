<?php
namespace App\Http\Repositories;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageRepository
{

    public function search(Request $request)
    {
        $image = Image::query();

        if($request->filled('album')) {
            $image->where('album_id', $request->album);
        }

        return  $image;
    }
    public function fill(Request $request,? Album $image = null)
    {
        if (!isset ($image)) {
            $image = new Image();
        }

        $image->name = $request->name;
        $image->path = $request->path;
        $image->album_id = $request->album_id;

        return $image->save();

    }

    public function destroyByAlbum($album)
    {

       return Image::whereIn('album_id', [$album->id])->delete();
    }

    public function destroy($image)
    {

       return Image::where('id', [$image->id])->delete();
    }




    public function changeAlbum(Request $request, Album $album)
    {

        return Image::where('album_id', $album->id)->update([
            'album_id' =>  $request->gallery
        ]);

    }
}

@extends('layouts.app')

@section('content')

    <div class="container w-75">
       

        <div class="d-flex align-items-center flex-column">
            <h1>{{ $gallery->name }}</h1>

            @if ($gallery->images()->count() > 0)
                <div class="row ">
                    @foreach ($images as $image)
                        <div class="col-lg-3  mb-2  border border-1 bg-white">
                            <div class="card">

                                <img class="w-100" src="{{ asset('storage/images') . '/' . $image->name }}">
                            </div>
                            <p class="">{{ $image->name }}</p>
                            <form class="d-inline" method="post"
                            action="{{ route('images.desrtoy', ['image' => $image->id]) }}"> @csrf
                            @method('delete')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p>
                    No Images Yet
                </p>
            @endif
            <div class="row justify-content-center w-100">

                <form action="{{ route('album.upload', ['album' => $gallery->id]) }}" method="post" class="dropzone"
                    id="myDropzone">
                    @csrf
            </div>
            </form>
        </div>

    </div>


@endsection

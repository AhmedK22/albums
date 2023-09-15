@extends('layouts.app')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            <h4>{{ Session::get('success') }}</h4>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger">
            <h4>{{ Session::get('error') }}</h4>
        </div>
    @endif

    <div class="container w-75">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($gallaries as $gallery)
                    <tr>
                        <td class="fs-5">{{ $gallery->name }}</td>
                        <td>
                            <a href="{{ route('albums.show', ['album' => $gallery->id]) }}" class="btn btn-primary">Show</a>
                            <a href="{{ route('albums.edit', ['album' => $gallery->id]) }}" class="btn btn-info">Edit</a>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#{{ $gallery->name . '' . $gallery->id }}">
                                delete
                            </button>
                        </td>
                    </tr>

                    <!-- Modal To Check Delete Or Move-->
                    <div class="modal fade" id="{{ $gallery->name . '' . $gallery->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h3>Are You Sure</h3>
                                </div>
                                <div class="modal-footer">

                                    @if ($gallery->images()->count() > 0)
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#{{ $gallery->name }}"
                                            class="btn btn-secondary" data-bs-dismiss="modal"> Move Images To Another Album </button>
                                    @endif
                                    <form class="d-inline" method="post"
                                        action="{{ route('albums.destroy', ['album' => $gallery->id]) }}"> @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!---->


                    <!-- Modal to Move photos to another gallery -->
                    <div class="modal fade" id="{{ $gallery->name }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Which Album</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{ route('move.photos', ['album' => $gallery->id]) }}">
                                    <div class="modal-body">
                                        @csrf
                                        @method('patch')
                                        @foreach ($gallaries as $album)
                                            <div class="form-check">
                                                <input value="{{ $album->id }}" class="form-check-input" type="radio"
                                                    name="gallery" @if ($gallery->id == $album->id) checked @endif>
                                                <label class="form-check-label" for={{ $album->name }}>
                                                    {{ $album->name }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Move</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>





    </div>
@endsection

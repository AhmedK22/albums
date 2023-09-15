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

    <div class="container w-50">
        <form action="{{ route('albums.store') }}" method="POST">
            @csrf

            <label for="name" class="form-label">Album Name</label>
            <input type="text" class="form-control" id="name"name="name">
            @foreach ($errors->get('name') as $error)

            <div class="alert alert-danger  mt-2">
                {{$error}}
            </div>

            @endforeach
            <button class="btn btn-primary mt-2">submit</button>
        </form>
    </div>
@endsection

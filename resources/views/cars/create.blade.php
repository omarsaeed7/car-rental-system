@extends('master')
@section('title', 'Create Course')

@section('content')
    <div class="container">
        <h1 class="text-center mt-3"><a href="{{ route('courses.index') }}">Courses</a></h1>
        <h1 class="text-left ">Create Course</h1>


        <form action="{{ route('courses.store') }}" method="POST" class="m-3" enctype="multipart/form-data">
            @csrf
            <label for="name">Course name</label>
            <input type="name" name="name" placeholder="Course Name" class="form-control mb-3 @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <p style="color:red;">{{ $errors->first('name') }}</p>
            @endif
            <label for="image">Course image</label>
            <input type="file" name="image" placeholder="Course image" class="form-control mb-3 @error('image') is-invalid @enderror" value="{{ old('image') }}">
            @if ($errors->has('image'))
                <p style="color:red;">{{ $errors->first('image') }}</p>
            @endif
            <label for="content">Course content</label>
            <input type="text" name="content" placeholder="Course Content" class="form-control mb-3 @error('content') is-invalid @enderror" value="{{ old('content') }}">
            @if ($errors->has('content'))
                <p style="color:red;">{{ $errors->first('content') }}</p>
            @endif
            <div class="row">
                <div class="col-2">
                    <label for="price">Course price</label>
                    <input type="number" name="price" placeholder="Price" class="form-control mb-3 @error('price') is-invalid @enderror" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                        <p style="color:red;">{{ $errors->first('price') }}</p>
                    @endif
                </div>
                <div class="col-1">
                    <label for="hours">Course hours</label>
                    <input type="number" name="hours" placeholder="Hours" class="form-control mb-3 @error('hours') is-invalid @enderror" value="{{ old('hours') }}">
                    @if ($errors->has('hours'))
                        <p style="color:red;">{{ $errors->first('hours') }}</p>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

@endsection

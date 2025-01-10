@extends('master')
@section('title', 'Create Course')

@section('content')
    <div class="container">
        <h1 class="text-center mt-3"><a href="{{ route('courses.index') }}">Courses</a></h1>

        <form action="{{ route('courses.update',$course->id) }}" method="POST" class="m-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="name">Course name</label>
            <input type="name" name="name" placeholder="Course Name"
                class="form-control mb-3 @error('name') is-invalid @enderror" value="{{ old('name',$course->name) }}">
            @if ($errors->has('name'))
                <p style="color:red;">{{ $errors->first('name') }}</p>
            @endif
            <label for="image">Course image</label>
            <input type="file" name="image" placeholder="Course image"
                class="form-control mb-3 @error('image') is-invalid @enderror" value="{{ old('image',$course->image) }}">
            @if ($errors->has('image'))
                <p style="color:red;">{{ $errors->first('image') }}</p>
            @endif
            <label for="content">Course content</label>
            <input type="text" name="content" placeholder="Course Content"
                class="form-control mb-3 @error('content') is-invalid @enderror" value="{{ old('content',$course->content) }}">
            @if ($errors->has('content'))
                <p style="color:red;">{{ $errors->first('content') }}</p>
            @endif
            <div class="row">
                <div class="col-2">
                    <label for="price">Course price</label>
                    <input type="number" name="price" placeholder="Price"
                        class="form-control mb-3 @error('price') is-invalid @enderror" value="{{old('price', $course->price) }}">
                    @if ($errors->has('price'))
                        <p style="color:red;">{{ $errors->first('price') }}</p>
                    @endif
                </div>
                <div class="col-1">
                    <label for="hours">Course hours</label>
                    <input type="number" name="hours" placeholder="Hours"
                        class="form-control mb-3 @error('hours') is-invalid @enderror"
                        value="{{ old('hours', $course->hours) }}">
                    @if ($errors->has('hours'))
                        <p style="color:red;">{{ $errors->first('hours') }}</p>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Update</button>
        </form>
    </div>

@endsection

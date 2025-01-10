@extends('master')
@section('title', 'Show Course')

@section('content')
    <div class="container">
        <h1 class="text-center mt-3"><a href="{{ route('courses.index') }}">Courses</a></h1>

        <div class="card mb-3" style="">
            <div class="row g-0">
                <div class="col-md-4">
                    {{-- @dd(asset('storage/'.$course->image)) --}}
                    <img src="{{  asset('storage/'.$course->image) }}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <p class="card-text">{{ $course->content }}</p>
                        <p class="card-text"><small class="text-body-secondary">{{$course->created_at}}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

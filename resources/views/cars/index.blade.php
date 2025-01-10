@extends('master') {{-- using master.blade.php file -> just paste the code there in here --}}
@section('title', 'Home') {{-- "Home" -> is the title in the @yield('title') in the master.blade.php --}}
{{-- Anything in this content section will be added in @yield('content') place  --}}
@section('content')
    {{-- Container --}}
    <div class="mx-5">
        {{-- Content --}}
        <h1 class="text-center mt-3"><a href="{{ route('cars.index') }}">Courses</a></h1>
        {{-- Success Of Creation msg --}}
        @if (session('msg'))

        <div class="alert alert-{{session('type')}} alert-dismissible fade show">
            {{ session('msg')}} {{--session is a way to send data between pages | so we take the msg from the controller and show it here --}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        {{--  --}}
        <div class="d-flex justify-content-between">
            {{-- Trash --}}
            <a href="{{ route('courses.trash') }}" class="btn btn-danger mb-3"><i class="fas fa-trash"></i> Trashed Courses</a>
            {{-- Create Item --}}
            <a href="{{ route('courses.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Creat Course</a>
        </div>

        {{-- Sorting --}}
        <form action="{{ route('courses.index') }}" method="get" class="row">
            @if (request()->has('page'))
                {{-- We send page with the request to apply the filter for any page sent with FORM2 --}}
                <input type="hidden" name="page" value="{{ request()->page }}">
            @endif
            <div class="col-5">
                <input type="text" name="search" class="form-control" placeholder="search.."
                    value="@if (request()->search != '') {{ $searchValue }} @endif">
                {{-- user search for anything ? -> show him his search in the page of his search <<- ->> show it blank --}}
            </div>
            <div class="col-2">
                <select name="column" class="form-select mx-2">
                    <option @selected(request()->column == 'id') value="id">Id</option>
                    <option @selected(request()->column == 'name') value="name">name</option>
                    <option @selected(request()->column == 'price') value="price">price</option>
                    <option @selected(request()->column == 'created_at') value="created_at">created at</option>
                    <option @selected(request()->column == 'status') value="status">status</option>
                </select>
            </div>
            <div class="col-2">
                <select name="type" class="form-select mx-2">
                    <option @selected(request()->type == 'asc') value="asc">Ascending</option>
                    <option @selected(request()->type == 'desc') value="desc">Descending</option>
                </select>
            </div>
            <div class="col-2">
                <button type="submit" style="display: inline;" class="btn btn-outline-primary">Sort / Search</button>
            </div>
        </form>
        {{-- ./Sorting --}}
        {{-- Table --}}
        <table class="table mt-2 table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Content</th>
                    <th>Price</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->image }}</td>
                        <td>{{ $course->content }}</td>
                        <td>{{ $course->price }}$</td>
                        <td>{{ $course->hours }}</td>
                        {{-- htmlspecialchar used to show html as HTML not as string --}}
                        <td>{!! $course->status
                            ? '<span class="badge bg-success">Open</span>'
                            : '<span class="badge bg-danger">Closed</span>' !!}</td>
                        <td>{{ $course->updated_at->format('M d Y') }}</td>
                        {{-- Carbon Library for Date and time manipulation --}}
                        <td>{{ $course->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{route('courses.edit', $course->id)}}" class="btn btn-sm btn-primary m-2"><i class="fas fa-pen"></i></a>
                            <a href="{{route('courses.show', $course->id)}}" class="btn btn-sm btn-primary m-2"><i class="fas fa-eye"></i></a>
                            {{-- DELETE --}}
                            <form action="{{ route('courses.delete', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger m-2"
                                    onclick="return confirm('Are You Sure?')"><i class="fas fa-trash "></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ./Table --}}
        {{-- appends -> take array
            the $_GET is a request array
            [
                'key' => 'value',
                'key' => 'value'
            ]
        so we add this array to appends so it add it to the uri
        --}}

        {{ $courses->appends($_GET)->links() }}


    </div>
    {{-- ./Container --}}
@endsection

@extends('master')
@section('title', 'Trash')
@section('content')
    <div class="mx-5">


        {{-- Content --}}
        <h1 class="text-center mt-3"><a href="{{ route('courses.index') }}">Courses</a></h1>
        <a href="{{ route('courses.index') }}" class="btn btn-primary mb-3"><i class="fas fa-trash"></i> All Courses</a>

        {{-- Table --}}
        <table class="table mt-2 table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Hours</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                {{-- is a shorthand for foreach and if else
                    means that if the $courses is not empty excute that code
                --}}
                @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->price }}$</td>
                        <td>{{ $course->hours }}</td>
                        {{-- htmlspecialchar used to show html as HTML not as string --}}
                        {{-- Carbon Library for Date and time manipulation --}}
                        <td>{{ $course->deleted_at->diffForHumans() }}</td>
                        <td>

                            {{-- Undo Delete --}}
                            <form action="{{ route('courses.restore', $course->id) }}" method="GET" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger m-2"
                                    onclick="return confirm('Are You Sure To Restore Course?')"><i
                                        class="fas fa-undo "></i></button>
                            </form>

                            {{-- Delete Forever --}}
                            <form action="{{ route('courses.destroy', $course->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger m-2"
                                    onclick="return confirm('Are You Sure?')"><i class="fas fa-x"></i></button>

                            </form>
                        </td>
                    </tr>
                    {{-- if the $courses empty excute this --}}
                @empty
                    <tr>
                        <td colspan="6" class="text-center fs-2 text-success">No Trash Courses</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    {{ $courses->appends($_GET)->links() }}
@endsection

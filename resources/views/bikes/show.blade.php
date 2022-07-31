@section('title', $bike->title)
@extends('layouts/app')

@section('content')

    <div class="content">

        <h1 class="title">{{ $bike->title }}</h1>

        <form method="post" action="{{ route('bikes.destroy', [$bike->id]) }}">
            @csrf @method('delete')
            <div class="field is-grouped">
                <div class="btn-group">
                    <a
                            href="{{ route('bikes.edit', [$bike->id])}}"
                            class="btn btn-sm btn-outline-secondary"
                    >
                        Edit
                    </a>
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        Delete
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

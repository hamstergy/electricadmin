@section('title', 'Home')
@extends('layouts/app')

@section('content')

    @foreach ($makes as $make)
        <div class="content">
            <a href="{{ route('makes.show', [$make->id]) }}">
                <h1 class="title">{{ $make->name }}</h1>
            </a>
            <form method="post" action="{{ route('makes.destroy', [$make->id]) }}">
                @csrf @method('delete')
                <div class="field is-grouped">
                    <div class="btn-group">
                        <a
                                href="{{ route('makes.edit', [$make->id])}}"
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
    @endforeach

@endsection

@section('title', $electric->make.' '.$electric->model)
@extends('layouts/app')

@section('content')

    <div class="content">

        <h1 class="title">{{ $electric->make.' '.$electric->model }}</h1>

        <form method="post" action="{{ route('electric.destroy', [$electric->id]) }}">
            @csrf @method('delete')
            <div class="field is-grouped">
                <div class="btn-group">
                    <a
                            href="{{ route('electric.edit', [$electric->id])}}"
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

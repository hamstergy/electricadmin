@section('title', $model->name)
@extends('layouts/app')

@section('content')

    <div class="content">

        <h1 class="title">{{ $model->name }}</h1>

        <form method="post" action="{{ route('models.destroy', [$model->id]) }}">
            @csrf @method('delete')
            <div class="field is-grouped">
                <div class="btn-group">
                    <a
                            href="{{ route('models.edit', [$model->id])}}"
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

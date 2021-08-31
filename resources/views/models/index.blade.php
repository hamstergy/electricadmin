@section('title', 'Home')
@extends('layouts/app')

@section('content')

    @foreach ($models as $model)
        <div class="content">
            <a href="{{ route('models.show', [$make->id]) }}">
                <h1 class="title">{{ $make->name }}</h1>
            </a>

            <form method="post" action="{{ route('models.destroy', [$make->id]) }}">
                @csrf @method('delete')
                <div class="field is-grouped">
                    <div class="btn-group">
                        <a
                                href="{{ route('models.edit', [$make->id])}}"
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

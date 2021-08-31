@section('title', $make->name)
@extends('layouts/app')

@section('content')

    <div class="content">

        <h1 class="title">{{ $make->name }}</h1>
        <div class="row">
            @foreach($make->models as $model)
                <div class="col">
                    <a href="{{ route('models.show', [$model->id])}}"><h3>{{$model->name}}</h3></a>
                </div>
            @endforeach
        </div>

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

@endsection

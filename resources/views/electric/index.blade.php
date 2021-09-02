@section('title', 'Home')
@extends('layouts/app')

@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Description</th>
            <th scope="col">Youtube</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vehicles as $vehicle)
        <tr>
            <th scope="row">{{$vehicle->id}}</th>
            <td>
                <a href="{{ route('electric.edit', [$vehicle->id]) }}">
                    {{ $vehicle->make.' '.$vehicle->model }}
                </a>
            </td>
            <td>{{($vehicle->description)? 'Yes': 'No'}}</td>
            <td>{{($vehicle->youtube)? 'Yes': 'No'}}</td>
            <td>
                <form method="post" action="{{ route('electric.destroy', [$vehicle->id]) }}">
                    @csrf @method('delete')
                    <div class="field is-grouped">
                        <div class="btn-group">
                            <a
                                href="{{ route('electric.edit', [$vehicle->id])}}"
                                class="btn btn-sm btn-outline-secondary"
                            >
                                Edit
                            </a>
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('title', 'Home')
@extends('layouts/app')
@php ($not_available = '<p class="text-danger">N/A</p>')
@section('content')
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Make Model</th>
            <th scope="col">Price</th>
            <th scope="col">Acc.</th>
            <th scope="col">Range</th>
            <th scope="col">Effic</th>
            <th scope="col">Top Speed</th>
            <th scope="col">Charge Speed</th>
            <th scope="col">Battery</th>
            <th scope="col">Drive</th>
            <th scope="col">Type</th>
            <th scope="col">Segment</th>
            <th scope="col">Seats</th>
            <th scope="col">Desc</th>
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
            <td>{!!($vehicle->price)? $vehicle->price: $not_available !!}</td>
            <td>{!!($vehicle->acceleration)? $vehicle->acceleration: $not_available!!}</td>
            <td>{!!($vehicle->range)? $vehicle->range: $not_available!!}</td>
            <td>{!!($vehicle->efficiency)? $vehicle->efficiency: $not_available!!}</td>
            <td>{!!($vehicle->speed)? $vehicle->speed: $not_available!!}</td>
            <td>{!!($vehicle->chargeSpeed)? $vehicle->chargeSpeed: $not_available!!}</td>
            <td>{!!($vehicle->battery)? $vehicle->battery: $not_available!!}</td>
            <td>{!!($vehicle->drive)? $vehicle->drive: $not_available!!}</td>
            <td>{!!($vehicle->type)? $vehicle->type: $not_available!!}</td>
            <td>{!!($vehicle->segment)? $vehicle->segment: $not_available!!}</td>
            <td>{!!($vehicle->seats)? $vehicle->seats: $not_available!!}</td>
            <td>{!!($vehicle->description)? 'Yes': '<b>No</b>'!!}</td>
            <td>{!!($vehicle->youtube)? 'Yes': '<b>No</b>'!!}</td>
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

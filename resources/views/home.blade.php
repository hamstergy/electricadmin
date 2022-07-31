@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col">
                            <h5>Catalogs</h5>
                            <div class="list-group">
                                <a href="{{ url('/electric') }}" class="list-group-item list-group-item-action">Electric Catalog</a>
                                <a href="{{ url('/bikes') }}" class="list-group-item list-group-item-action">Electric Bike Catalog</a>
                            </div>
                        </div>
                        <div class="col">
                            <h5>JSON</h5>
                            <div class="list-group">
                                <a href="{{ url('/electric-json') }}" class="list-group-item list-group-item-action">Car Catalog</a>
                                <a href="{{ url('/electric-json/makes') }}" class="list-group-item list-group-item-action">Car Brands</a>
                                <a href="{{ url('/bikes-json') }}" class="list-group-item list-group-item-action">Bike Catalog</a>
                                <a href="{{ url('/bikes-json/makes') }}" class="list-group-item list-group-item-action">Bike Brands</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

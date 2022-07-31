@section('title', 'Edit Electric Bikes')
@section('action', route('bikes.create'))
@extends('layouts/app')

@section('content')

    <h1 class="title">Edit: {{ $bike->title }}</h1>
    
    @csrf
    <bike-create :data="{{ json_encode($bike) }}"></bike-create>

@endsection


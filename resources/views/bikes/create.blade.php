@section('title', 'New Electric Bike')
@extends('layouts/app')

@section('content')

    <h1 class="title">Create a new electric bike</h1>

    @csrf
    <bike-create :data="{
    make:'',
    model:'',
    isConcept: false,
    releaseDate: '',
    acceleration: '',
    speed: '',
    range: '',
    efficiency: '',
    chargeSpeed: '',
    battery: '',
    price: '',
    drive: '',
    type: '',
    segment: '',
    seats: '',
    description: '',
    imageSlug: '',
    youtube: ''}"></bike-create>

@endsection

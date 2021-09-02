@section('title', 'New Electric Vehicle')
@extends('layouts/app')

@section('content')

    <h1 class="title">Create a new electric vehicle</h1>

    @csrf
    <electric-create :data="{
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
    youtube: ''}"></electric-create>

@endsection

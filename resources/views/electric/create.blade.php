@section('title', 'New Electric Vehicle')
@extends('layouts/app')

@section('content')

    <h1 class="title">Create a new electric vehicle</h1>

    @csrf
    <electric-create :data="{}"></electric-create>

@endsection

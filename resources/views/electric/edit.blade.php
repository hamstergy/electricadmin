@section('title', 'Edit Electric Vehicle')
@section('action', route('electric.create'))
@extends('layouts/app')

@section('content')

    <h1 class="title">Edit: {{ $electric->make." ".$electric->model }}</h1>

    @csrf
    <electric-create :data="{{ json_encode($electric) }}"></electric-create>

@endsection


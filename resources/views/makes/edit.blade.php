@section('title', 'Edit Make')
@section('action', route('makes.create'))
@extends('layouts/app')

@section('content')

    <h1 class="title">Edit: {{ $make->name }}</h1>

    @csrf
    <make-editor :data="{{ json_encode($make) }}"></make-editor>

@endsection


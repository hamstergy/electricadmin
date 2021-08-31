@section('title', 'New Model')
@extends('layouts/app')

@section('content')

    <h1 class="title">Create a new model</h1>

    @csrf
    <model-editor :data="{}"></model-editor>

@endsection

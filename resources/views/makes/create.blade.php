@section('title', 'New Make')
@extends('layouts/app')

@section('content')

    <h1 class="title">Create a new make</h1>

    @csrf
    <make-editor :data="{}"></make-editor>

@endsection

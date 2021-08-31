@section('title', 'Edit Model')
@section('action', route('models.create'))
@extends('layouts/app')

@section('content')

    <h1 class="title">Edit: {{ $model->name }}</h1>

    @csrf
    <model-editor :data="{{ json_encode($model) }}"></model-editor>

@endsection


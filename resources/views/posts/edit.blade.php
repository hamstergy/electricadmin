@section('title', 'Edit Post')
@section('action', route('posts.create'))
@extends('layouts/app')

@section('content')

    <h1 class="title">Edit: {{ $post->title }}</h1>

    @csrf
    <post-create :data="{{ json_encode($post) }}"></post-create>

@endsection


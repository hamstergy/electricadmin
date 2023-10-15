@section('title', 'New Post')
@extends('layouts/app')

@section('content')

    <h1 class="title">Create a new post</h1>

    @csrf
    <post-create :data="{
    title:'',
    body:'',
    short_description: '',
    date: '',
    tags: '',
    slug: ''}"></post-create>

@endsection

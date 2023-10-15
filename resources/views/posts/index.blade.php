@section('title', 'Home')
@extends('layouts/app')
@php ($not_available = '<p class="text-danger">N/A</p>')
@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">SEO Desc</th>
            <th scope="col">Slug</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
        <tr>
            <th scope="row">{{$post->id}}</th>

            <td>
                <a href="{{ route('posts.edit', [$post->id]) }}">
                    {{ $post->title }}
                </a>
            </td>
            <td>{!!($post->short_description)? 'Yes': $not_available !!}</td>
            <td>{!!($post->slug)? 'Yes': $not_available !!}</td>
            <td>
                <form method="post" action="{{ route('posts.destroy', [$post->id]) }}">
                    @csrf @method('delete')
                    <div class="field is-grouped">
                        <div class="btn-group">
                            <a
                                href="{{ route('posts.edit', [$post->id])}}"
                                class="btn btn-sm btn-outline-secondary"
                            >
                                Edit
                            </a>
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

@endsection

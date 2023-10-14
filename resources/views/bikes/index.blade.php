@section('title', 'Home')
@extends('layouts/app')
@php ($not_available = '<p class="text-danger">N/A</p>')
@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Desc</th>
            <th scope="col">SEO Desc</th>
            <th scope="col">Review</th>
            <th scope="col">Break</th>
            <th scope="col">Battery</th>
            <th scope="col">Range</th>
            <th scope="col">Speed</th>
            <th scope="col">Amazon ID</th>
            <th scope="col">Youtube</th>
            <th scope="col">Active</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($bikes as $bike)
        <tr>
            <th scope="row">{{$bike->id}}</th>
            <td>
                <a href="https://www.amazon.com/dp/{{$bike->amazon_id}}?&linkCode=li2&tag=evrevue-20&language=en_US&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-na.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN={{$bike->amazon_id}}&Format=_SL160_&ID=AsinImage&MarketPlace=US&ServiceVersion=20070822&WS=1&tag=evrevue-20&language=en_US" ></a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=evrevue-20&language=en_US&l=li2&o=1&a=B096VTPRJY" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
            </td>
            <td>
                <a href="{{ route('bikes.edit', [$bike->id]) }}">
                    {{ $bike->title }}
                </a>
            </td>
            <td>{{($bike->description)? 'Yes': 'No'}}</td>
            <td>{!!($bike->short_description)? $bike->short_description: $not_available !!}</td>
            <td>{!!($bike->review)? $bike->review: $not_available !!}</td>
            <td>{!!($bike->break_system)? $bike->break_system: $not_available !!}</td>
            <td>{!!($bike->battery)? $bike->battery: $not_available !!}</td>
            <td>{!!($bike->range)? $bike->range: $not_available !!}</td>
            <td>{!!($bike->speed)? $bike->speed: $not_available !!}</td>
            <td>{!!($bike->amazon_id)? "<a href=".$bike->url." target='_blank'>".$bike->amazon_id."</a>": $not_available !!}</td>
            {{-- 'make' => 'required|string',
            'model' => 'required|string',
            <td>{{($bike->description)? 'Yes': 'No'}}</td>
            'title' => 'required|string',
            'review' => 'string|nullable',
            'youtube' => 'string|nullable',
            'price' => 'numeric|nullable',
            'motor' => 'integer|nullable',
            'gears' => 'string|nullable',
            'tire' => 'string|nullable',
            'type' => 'string|nullable',
            'weight' => 'integer|nullable',
            'folding' => 'boolean|nullable',
            'frame_type' => 'string|nullable',
            'review_rate' => 'numeric|nullable',
            'imageSlug' => 'string|nullable',
            'slug' => 'string',
             --}}
            <td>{{($bike->youtube)? 'Yes': 'No'}}</td>
            <td>{!!($bike->active)? $bike->active: $not_available !!}</td>
            <td>
                <form method="post" action="{{ route('bikes.destroy', [$bike->id]) }}">
                    @csrf @method('delete')
                    <div class="field is-grouped">
                        <div class="btn-group">
                            <a
                                href="{{ route('bikes.edit', [$bike->id])}}"
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

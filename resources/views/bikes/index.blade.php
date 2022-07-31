@section('title', 'Home')
@extends('layouts/app')

@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Description</th>
            <th scope="col">Youtube</th>
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
            <td>{{($bike->youtube)? 'Yes': 'No'}}</td>
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

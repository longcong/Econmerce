@extends('layouts.admin')

@section('title', '| All Product')

@section('content')

<div class="row">
    <div class="col-md-10">
        <h1>All Product</h1>
    </div>

    <div class="col-md-2">
        <a href="{{ route('products.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create New Product</a>
    </div>
    <div class="col-md-12">
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Image</th>
                <th>Note</th>
                <th>Created At</th>
                <th></th>
            </thead>

            <tbody>
                @foreach($products as $post)

                    <tr>
                        <th>{{ $post->id }}</th>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->image }}</td>
                        <td>{{ substr($post->note, 0, 50) }} {{ strlen($post->note) >50 ? "..." : "" }}</td>
                        <td>{{ date('M j, Y', strtotime($post->created_at)) }}</td>
                        <td><a href="{{ route('products.show', $post->id) }}" class="btn btn-deault btn-sm">View</a><a href="{{ route('products.edit' , $post->id )}}" class="btn btn-default btn-sm">Edit</a></td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        <div>
            {!! $products -> links() !!}
        </div>
    </div>
</div>

@endsection
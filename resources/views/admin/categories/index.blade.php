@extends('layouts.admin')

@section('title', '| All Categories')


@section('content')

    <div class="card">
        <div class="card-body">
            <h1>Categories</h1>
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>name</th>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <th>{{ $category->id }}</th>
                        <th>{{ $category->name }}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-12">
                <div class="well " style="background-color: #EEEEEE; padding:10px; ">
                    {!! Form::open(['route' => 'categories.store', 'method' => 'POST']) !!}
                        <h3>New Category</h3>
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    {{ Form::label('name', 'Name:') }}
                                </div>
                                <div class="col-8">
                                    {{ Form::text('name',null,['class' => 'form-control']) }}
                                </div>
                            </div>
                        {{ Form::submit ('Create New Category', ['class' => 'btn btn-primary btn-block']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@extends('admin.layouts.base')

@section('contents')

    <h1>Name: {{ $type->name }}</h1>
    <p>Description: {{ $type->description }}</p>

@endsection
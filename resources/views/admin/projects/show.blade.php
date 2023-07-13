@extends('admin.layouts.base')

@section('contents')

    <h1>{{ $project->title }}</h1>
    <h2>Category: {{ $project->type->name }}</h2>
    <h3>Technologies: {{ implode(', ', $project->technologies->pluck('name')->all()) }}</h3>
    <img src="{{ $project->url_image }}" alt="{{ $project->title }}">
    <p>{{ $project->content }}</p>
    @if ($project->image)
    <p>Img from file:</p>
    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
    @endif

@endsection
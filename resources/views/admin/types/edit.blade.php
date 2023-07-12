@extends('admin.layouts.base')

@section('contents')

    <h1>Edit Type</h1>

    <form method="POST" action="{{ route('admin.types.update', ['type' => $type]) }}" novalidate>
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name', $type->name) }}"
            >
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input
            type="text"
            class="form-control @error('description') is-invalid @enderror"
            id="description"
            name="description"
            value="{{ old('description', $type->description) }}"
            >
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-primary">Update</button>
    </form>

@endsection
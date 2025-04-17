@extends('layouts.frontend')

@section('content-frontend')
<div class="container mt-4">
  <div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h2 class="mb-0">{{ $post->title }}</h2>
        <a href="{{ route('blogs.index') }}" class="btn btn-light btn-sm">← Back to All Posts</a>
    </div>    

    <div class="card-body">
        <img src="{{ asset($post->image ?? 'uploads/no_image.jpg') }}" alt="Blog Image" class="img-fluid mb-3" style="max-height: 300px; object-fit: cover;">
      <p>{!! nl2br(e($post->content)) !!}</p>
    </div>
  </div>
</div>
@endsection

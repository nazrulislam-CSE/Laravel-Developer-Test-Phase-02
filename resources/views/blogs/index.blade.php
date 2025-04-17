@extends('layouts.frontend') 
@section('content-frontend')

<div class="container mt-4">
  <div class="card shadow-lg">
    <div class="card-header d-flex justify-content-between align-items-center bg-success">
      <h2 class="mb-0 text-light">All Blog Posts</h2>
    </div>
      <div class="card-body">
        <ul class="list-group">
          @forelse($posts as $index => $post)
              <li class="list-group-item">
                  <div class="d-flex align-items-center">
                      <div class="me-3">
                        <img src="{{ asset($post->image ?? 'uploads/no_image.jpg') }}" alt="Image" style="width: 60px; height: 50px;">
                      </div>
                      <div class="d-flex justify-content-between align-items-center w-100">
                          <h5 class="mb-0">{{ $post->title }}</h5>
                          <a href="{{ route('blogs.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                      </div>
                  </div>
              </li>
          @empty
              <li class="list-group-item text-center">No posts found.</li>
          @endforelse
        </ul>
        
          <div class="mt-3">
              {{ $posts->links('pagination::bootstrap-5') }}
          </div>
      </div>
  </div>
</div>
@endsection

@push('js')

@endpush
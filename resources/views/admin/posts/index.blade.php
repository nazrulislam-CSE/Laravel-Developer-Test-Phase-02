@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center bg-success">
            <h2 class="mb-0 text-white">All Blog Posts</h2>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary text-white">
                <i class="fas fa-plus me-1"></i> Create Post
            </a>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <form method="GET" action="{{ route('admin.posts.index') }}" class="d-flex">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control me-2" 
                        placeholder="Search by title..." 
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="btn btn-secondary">Search</button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-danger ms-2">Reset</a>
                </form>
            </div>

            <div class="card shadow-lg">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="postTable">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Category</th>
                                <th>Featured Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $start = ($posts->currentPage() - 1) * $posts->perPage() + 1;
                            @endphp
                            @forelse($posts as $index => $post)
                                <tr id="postRow-{{ $post->id }}">
                                    <td>{{ $start + $index }}</td> 
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->slug }}</td>
                                    <td>{{ $post->category }}</td>
                                    <td>
                                        <img src="{{ asset($post->image ?? 'uploads/no_image.jpg') }}" alt="Image" style="width: 60px; height: 50px;">
                                    </td>
                                    <td class="col-2">
                                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" onclick="deletePost({{ $post->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $posts->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function deletePost(id) {
        if (confirm('Are you sure you want to delete this post?')) {
            $.ajax({
                url: "{{ url('admin/posts') }}/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                success: function(response) {
                    if (response.success) {
                        $('#postRow-' + id).remove();
                        toastr.success(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Something went wrong!');
                }
            });
        }
    }
</script>
@endpush

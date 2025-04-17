@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center bg-success">
            <h2 class="mb-0 text-white">Create New Blog Post</h2>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-danger text-white">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body">
            <form id="postForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter the title of your post" >
                    <span class="text-danger" id="error-title"></span>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <input type="text" name="category" id="category" class="form-control" placeholder="Enter category name" >
                    <span class="text-danger" id="error-category"></span>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content:</label>
                    <textarea name="content" id="content" class="form-control" rows="5" placeholder="Enter the content of your post" ></textarea>
                    <span class="text-danger" id="error-content"></span>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Featured Image:</label>
                    <input type="file" name="image" id="image" class="form-control" onchange="previewImage()">
                    <span class="text-danger" id="error-image"></span>
                </div>

                <!-- Image Preview -->
                <div class="mt-3">
                    <img 
                        id="imagePreview" 
                        src="{{ asset('uploads/no_image.jpg') }}" 
                        alt="Image Preview" 
                        style="max-width: 100%; height: 60px;">
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary" id="submitBtn"> <i class="fas fa-plus me-2"></i> Create Post</button>
                </div>

            </form>
            <div id="success-message" class="alert alert-success mt-3 d-none"></div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#postForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            $('span.text-danger').text('');
            $('#success-message').addClass('d-none').text('');

            $.ajax({
                url: "{{ route('admin.posts.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.clear(); 
                    toastr.success(response.message);

                    $('#postForm')[0].reset();
                    $('#imagePreview').hide();
                },
                error: function(xhr) {
                    toastr.clear();

                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        for (let key in errors) {
                            $('#error-' + key).text(errors[key][0]);
                            toastr.error(errors[key][0], 'Validation Error');
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again later.', 'Error');
                    }
                }
            });
        });
    });
</script>
<script>
    function previewImage() {
        const file = document.getElementById("image").files[0];
        const reader = new FileReader();

        if (file) {
            reader.onload = function(event) {
                const imagePreview = document.getElementById("imagePreview");
                imagePreview.style.display = "block";  
                imagePreview.src = event.target.result;  
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush

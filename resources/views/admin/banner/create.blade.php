@extends('admin.index')

@section('content')
<div class="card">
    <div class="cardheader">
    <h2>Add Banner</h2>
    @if(session('success'))
            <div class="alert alert-success mt-3" style="padding: 15px; font-size: 16px;">
                {{ session('success') }}
            </div>
    @endif
    </div>
    <div class="card-body">
    <form action="{{ url('/banners/insert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-4">
                    <label for="">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-12 mb-4">
                    <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(event)">
                    <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection

<style>
    /* Card Container */
    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 30px;
    }

    /* Card Header */
    .cardheader h2 {
        font-size: 26px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    /* Form Group (each input field section) */
    .form-group {
        margin-bottom: 20px;
    }

    /* Label Styling */
    label {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }

    /* Input fields */
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    /* Focus effect on input fields */
    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }

    /* Error input styling */
    .form-control.is-invalid {
        border-color: #dc3545;
    }

    /* Error message styling */
    .text-danger {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }

    /* File input styling */
    input[type="file"] {
        padding: 12px;
        font-size: 14px;
    }

    /* Image Preview */
    #imagePreview {
        display: none;
        margin-top: 10px;
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        object-fit: cover;
    }

    /* Submit Button */
    button[type="submit"] {
        background-color: #007bff;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    /* Button hover effect */
    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .card {
            padding: 15px;
        }

        .cardheader h2 {
            font-size: 22px;
        }

        .form-control {
            font-size: 13px;
        }

        button[type="submit"] {
            padding: 10px 20px;
        }
    }
    .col-md-12 {
    margin-bottom: 20px;
}

</style>

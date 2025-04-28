@extends('admin.index')

@section('content')
<div class="card">
    <div class="cardheader">
     <h3>Edit Banner</h3>
     @if(session('success'))
            <div class="alert alert-success mt-3" style="padding: 15px; font-size: 16px;">
                {{ session('success') }}
            </div>
    @endif
    </div>
    <div class="card-body">
    <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="row">
                <div class="col-md-12 mb-3 text-center">
                    @if($banner && $banner->image)
                    <img src="{{ asset('assets/uploads/banner/' . $banner->image) }}" alt="Image" 
                        style="max-width: 300px; height: 200px; object-fit: cover; margin-bottom: 15px;">

                    @endif
                </div>
                <div class="col-md-12 mb-3">
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $banner->name ?? '' }}">
                    @error('name')
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
@endsection
<style>
    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
    }

    /* Error Styling */
    .is-invalid {
        border-color: #dc3545;
    }

    .text-danger {
        color: #dc3545;
        font-size: 12px;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 8px 15px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Spacing & Layout */
    .mb-3 {
        margin-bottom: 15px;
    }

    .col-md-12, .col-md-6 {
        margin-bottom: 15px;
    }

    /* File Input Styling */
    input[type="file"] {
        padding: 6px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 100%;
    }

    /* Label Styling */
    label {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>

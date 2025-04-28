@extends('admin.index')
@section('title', 'Aboutus')
@section('content')
<div class="py-5">
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Aboutus</h3>
                        @if(session('success'))
                            <div class="alert alert-success mt-3" style="padding: 15px; font-size: 16px;">
                                {{ session('success') }}
                            </div>
                        @endif
                        <hr>
                        <form action="{{ url('updateaboutus') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row d-flex">
                                <div class="col-md-4">
                                <div class="col-md-10 mt-4 image">
                                    @if(isset($about))
                                    <img src="{{ asset('uploads/aboutus/' . $about->image) }}" alt="" style="width: 200px; height: 200px;" class="mt-2">
                                    @endif
                                </div>

                                    <div class="col-md-12 mt-4">
                                        <label for="image">Upload Image:</label>
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $about->email ?? '') }}">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Phone</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="name" name="phone" value="{{ old('phone', $about->phone ?? '') }}">
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Aboutus</label>
                                            <textarea type="text" class="form-control @error('aboutus') is-invalid @enderror" name="aboutus" rows="5">"{{ old('aboutus', $about->aboutus ?? '') }}"</textarea>
                                            @error('aboutus')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
  /* Basic form styling */
    form {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    /* Heading styling */
    form .title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }

    form .title i {
        margin-right: 10px;
        color: #007bff;
    }

    /* Form field styling */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.3s;
    }

    /* Focus effect for inputs */
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #007bff;
    }

    /* Input placeholders */
    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #999;
    }

    /* Submit button styling */
    button[type="submit"] {
        background-color: #007bff;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    /* Button hover effect */
    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Responsive design for small screens */
    @media (max-width: 768px) {
        form {
            padding: 20px;
        }

        form .title {
            font-size: 20px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            font-size: 14px;
        }

        button[type="submit"] {
            padding: 10px 20px;
        }
    }
</style>
@extends('admin.index')
@section('content')
    <div class="container">
        <h1>Edit Food Item</h1>

        <form action="{{ route('admin.food.update', $food->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Food Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $food->name) }}">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $food->price) }}" step="0.01">
            </div>
            <div class="form-group">
                <label for="image">Food Image:</label>
                
                @if($food->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($food->image) }}" alt="Current Image" class="img-thumbnail" width="100">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control mt-3" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Update Food</button>
        </form>
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
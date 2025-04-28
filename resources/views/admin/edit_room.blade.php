@extends('admin.index')

@section('title', 'Edit Room')

@section('content')
<div class="overview">
    <div class="title">
        <i class="uil uil-edit"></i>
        <span class="text">Edit Room</span>
    </div>
     <!-- Display errors if any -->
     @if (session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <p>{{ session('error') }}</p>
            </div>
        @endif

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="room_name">Room Name</label>
            <input type="text" id="room_name" name="room_name" class="form-control" value="{{ old('room_name', $room->room_name) }}" placeholder="Enter room name" required>
        </div>

        <div class="form-group">
            <label for="room_description">Room Description</label>
            <textarea id="room_description" name="room_description" class="form-control" placeholder="Enter room description" required>{{ old('room_description', $room->room_description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="room_capacity">Room Capacity</label>
            <input type="number" id="room_capacity" name="room_capacity" class="form-control" value="{{ old('room_capacity', $room->room_capacity) }}" placeholder="Enter room capacity" required>
        </div>

        <div class="form-group">
            <label for="room_type">Room Type</label>
            <select id="room_type" name="room_type" class="form-control" required>
                <option value="deluxe" {{ $room->room_type == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                <option value="suite" {{ $room->room_type == 'suite' ? 'selected' : '' }}>Suite</option>
                <option value="standard" {{ $room->room_type == 'standard' ? 'selected' : '' }}>Standard</option>
            </select>
        </div>

        <div class="form-group">
            <label for="room_price">Price</label>
            <input type="number" id="room_price" name="room_price" class="form-control" value="{{ old('room_price', $room->room_price) }}" placeholder="Enter room price" required>
        </div>

        <!-- Image Upload -->
        <div class="form-group">
            <label for="room_image">Room Image</label>
            <input type="file" id="room_image" name="room_image" class="form-control" accept="image/*">
            @if($room->room_image)
                <div class="mt-2">
                    <img src="{{ asset('images/rooms/' . $room->room_image) }}" alt="Room Image" width="80">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Room</button>
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
@extends('admin.index')

@section('content')
<div class="container mt-2px">
    <h2>Register Staff</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3" style="padding: 15px; font-size: 16px;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.registerStaff') }}">
        @csrf

        <div class="form-group">
            <label for="name">Staff Name:</label>
            <input type="text" name="name" class="form-control"  value="{{ old('name') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Staff Email:</label>
            <input type="email" name="email" class="form-control"  value="{{ old('email') }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Staff Phone:</label>
            <input type="text" name="phone" class="form-control"  value="{{ old('phone') }}">
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" >
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Register Staff</button>
    </form>
</div>
@endsection

<style>
    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .form-group {
        margin-bottom: 5px;
    }

    label {
        font-size: 16px;
        font-weight: bold;
        color: #555;
    }

    input[type="text"], input[type="email"], input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
        border-color: #007bff;
        outline: none;
    }

    button[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .btn {
        font-size: 16px;
    }

    /* Add responsive styling */
    @media (max-width: 767px) {
        .container {
            margin-top: 20px;
        }

        h2 {
            font-size: 20px;
        }

        button[type="submit"] {
            font-size: 14px;
        }
    }
</style>
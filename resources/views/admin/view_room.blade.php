@extends('admin.index')

@section('title', 'View Rooms')

@section('content')
    <div class="overview">
        <div class="title">
            <h1>View Rooms</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="room-list">
            @if ($rooms->isEmpty())
                <p>No rooms available.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room Name</th>
                            <th>Capacity</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $room->room_name }}</td>
                                <td>{{ $room->room_capacity }}</td>
                                <td>{{ ucfirst($room->room_type) }}</td>
                                <td>Rs {{ $room->room_price }}</td>
                                <td>
                                    @if ($room->room_image)
                                        <img src="{{ asset('images/rooms/' . $room->room_image) }}" alt="Room Image" width="80">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('rooms.delete', $room->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the room: {{ $room->room_name }}?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
<style>
    .title i {
        margin-right: 10px;
        font-size: 30px;
        color: #0066cc;
    }

    /* Success Alert */
    .alert-success {
        background-color: #28a745;
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .room-list {
        margin-top: 20px;
    }

    /* Table Styling */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table th, .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f2f2f2;
        color: #333;
    }

    .table tr:hover {
        background-color: #f9f9f9;
    }

    .table td img {
        max-width: 100px;
        height: auto;
        border-radius: 5px;
    }

    .table .btn {
        padding: 5px 10px;
        border-radius: 5px;
        color: white;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
    }

    /* Edit Button */
    .table .btn-warning {
        background-color: #f0ad4e;
        border: none;
    }

    .table .btn-warning:hover {
        background-color: #ec971f;
    }

    /* Delete Button */
    .table .btn-danger {
        background-color: #d9534f;
        border: none;
    }

    .table .btn-danger:hover {
        background-color: #c9302c;
    }

    /* Confirm Delete Button */
    .table .btn-danger:focus {
        outline: none;
    }

    /* No Image Styling */
    .table td span {
        color: #888;
        font-style: italic;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .table th, .table td {
            padding: 8px;
        }

        .table img {
            max-width: 70px;
        }

        .title {
            font-size: 20px;
        }
    }

</style>
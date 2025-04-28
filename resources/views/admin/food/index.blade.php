@extends('admin.index')

@section('content')
    <div class="container">
        <h1>Food Items</h1>
        @if(session('success'))
            <div class="alert alert-success mt-3" style="padding: 15px; font-size: 16px;">
                {{ session('success') }}
            </div>
        @endif

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($foods as $food)
                    <tr>
                        <td>{{ $food->name }}</td>
                        <td>Rs.{{ $food->price }}</td>
                        <td>
                            @if ($food->image)
                                <img src="{{ Storage::url($food->image) }}" alt="{{ $food->name }}" width="100" height="100" style="padding: 5px; border: 1px solid #ccc;">
                            @else
                                No Image
                            @endif
                        </td>

                        <td>
                            <div style="display: flex; justify-content: space-between; width: 200px;">
                                <a href="{{ route('admin.food.edit', $food->id) }}" class="btn btn-Success"  style="background-color:rgb(40, 11, 147); border: none; color: white; padding: 6px 12px; font-size: 14px; border-radius: 4px;">Edit</a>
                                <form action="{{ route('admin.food.destroy', $food->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this food:{{ $food->name }} ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="background-color: #dc3545; border: none; color: white; padding: 6px 12px; font-size: 14px; border-radius: 4px;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
<style>

    .overview {
        margin: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }

    .title {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .title i {
        margin-right: 10px;
        font-size: 30px;
        color: #0066cc;
    }

    .room-list {
        margin-top: 20px;
    }
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
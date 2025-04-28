@extends('admin.index')

@section('content')

<div class="card">

<div class="card-header">
    <h3>
        Banners
    </h3>
    @if(session('success'))
            <div class="alert alert-success mt-3" style="padding: 15px; font-size: 16px;">
                {{ session('success') }}
            </div>
    @endif
</div>
    <div class="card-body">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banner as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>
                            <img src="{{ asset('assets/uploads/banner/' . $item->image) }}" alt="Image Here" style="max-width: 100px; max-height: 100px;">
                        </td>
                        <td>
                        <a href="{{ route('banners.edit', $item->id) }}" class="btn btn-danger btn-sm">Edit</a>
                        <form action="{{ route('banners.delete', $item->id) }}" method="GET" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this banner:{{$item->name}} ?')">Delete</button>
                        </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
<script>
    $(document).on('click', 'a[data-confirm]', function(e) {
        e.preventDefault();
        var message = $(this).data('confirm');
        if (confirm(message)) {
            window.location.href = $(this).attr('href');
        }
    });
</script>
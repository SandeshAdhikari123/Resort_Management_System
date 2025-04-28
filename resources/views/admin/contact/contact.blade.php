@extends('admin.index')

@section('content')
<div class="container">
    <h1>Contact Messages</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Subject</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->subject }}</td>
                <td>{{ $contact->message }}</td>
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
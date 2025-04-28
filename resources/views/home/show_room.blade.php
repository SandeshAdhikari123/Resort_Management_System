<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <base href="/public">
    @include('home.css')
</head>
<body>
@include('home.header')

<div class="our_room" style="margin-top: -1px; background-color: #f0f0f0;">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Our Rooms</h2>
               <p>Finish your year with a mini break. Save 15% or more when you book</p>

        <div class="search-sort-container">
            <!-- Search Form -->
            <form method="GET" action="{{ route('rooms.show_room') }}">
                <input type="text" name="search" placeholder="Search Rooms..." value="{{ request()->search }}">
                <button type="submit">Search</button>
            </form>

            <!-- Sorting and Filtering Form -->
            <form method="GET" action="{{ route('rooms.show_room') }}" class="search-sort-container">
                <input type="text" name="search" placeholder="Search Rooms..." value="{{ request()->search }}">

                <!-- Room Type Filter -->
                <select name="room_type">
                    <option value="">Filter by Room Type</option>
                    <option value="deluxe" {{ request()->room_type == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                    <option value="standard" {{ request()->room_type == 'standard' ? 'selected' : '' }}>Standard</option>
                    <option value="suite" {{ request()->room_type == 'suite' ? 'selected' : '' }}>Suite</option>
                </select>

                <!-- Sorting Options -->
                <select name="sort">
                    <option value="">Sort By</option>
                    <option value="room_name" {{ request()->sort == 'room_name' ? 'selected' : '' }}>Room Name</option>
                    <option value="room_price" {{ request()->sort == 'room_price' ? 'selected' : '' }}>Price</option>
                    <option value="created_at" {{ request()->sort == 'created_at' ? 'selected' : '' }}>Date Added</option>
                    <option value="room_type" {{ request()->sort == 'room_type' ? 'selected' : '' }}>Room Type</option>
                </select>

                <button type="submit">Apply</button>
            </form>
        </div>

               @auth
               <a href="{{ route('user.previous_bookings', ['userId' => Auth::id()]) }}" 
                  class="btn-sm btn-primary" 
                  style="float: right; margin-top:10px;">
                  Booking History
               </a>
               @endauth
            </div>
         </div>
      </div>

      <!-- Display success message if any -->
      @if (session('success'))
          <div class="alert alert-success">
              <p>{{ session('success') }}</p>
          </div>
      @endif

      <div class="row">
         @forelse($rooms as $room)
         <div class="col-md-4 col-sm-6">
            <div id="serv_hover" class="room">
                <div class="room_img">
                    <img style="height: 200px; width:350px" src="{{ asset('images/rooms/' . $room->room_image) }}" alt="Room Image" />
                </div>
                <div class="bed_room">
                    <h3>{{ $room->room_name }}</h3>
                    <h5>{{ $room->room_price }}</h5>
                    <p>{!! Str::limit($room->room_description, 100) !!}</p>
                    <a class="btn btn-primary" href="{{ url('room-details/' . $room->id) }}">Room Details</a>
                </div>
            </div>
         </div>
         @empty
         <div class="col-md-12">
            <div class="alert alert-warning text-center" style="margin-top:20px;">
                No rooms matched your search.
            </div>
         </div>
         @endforelse
      </div>
   </div>
</div>
@include('home.footer')
<style>
        /* Container for search and sort */
    .search-sort-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
        margin: 20px 0;
    }

    /* Input field styling */
    .search-sort-container input[type="text"],
    .search-sort-container select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: 0.3s;
        width: 220px;
    }

    /* Input focus effect */
    .search-sort-container input[type="text"]:focus,
    .search-sort-container select:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        outline: none;
    }

    /* Button styling */
    .search-sort-container button {
        padding: 10px 20px;
        background-color: #007bff;
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .search-sort-container button:hover {
        background-color: #0056b3;
    }
</style>
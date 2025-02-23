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
               @auth
               <a href="{{ route('user.previous_bookings', ['userId' => Auth::id()]) }}" 
                    class="btn-sm btn-primary" 
                    style="float: right;">
                    BookingHistory
                </a>
                @endauth

            </div>
         </div>
      </div>
       <!-- Display errors if any -->
       @if (session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif
   <div class="row">
       @foreach($room as $rooms)
      <div class="col-md-4 col-sm-6">
        <div id="serv_hover" class="room">
            <div class="room_img">
                    <img  style="height: 200px; width:350px" src="{{ asset('images/rooms/' . $rooms->room_image) }}" alt="Room Image" />
            </div>
            <div class="bed_room">
                <h3>{{ $rooms->room_name }}</h3>
                <p>{!! Str::limit($rooms->room_description, 100) !!}</p>
                <a class="btn btn-primary" href="{{ url('room-details/' . $rooms->id) }}">Room Details</a>
            </div>
        </div>
      </div>
    @endforeach
   </div>
   </div>
   </div>
</div>

</body>
</html>
@include('home.footer')
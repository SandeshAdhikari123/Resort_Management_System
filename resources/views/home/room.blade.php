<div class="our_room">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Our Rooms</h2>
               <p>Finish your year with a mini break. Save 15% or more when you book</p>
            </div>
         </div>
      </div>
      <div class="row">
         @foreach($room as $rooms)
         <div class="col-md-4 col-sm-6">
            <div id="serv_hover" class="room">
               <div class="room_img">
                  <img 
                     style="height: 180px; width: 100%; object-fit: cover;" 
                     src="{{ asset('images/rooms/' . $rooms->room_image) }}" 
                     alt="Room Image" />
               </div>
               <div class="bed_room">
                  <h4 style="text-transform: uppercase; font-size: 1.1rem;">{{ $rooms->room_name }}</h4>
                  <a class="btn btn-primary" href="{{ url('room-details/' . $rooms->id) }}">Room Details</a>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</div>

<style>
   .room {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 15px;
      height: auto;
      background-color: #fff;
      box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
   }
   .room_img img {
      border-radius: 8px;
   }
   .bed_room {
      text-align: center;
      margin-top: 10px;
   }
   .btn {
      margin-top: 4px;
      font-size: 0.9rem;
   }
   .bed_room h4 {
      min-height: 30px;
      margin-bottom: 3px;
   }
</style>

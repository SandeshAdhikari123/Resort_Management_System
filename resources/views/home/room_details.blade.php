<!DOCTYPE html>
<html lang="en">
<head>
   <base href="/public">
   @include('home.css')
</head>
<body class="main-layout">
   <!-- Header -->
   <header>
      @include('home.header')
   </header>
   <!-- Our Rooms Section -->
   <div class="our_room" style="margin-top: -1px; background-color: #f0f0f0;">
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
            <div class="col-md-8 col-sm-6">
               <div id="serv_hover" class="room">
                  <div class="room_img" style="padding:10px;">
                     <img  style="height:300px; width:800px" src="{{ asset('images/rooms/' . $room->room_image) }}" alt="Room Image" />
                  </div>
                  <div class="bed_room">
                     <h2  style="text-transform: uppercase;">{{$room->room_name}}</h2>
                     <p>{{$room->room_description}}</p>
                     <h4  style="text-transform: uppercase;">Room Capacity: {{$room->room_capacity}}</h4>
                     <h5  style="text-transform: uppercase;">Room Type: {{$room->room_type}}</h5>
                     <p style="font-weight: bold;">Price: Rs. {{$room->room_price}}</p>
                  </div>
               </div>
            </div>
            <div class="col-md-4" style="margin-top: -2px;">
                <h1>BOOK ROOM</h1>

                <!-- Display validation errors if any -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                                
                <form action="{{ route('booking.submit', $room->id) }}" method="POST">
                    @csrf
                    <div>
                        <label>Name</label>
                        <input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                    </div>
                    <div>
                        <label>Phone Number</label>
                        <input type="number" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}" required>
                    </div>
                    <div>
                        <label>Start Date</label>
                        <input type="date" name="startDate" id="startDate" required>
                    </div>
                    <div>
                        <label>End Date</label>
                        <input type="date" name="endDate" id="endDate" required>
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="room_name" value="{{ $room->room_name }}">
                    <input type="hidden" name="room_price" value="{{ $room->room_price }}">

                    <div style="margin-top: 10px;">
                        <label for="payment_mode" style="margin-right: 10px; font-weight: bold;">Payment Method:</label>
                        <select name="payment_mode" id="payment_mode" class="form-control" style="display: inline-block; width: auto; margin-right: 10px;">
                            <option value="">Select Payment Method</option> 
                            <option value="cash">CASH</option>
                            <option value="khalti">KHALTI</option>
                        </select>

                        <!-- Submit Button -->
                        <button type="submit" id="placeOrderBtn" class="btn-sm btn-success"style="margin-right: 10px;" >Proceed</button>
                    </div>
                </form>

            </div>
      </div>
   </div>

   <!-- Footer -->
   @include('home.footer')

   <!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
<script>
    // Get today's date in YYYY-MM-DD format
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedDate = `${yyyy}-${mm}-${dd}`;

    // Set the minimum date for startDate input
    const startDateInput = document.getElementById('startDate');
    startDateInput.setAttribute('min', formattedDate);

    // Update end date based on selected start date
    const endDateInput = document.getElementById('endDate');
    startDateInput.addEventListener('change', function () {
        const selectedStartDate = new Date(this.value);

        // Calculate min and max end dates (1 day and 5 days after start date)
        const minEndDate = new Date(selectedStartDate);
        minEndDate.setDate(minEndDate.getDate() + 1);

        const maxEndDate = new Date(selectedStartDate);
        maxEndDate.setDate(maxEndDate.getDate() + 5);

        const minEndDateFormatted = minEndDate.toISOString().split('T')[0];
        const maxEndDateFormatted = maxEndDate.toISOString().split('T')[0];

        // Set constraints for the end date input
        endDateInput.setAttribute('min', minEndDateFormatted);
        endDateInput.setAttribute('max', maxEndDateFormatted);
    });

    // Set the minimum date for endDate as tomorrow's date by default
    const defaultMinEndDate = new Date();
    defaultMinEndDate.setDate(defaultMinEndDate.getDate() + 1);
    endDateInput.setAttribute('min', defaultMinEndDate.toISOString().split('T')[0]);
</script>
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const placeOrderBtn = document.getElementById('placeOrderBtn');
        const paymentModeSelect = document.getElementById('payment_mode');

        placeOrderBtn.addEventListener('click', function (e) {
            if (paymentModeSelect.value === 'khalti') {
                e.preventDefault();

                // Collect form data
                const roomId = document.querySelector('input[name="room_id"]').value;
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;

                if (!startDate || !endDate) {
                    alert('Please select Start Date and End Date.');
                    return;
                }

                // Redirect to Khalti payment
                const khaltiUrl = `{{ route('khaltipay', '') }}/${roomId}?startDate=${startDate}&endDate=${endDate}`;
                window.location.href = khaltiUrl;
            }
        });
    });
</script>


<style>
                /* Container Styling */
        .col-md-4 {
            max-width: 400px;
            margin: auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Title Styling */
        .col-md-4 h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        /* Label Styling */
        .col-md-4 label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        /* Input Field Styling */
        .col-md-4 input[type="text"],
        .col-md-4 input[type="email"],
        .col-md-4 input[type="number"],
        .col-md-4 input[type="date"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .col-md-4 input[type="text"]:focus,
        .col-md-4 input[type="email"]:focus,
        .col-md-4 input[type="number"]:focus,
        .col-md-4 input[type="date"]:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Button Styling */
        .book-btn {
            text-align: center;
        }

        .book-btn a {
            text-decoration: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-block;
            margin: 0 5px;
        }

        /* Button Colors */
        .book-btn a[href*="esewa"] {
            background-color: #007bff;
        }

        .book-btn a[href*="cash"] {
            background-color: #28a745;
        }

        /* Hover Effects */
        .book-btn a:hover {
            transform: translateY(-2px);
        }

        .book-btn a[href*="esewa"]:hover {
            background-color: #0056b3;
        }

        .book-btn a[href*="cash"]:hover {
            background-color: #218838;
        }

</style>
</body>
</html>

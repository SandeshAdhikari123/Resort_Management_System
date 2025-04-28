<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Order Food</title>
    <base href="/public">
    @include('home.css')
</head>
<body>
@include('home.header')

<div class="our_food" style="margin-top: -1px; background-color: #f0f0f0;">
    <div class="container">
        <div class="row">
            <div class="col-md-1 sidebar">
                <a href="{{ route('orders.myfoodorders') }}" class="btn btn-primary btn-sm">My Orders</a>
            </div>
            <div class="col-md-11">
                <div class="titlepage">
                    <h2>Our Food Items</h2>
                    <p>Explore our delicious food options and choose your favorite.</p>
                </div>
            </div>
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
        
        @if ($errors->any())
            <div class="alert alert-danger">
               <ul>
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
               </ul>
            </div>
        @endif

        @if($foods->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <p>No food items have been added yet.</p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($foods as $food)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div id="serv_hover" class="food_item">
                            <div class="food_img">
                                <img style="height: 200px; width:350px" src="{{ Storage::url($food->image) }}" alt="Food Image" />
                            </div>
                            <div class="food_details">
                                <h5 style="text-transform: uppercase;">{{ $food->name }}</h5>
                                <p style="text-transform: uppercase;">Rs. {{ $food->price }}</p>
                               <form action="{{ route('order.place') }}" method="POST" onsubmit="return confirmOrder()">
                                  @csrf
                                  <input type="hidden" name="food_id" value="{{ $food->id }}">
                                  <input type="number" name="quantity" min="1" placeholder="Quantity" required style="width: 150px; height: 40px; font-size: 16px; padding: 5px; border-radius: 4px; border: 1px solid #ccc;">
                                  <button type="submit" class="btn-primary btn-sm" style="margin-top: -8px;">Order</button>
                               </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

</body>
</html>
@include('home.footer')
<style>
    .sidebar {
    padding: 20px;
    border-radius: 5px;
    }

    .sidebar a {
        padding: 10px;
        text-align: center;
        font-weight: bold;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 10px;
    }

    .sidebar a:hover {
        background-color: #0056b3;
    }

   .food_item {
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
   }

   .food_item:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
   }

   .food_img {
      overflow: hidden;
      border-radius: 2px;
   }

   .food_img img {
      width: 100%;
      height: auto;
      object-fit: cover;
      border-radius: 2px;
   }

   .food_details {
      text-align: center;
      margin-top: 15px;
   }

   .food_details h5 {
      font-size: 18px;
      font-weight: bold;
      color: #333;
   }

   .food_details p {
      font-size: 16px;
      color: #666;
      margin-bottom: 15px;
   }

   .food_details input {
      width: 80px;
      padding: 5px;
      margin-right: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
   }

   .food_details button {
      padding: 8px 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
   }

   .food_details button:hover {
      background-color: #0056b3;
   }

</style>
<script>
      function confirmOrder() {
         return confirm("Are you sure you want to order?");
      }
</script>


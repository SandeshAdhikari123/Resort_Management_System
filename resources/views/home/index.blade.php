<!DOCTYPE html>
<html lang="en">
   <head>
      @include('home.css')
   </head>
   <body class="main-layout">
      <header>
        @include('home.header')
      </header>
         @if (session('status'))
               <div class="alert alert-success">
                  {{ session('status') }}
               </div>
         @endif

         @if (session('error'))
               <div class="alert alert-danger">
                  {{ session('error') }}
               </div>
         @endif
        @include('home.banner')
        @include ('home.about')
        @include('home.room')
        @include('home.footer')

      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>
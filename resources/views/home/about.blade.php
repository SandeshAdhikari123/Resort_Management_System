<div class="about">
   <div class="container-fluid">
      <div class="row">
         @if($about)
         <div class="col-md-5">
            <div class="titlepage">
               <h2>About Us</h2>
               <!-- Dynamically display the About Us content from the database -->
               <p style="text-align: justify; line-height: 1.8;">{!! nl2br(e($about->aboutus)) !!}</p> <!-- Proper alignment and no double quotes -->
               <p><strong>{!! $about->phone !!}</strong>, <strong>{!! $about->email !!}</strong></p>
            </div>
         </div>
         <div class="col-md-7">
            <div class="about_img">
               <!-- Dynamically display the image -->
               <figure><img src="{{ asset('uploads/aboutus/' . $about->image) }}" alt="About Us Image"></figure>
            </div>
         </div>
         @else
         <p>About Us content is not available.</p>
         @endif
      </div>
   </div>
</div>
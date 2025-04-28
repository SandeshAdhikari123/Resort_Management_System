<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact</title>
  @include('home.header')
  <base href="/public">
  @include('home.css')
</head>
<body>
<div class="container" >
  <div class="row">
    <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 mt-2">
      <div class="card shadow-lg">
      <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center">
        <h3 class="mb-0">PROVIDE US YOUR FEEDBACK</h3>
      </div>
        <div class="card-body">
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
          <form method="POST" action="{{ route('contact.us.store') }}" id="contactUSForm">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter your name" value="{{ old('name', auth()->user()->name ?? '') }}">
              @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter your email" value="{{ old('email', auth()->user()->email ?? '') }}">
              @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="phone">Phone:</label>
              <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter your phone number" value="{{ old('phone', auth()->user()->phone ?? '') }}">
              @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="subject">Subject:</label>
              <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" id="subject" placeholder="Enter the subject of your message" value="{{ old('subject') }}">
              @if ($errors->has('subject'))
                <span class="text-danger">{{ $errors->first('subject') }}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="message">Message:</label>
              <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" id="message" placeholder="Enter your message">{{ old('message') }}</textarea>
              @if ($errors->has('message'))
                <span class="text-danger">{{ $errors->first('message') }}</span>
              @endif
            </div>
            <div class="form-group text-center mt-2">
              <button class="btn btn-primary btn-submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
@include('home.footer')
<style>
    .card-header {
    background-color: #007bff;
    padding: 20px;
    text-align: center;
    }
    .card-header h3 {
        color: #fff;
        margin: 0;
    }
    .card-body {
        padding: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-group input,
    .form-group textarea {
        padding: 10px;
        border: none;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        width: 100%;
        font-size: 16px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
    }
    .btn-submit {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #0069d9;
    }

</style>
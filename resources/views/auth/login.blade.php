@extends('user_layout.master')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <div class="container my-5">
        <h3>Login</h3>
        
        <form action="{{ route('login.process') }}" method="POST">
          @csrf
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" name="email" class="form-control" id="email"  placeholder="Enter email">
              @error('email')
                <div class="text text-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Password">
              @error('password')
                <div class="text text-danger">{{ $message }}</div>
              @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          {{-- <p>Don't have any account? Please <a href="">register here</a></p> --}}
    </div>
@endsection
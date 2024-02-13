@extends('authentication.master')

@section('content')
<main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1448375240586-882707db888b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1650&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 mx-auto">
            <div class="card z-index-0">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Register</h4>
                </div>
              </div>
              <div class="card-body">
                <form role="form" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group input-group-dynamic">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        @error('name')
                            <span class="text-danger d-block">*{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="input-group input-group-dynamic">
                            <label class="form-label" for="phone">Phone</label>
                            <input type="number" name="phone" class="form-control" id="phone">
                        </div>
                        @error('phone')
                            <span class="text-danger d-block">*{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="input-group input-group-dynamic">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        @error('password')
                            <span class="text-danger d-block">*{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                    </div>
                    <p class="text-sm mt-3 mb-0 text-center">Already have an account? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Sign in</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
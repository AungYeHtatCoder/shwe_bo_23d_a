<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('user_app/assets/css/style.css') }}">
    <!-- material icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/material-icons@1.13.11/iconfont/material-icons.min.css" />
    <!-- fontawesoome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>TTT 2D | 3D</title>
</head>

<body>
    <div class="container">
        <div class="row ">
            <div class="col-lg-4 mx-auto me-auto" style="position: relative;">
                <div class="card register-card">
                    <h5 class="mx-auto mt-3">TTT 2D | 3D</h5>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group m-2">
                            <!-- <label for="" class="form-label">Name</label> -->
                            <input type="text" name="name" placeholder="user name" class="form-control">
                        </div>
                        <div class="form-group m-2">
                            <!-- <label for="" class="form-label">Email</label> -->
                            <input type="text" name="email" placeholder="user@gmail.com" class="form-control">
                        </div>
                        <div class="form-group m-2">
                            <!-- <label for="" class="form-label">Phone</label> -->
                            <input type="text" name="phone" placeholder="phone number" class="form-control">
                        </div>
                        <div class="form-group m-2">
                            <!-- <label for="" class="form-label">Address</label> -->
                            <input type="text" name="address" placeholder="address" class="form-control">
                        </div>
                        <div class="form-group m-2">
                            <!-- <label for="" class="form-label">Password</label> -->
                            <input type="password" name="password" placeholder="password" class="form-control">
                        </div>
                        <div class="form-group m-2">
                            <input type="password" name="password_confirmation" placeholder="confirm password"
                                class="form-control">
                        </div>

                        <p>Have you benn already account? <a href="{{ route('login') }}"
                                style="text-decoration: none;color: #1aacac;">Login</a> Here!</p>
                        <div class="mx-auto mb-4">
                            {{-- <a href="" class="btn login-btn">Register</a> --}}
                            <button type="submit" class="btn login-btn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>

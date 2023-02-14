{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginPage</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<style>
    body {
        animation:fadeshow 0.75s;
        background-image: url({{ asset('background_image/backgorund_pizza_image.jpeg') }});
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100%;
    }

    .card {
        margin-top: 150px;
    }

    @keyframes fadeshow{
        from{
            opacity: 0;
            transform: rotateX(-10deg);
        }
        to{
            opacity: 1;
            transform: rotateX(0);
        }
    }
</style>

<body class="vh-100">
    <div class="col-2 offset-5">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Login Panel</h3>
                    <form action="{{ route("login") }}" method="POST">
                        @csrf
                        <input type="email" name="email" class="form-control mt-3" placeholder="Email" autofocus>
                        @error('email')
                            <small class="text-danger" style="font-size:12px">{{ $message }}</small>
                        @enderror
                        <input type="Password" name="password" class="form-control mt-3" placeholder="Password">
                        @error('password')
                            <small class="text-danger" style="font-size:12px">{{ $message }}</small>
                        @enderror
                        <input type="submit" class="btn btn-success mt-3 col-12" value="SIGNIN">
                    </form>
                    <a href="{{ url('registerPage') }}" class="text-dark float-end my-1"><small>didn't have account?</small></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html> --}}

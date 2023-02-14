<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf_token" value="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <!-- material icon cdn -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- box icon cdn -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</head>

<body>
    <nav style="z-index: 99" class="nav_bar">
        <ul class="title">
            <li class="{{ request()->is('user/home')? 'active' : ''; }}" onclick="this.childNodes[1].click()">
                <a href="{{ route('user#home') }}" >Home</a>
            </li>
            <li class="{{ request()->is('user/cart')? 'active' : ''; }}" onclick="this.childNodes[1].click()">
                <a href="{{ route('user#cart') }}" class="cart">Cart</a>
                <div class="bdges">
                    <span class="cart_no" @if (count($cart) > 9)  style="margin-left:5px !important;"  @endif>{{ count($cart) }}</span>
                </div>
            </li>
            <li class="{{ request()->is('user/history*')? 'active' : ''; }} ms-3" onclick="this.childNodes[1].click()">
                <a href="{{ route('user#history') }}">History</a>
            </li>
            <li class="" onclick="this.childNodes[1].click()">
                <a href="#footer">Contact</a>
            </li>
        </ul>

        <ul class="action">
            <li class="info" style="margin-right: 20px">
                <i class="material-icons">account_circle</i>
                @if (strlen( auth()->user()->name ) < 8)
                    <span class="text-capitalize">{{ auth()->user()->name }}</span>
                @else
                    <span class="text-capitalize" style="white-space: nowrap">{{ substr( auth()->user()->name ,0,5) }}...</span>
                @endif
            </li>
            <li>
                <div class="dropdown1" id="dropdown" data-dropdown>
                    <button class="dropdown_btn" data-dropdown-button style="z-index: 99"><i class="material-icons" id="dropdown_btn">arrow_drop_down</i></button>
                    <ul class="dropdown_content" style="overflow:hidden;">
                        <li onclick="this.childNodes[1].submit()">
                            <a href="{{ route('user#account') }}" style="font-size: 1rem">Account</a>
                        </li>
                        {{-- <li onclick="this.childNodes[1].submit()">
                            <a href="javascript:{}" style="white-space: nowrap">Change Password</a>
                        </li> --}}
                        <li onclick="this.childNodes[1].submit()">
                            <form action="{{ route('logout') }}" method="POST" class="text-dark text-center">
                                @csrf
                                <div class="d-flex justify-content-center log_out" style="margin-left: 30%;font-size:1rem">
                                    <i class="material-icons">logout</i>
                                    <span>Log_out</span>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
    <div class="path">
        <ul>
            <?php $array=explode('/',url()->current()); ?>
            <li>
                <span class="text-capitalize">{{ $array[3] }}</span>
            </li>
            <li>
                <span>/</span>
            </li>
            <li>
                <span class="text-capitalize">{{ $array[4] }}</span>
            </li>
            @if (isset($array[5]))
            <li>
                <span>/</span>
            </li>
            <li>
                <span>
                    <span class="text-capitalize">{{ $data->product_name }}</span>
                </span>
            </li>
            @endif
        </ul>
    </div>
    <!-- body start -->
    <div class="wrapper mt-4">
        @yield('content')
    </div>
    <!-- body end -->

    <!-- footer start -->
    <div class="footer" id="footer">
        <div class="row">
            <div class="col-3">
            </div>
            <div class="col-6 contact align-content-center">
                <form action="{{ route('contact') }}" id="contact_form" method="post">
                    @csrf
                    <div id="title">
                        <h5>Contact :</h5>
                    </div>
                    <div class="email_gp">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" class="form-control contact_info w-75" placeholder="example@gmail.com">
                    </div><br>
                    <div class="msg_gp">
                        <label for="message">Message :</label>
                        <input type="text" id="message" name="message" class="form-control contact_info w-75" placeholder="...">

                    </div><br>
                    <button type="submit" class="btn btn-secondary form-control d-block" style="width:20%;margin-left:60%">Send</button>
                </form>
                <div class="social_icon">
                    <i class='bx bxl-facebook-square'></i>
                    <i class='bx bxl-instagram-alt'></i>
                    <i class='bx bxl-twitter'></i>
                </div>
            </div>
            <div class="col-3">
            </div>
        </div>
    </div>
    <!-- end footer -->

    <a href="javascript:{}" class="scroll_up"><i class="material-icons">
        keyboard_arrow_up
        </i></a>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="{{ asset('user/js/code.js') }}"></script>
<script>
    $(document).ready(function(){

        $('#contact_form').submit(function(e){
            $('.contact_info').removeClass('is-invalid');
            $('.error_msg').remove();

            $url =$(this).attr('action');
            $form =$('#contact_form').serialize();

            // console.log($form.split("&"));

            // console.log($form);  //email=admin%40gmail.com
            // console.log(decodeURIComponent($form.replace(/%40/g, "@"))); //admin@gmail.com

            $.ajaxSetup({ header:{ 'csrftoken' : '{{ csrf_token() }}' } });
            $.ajax({
                type:'post',
                url: $url,
                data: $form
            })
            .done(function(res){
                if(res.errors){
                    if(res.errors.email){
                        $('#email').addClass('is-invalid');
                        $('.email_gp').append(`
                        <small class="text-danger error_msg">${res.errors.email}</small>
                        `);
                    }
                    if(res.errors.message){
                        $('#message').addClass('is-invalid');
                        $('.msg_gp').append(`
                        <small class="text-danger error_msg">${res.errors.message}</small>
                        `);
                    }
                }
                if(res.status== 'success'){
                    $('#title').append(`
                    <div class="alert alert-success info_alert w-50" style="margin-left:15%" role="alert">
                      Message Success
                    </div>
                    `)

                    setTimeout(() => {
                        $('.info_alert').remove();
                    }, 1000);
                    $('#email').val('');
                    $('#message').val('');
                }
            })
            e.preventDefault();

        })
    })
</script>
    @yield('script')
</html>

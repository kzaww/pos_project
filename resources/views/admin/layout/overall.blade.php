<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('admin/style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</head>

@yield('style')


<body style="background-color: rgb(212, 212, 212);">
    <div class="sidebar">
        <div class="sidebar_header">
            <div class="logo">
                <span class="">Logo</span>
            </div>
        </div>
        <div class="sidebar_body">
            <ul>
                <li class="{{ (request()->is('chart'))? 'active':''; }}">
                    <a href="{{ route('admin#chartList') }}"><span>Charts</span></a>
                </li>
                <li class="{{ (request()->is('category/*'))? 'active':''; }}">
                    <a href="{{ route('admin#categoryList') }}" ><span>Category</span></a>
                </li>
                <li class="{{ (request()->is('order/*'))? 'active':''; }}">
                    <a href="{{ route('admin#orderList') }}" ><span>Order</span></a>
                </li>
                <li class="drop {{ (request()->is('account/*'))? 'active':''; }}">
                    <a href="javascript:{}" class="auth_btn"><span>Accounts</span>
                        <i class='bx bxs-down-arrow first'></i>
                    </a>
                    <ul class="show">
                        <li class="{{ (request()->is('account/profile'))? 'sub_active':''; }}">
                            <a href="{{ route('admin#accountDetail') }}"><span>profile</span></a>
                        </li>
                        <li class="{{ (request()->is('account/adminList')||(request()->is('account/userList')))? 'sub_active':''; }}">
                            <a href="{{ route('admin#adminList') }}"><span>Users List</span></a>
                        </li>
                        <li class="{{ (request()->is('contact'))? 'sub_active':''; }}">
                            <a href="{{ route('admin#contact') }}"><span>Contact</span></a>
                        </li>
                    </ul>
                </li>
                <li class="{{ (request()->is('product/*'))? 'active':''; }}">
                    <a href="javascript:{}" class="doc_btn"><span>Product</span>
                        <i class='bx bxs-down-arrow second'></i>
                    </a>
                    <ul class="show_1">
                        <li class="{{ (request()->is('product/list')||request()->is('product/create')||request()->is('product/edit*')||request()->is('product/details*'))? 'sub_active':''; }}">
                            <a href="{{ route('admin#productList') }}"><span>List</span></a>
                        </li>
                        <li>
                            <a href="javascript:{}"><span>Factory</span></a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <form action="{{ route('logout') }}" method="post" id="ff">
                        @csrf
                        <a href="javascript:$('#ff').submit();">
                            <span>LogOut</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="main_content" >
        {{-- header --}}
        <div class="header" >
            <div class="header_content">
                <h3 >Admin Dashboard Panal</h3>
            </div>
            <div class="profile">
                <div class="image">
                    <img @if(auth()->user()->image == null) src="{{ asset('admin/defaultImage/download (1).png') }}" @else src="{{ asset('admin/userImage/'.auth()->user()->image) }}"    @endif alt="">
                </div>
                <div class="pro_name">
                    @if (strlen( auth()->user()->name ) < 8)
                        <span >{{ auth()->user()->name }}</span>
                    @else
                        <span >{{ substr( auth()->user()->name ,0,5)  }}..</span>
                    @endif

                </div>
            </div>
        </div>
        {{-- end header --}}
        @yield('content')
    </div>
</body>

<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $('.auth_btn').click(function() {
        $('.first').toggleClass("rotate");
        $('.show').toggleClass("visible");
        $('body').toggleClass("child");
    });

    $('.doc_btn').click(function() {
        $('.second').toggleClass("rotate");
        $('.show_1').toggleClass("visible");
        $('body').toggleClass("child1");
    });

    // $(document).ready(function(){
    //     console.log($('meta[name="_token"]').attr('content'));
    //     console.log('{{ csrf_token() }}');
    // })
</script>

@yield('script')

</html>

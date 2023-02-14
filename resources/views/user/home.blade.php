@extends('user.layout.layout')

@section('title','Shop')

@section('content')
    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-4">
            <div class="col-8 offset-2">
                <h4 class="section_title text-uppercase">Category</h4>
                <div class="category_card">
                    <ul>
                        <li class="">
                            <a href="javascript:{}" class="sorting" data-sort_type="Asc">
                                <span style="font-weight: 600">All</span>
                              <input type="button" name="" value="{{ count($category) }}" style="transform: translateY(-8px);border:none;font-size:15px;border-radius:4px">
                            </a>
                        </li>
                        @foreach ($category as $cat)
                            <li class="" onclick="">
                                <a href="javascript:{}" class="catFilter" data-category_filter="{{ $cat->category_id }}">
                                    <span class="text-capitalize">{{ $cat->category_name }}</span>
                                    <!-- <input type="checkbox" name=""> -->
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <h4 class="section_title1 text-uppercase mt-3">Price</h4>
                <div class="Price_card">
                    <ul>
                        <li>
                            <a href="javascript:{}" class="priceFilter" data-price_filter="1">
                                <span>&#60;20000</span>
                                <!-- <input type="checkbox" name=""> -->
                            </a>
                        </li>
                        <li>
                            <a href="javascript:{}" class="priceFilter" data-price_filter="2">
                                <span>20000~30000</span>
                                <!-- <input type="checkbox" name=""> -->
                            </a>
                        </li>
                        <li>
                            <a href="javascript:{}" class="priceFilter" data-price_filter="3">
                                <span>&#62;30000</span>
                                <!-- <input type="checkbox" name=""> -->
                            </a>
                        </li>
                    </ul>
                </div>

                <button class="btn btn-warning form-control mt-4 d-flex justify-content-center">
                    <i class="material-icons fs-5 mt-1">shopping_cart</i>
                    <span>order</span>
                </button>
            </div>
        </div>
        <div class="col-md-8 col-lg-8 col-sm-7" style="overflow-x:hidden;">
            <div class="dropdown mb-3" style="margin-left:93%">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Sort
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item sorting" data-sort_type="Asc" href="javascript:{}">Default</a></li>
                  <li><a class="dropdown-item sorting" data-sort_type="Desc" href="javascript:{}">Desc By Date</a></li>
                  <li><a class="dropdown-item sorting" data-sort_type="atoz" href="javascript:{}">A~Z</a></li>
                </ul>
              </div>
              <input type="text" id="user_id" value="{{ auth()->user()->id }}" hidden>
            <div class="row" id="sort_data">
                @foreach ($data as $item)
                <div class="col-md-4 col-sm-6">
                    <div class="list_item mb-3" style="user-select: none" data-cart>
                        <div class="img_container">
                            <img src="{{ asset('storage/'.$item->product_image) }}" alt="">
                            <div class="product_action">
                                <a href="{{ route('user#details',$item->product_id) }}"><i class="material-icons">info</i></a>
                                <a href="javascript:{}" class="cart_active" data-cart-button><i class="material-icons cc" onclick="parentNode.click()">shopping_cart</i></a>
                            </div>
                        </div>
                        <div class="d-flex cart_container">
                            <div class="input-group btn_gp1 input-group-sm">
                                <button class="btn btn-primary btn_minus"><i class="material-icons mt-1">remove</i></button>
                                <input type="text" class="form-control pl_mi" value="0">
                                <button class="btn btn-primary btn_plus"><i class="material-icons mt-1">add</i></button>
                            </div>
                            <button class="cart_ic btn btn-primary"><i class="material-icons mt-1">shopping_cart</i></button>
                        </div>
                        <div class="container text-center ">
                            <h4 class="text-primary">{{ $item->product_name }}</h4>
                            <div class="mt-3">
                                <span class="h5">{{ $item->product_price }} Ks</span>
                                <input type="text" class="product_id" value="{{ $item->product_id }}" hidden>
                            </div>
                            <div class="view_count">
                                <small class="d-flex fs-7"><i class="material-icons fs-7">visibility</i><span style="margin: 2px 0 0 5px">{{ $item->view_count }}</span></small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="cartAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" id="alertClose" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center h5 text-success">
            Insert Into Cart Success!
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="orderAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" id="alertClose" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center h5 text-success">
            Order Success
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $(document).on('click','.sorting',function(){
                var order_type = $(this).data('sort_type');
                    $.ajax({
                        type:'get',
                        url:'http://127.0.0.1:8000/user/ajax/pizza/list',
                        data : {'status' : order_type},
                        dataType:'json',
                        success:function(res){
                            $list = '';
                            for($i=0;$i<res.length;$i++){
                                $list += `
                                <div class="col-md-4 col-sm-6">
                                    <div class="list_item mb-3" style="user-select: none" data-cart>
                                        <div class="img_container">
                                            <img src="{{ asset('storage/${res[$i].product_image}') }}" alt="">
                                            <div class="product_action">
                                                <a href="{{ url('user/details/${res[$i].product_id}') }}"><i class="material-icons">info</i></a>
                                                <a href="javascript:{}" class="cart_active" data-cart-button><i class="material-icons cc" onclick="parentNode.click()">shopping_cart</i></a>
                                            </div>
                                        </div>
                                        <div class="d-flex cart_container">
                                            <div class="input-group btn_gp1 input-group-sm">
                                                <button class="btn btn-primary btn_minus"><i class="material-icons mt-1">remove</i></button>
                                                <input type="text" class="form-control pl_mi" value="0">
                                                <button class="btn btn-primary btn_plus"><i class="material-icons mt-1">add</i></button>
                                            </div>
                                            <button class="cart_ic btn btn-primary"><i class="material-icons mt-1">shopping_cart</i></button>
                                        </div>
                                        <div class="container text-center ">
                                            <h4 class="text-primary">${res[$i].product_name}</h4>
                                            <div class="mt-3">
                                                <span class="h5">${res[$i].product_price} Ks</span>
                                                <input type="text" class="product_id" value="${res[$i].product_id}" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            }
                            $('#sort_data').html($list);
                        }
                    });

            })

            $('.catFilter').click(function(){
                var catId = $(this).data('category_filter');
                // console.log(catId);
                $.ajax({
                    type:'get',
                    url:'http://127.0.0.1:8000/user/ajax/filter/category',
                    data: {'status':catId},
                    dataType:'json',
                    success:function(res){
                        $list = '';
                        if(res.length == 0){
                            $list = `
                                <div class="bg-secondary text-white text-center" style="min-height: 80vh;line-height:80vh">
                                    <span class="h3">There is no Data</span>
                                </div>
                            `
                        }else{
                            for($i=0;$i<res.length;$i++){
                                $list += `
                                <div class="col-md-4 col-sm-6">
                                    <div class="list_item mb-3" style="user-select: none" data-cart>
                                        <div class="img_container">
                                            <img src="{{ asset('storage/${res[$i].product_image}') }}" alt="">
                                            <div class="product_action">
                                                <a href="{{ url('user/details/${res[$i].product_id}') }}"><i class="material-icons">info</i></a>
                                                <a href="javascript:{}" class="cart_active" data-cart-button><i class="material-icons cc" onclick="parentNode.click()">shopping_cart</i></a>
                                            </div>
                                        </div>
                                        <div class="d-flex cart_container">
                                            <div class="input-group btn_gp1 input-group-sm">
                                                <button class="btn btn-primary btn_minus"><i class="material-icons mt-1">remove</i></button>
                                                <input type="text" class="form-control pl_mi" value="0">
                                                <button class="btn btn-primary btn_plus"><i class="material-icons mt-1">add</i></button>
                                            </div>
                                            <button class="cart_ic btn btn-primary"><i class="material-icons mt-1">shopping_cart</i></button>
                                        </div>
                                        <div class="container text-center ">
                                            <h4 class="text-primary">${res[$i].product_name}</h4>
                                            <div class="mt-3">
                                                <span class="h5">${res[$i].product_price} Ks</span>
                                                <input type="text" class="product_id" value="${res[$i].product_id}" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            }
                        }
                        $('#sort_data').html($list);
                    }
                })
            })

            $('.priceFilter').click(function(){
                var pri = $(this).data('price_filter');
                // console.log(pri);
                $.ajax({
                    type:'get',
                    url:'http://127.0.0.1:8000/user/ajax/filter/price',
                    data: {'status':pri},
                    dataType:'json',
                    success:function(res){
                        $list = '';
                        if(res.length == 0){
                            $list = `
                                <div class="bg-secondary text-white text-center" style="min-height: 80vh;line-height:80vh">
                                    <span class="h3">There is no Data</span>
                                </div>
                            `
                        }else{
                            for($i=0;$i<res.length;$i++){
                                $list += `
                                <div class="col-md-4 col-sm-6">
                                    <div class="list_item mb-3" style="user-select: none" data-cart>
                                        <div class="img_container">
                                            <img src="{{ asset('storage/${res[$i].product_image}') }}" alt="">
                                            <div class="product_action">
                                                <a href="{{ url('user/details/${res[$i].product_id}') }}"><i class="material-icons">info</i></a>
                                                <a href="javascript:{}" class="cart_active" data-cart-button><i class="material-icons cc" onclick="parentNode.click()">shopping_cart</i></a>
                                            </div>
                                        </div>
                                        <div class="d-flex cart_container">
                                            <div class="input-group btn_gp1 input-group-sm">
                                                <button class="btn btn-primary btn_minus"><i class="material-icons mt-1">remove</i></button>
                                                <input type="text" class="form-control pl_mi" value="0">
                                                <button class="btn btn-primary btn_plus"><i class="material-icons mt-1">add</i></button>
                                            </div>
                                            <button class="cart_ic btn btn-primary"><i class="material-icons mt-1">shopping_cart</i></button>
                                        </div>
                                        <div class="container text-center ">
                                            <h4 class="text-primary">${res[$i].product_name}</h4>
                                            <div class="mt-3">
                                                <span class="h5">${res[$i].product_price} Ks</span>
                                                <input type="text" class="product_id" value="${res[$i].product_id}" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            }
                        }
                        $('#sort_data').html($list);
                    }
                })
            })

            $(document).on('click','.cart_ic',function(){
                $userId = $('#user_id').val();
                $productId = $(this).parents('.list_item').find('.product_id').val();
                $quantity = $(this).parents('.list_item').find('.pl_mi').val();
                $data = {
                    'user_id' : $userId,
                    'product_id' : $productId,
                    'quantity' : $quantity
                }
                $.ajax({
                    type:'get',
                    url:"http://127.0.0.1:8000/user/ajax/cart",
                    data: {'data':$data},
                    dataType:'json',
                    success:function(res){
                        if(res.status == '200'){
                            window.location.href = 'http://127.0.0.1:8000/user/home';
                            sessionStorage.setItem("cartSuccess","200");
                        };
                    }
                })
            })

            if(sessionStorage.getItem("cartSuccess") == "200"){
                $('#cartAlert').modal('show');

                setInterval(() => {
                    $('#cartAlert').modal('hide');
                    sessionStorage.removeItem("cartSuccess");
                }, 1000);
            }

            if(sessionStorage.getItem("order") == "success"){
                $('#orderAlert').modal('show');

                setInterval(() => {
                    $('#orderAlert').modal('hide');
                    sessionStorage.removeItem("order");
                }, 1000);
            }

            $('#alertClose').click(function(){
                sessionStorage.removeItem("cartSuccess");
            })

            $(document).on('click','.btn_gp1 button',function(e){
                e.preventDefault();
                $btn = $(this);
                // console.log($btn);
                $old = $btn.parent().find('.pl_mi').val();
                if($btn.hasClass('btn_plus')){
                    $new = ($old*1) +1;  //value  ka sting type mo lo integer type change ag 1 ne multiply
                }else{
                    if($old > 0){
                        $new = ($old*1) -1;
                    }else{
                        $new = 0;
                    }
                }
                $btn.parent().find('.pl_mi').val($new);
            })
        })

        document.addEventListener('click',e=>{
            let dropdownBtn = e.target.matches("[data-cart-button]");
            if(!dropdownBtn && e.target.closest('[data-cart]') != null) return;

            let currentDrop
            if(dropdownBtn){
                currentDrop = e.target.closest('[data-cart]');
                currentDrop.classList.toggle('active_cart');
                if(!currentDrop.classList.contains('active_cart')){
                    currentDrop.querySelector('.pl_mi').value = '0';
                }
            }

            document.querySelectorAll('[data-cart].active_cart').forEach(cart =>{
                if(cart ===currentDrop)return
                cart.classList.remove('active_cart')
                cart.querySelector('.pl_mi').value='0'
            });
        })
    </script>
@endsection

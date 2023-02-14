@extends('user.layout.layout')

@section('title','Details')

@section('content')
    <!-- body start -->
    <div class="detail_wrapper">
        <div class="row">
            <div class="col-md-5">
                <div class="item_box">
                    <img src="{{ asset('storage/'.$data->product_image) }}" alt="">
                </div>
            </div>
            <div class="col-md-7">
                <div class="order_box">
                    <?php $array=explode('/',url()->current()); ?>
                    <h2>{{ $data->product_name }}</h2>
                    <span class="d-flex my-2"><i class="material-icons see_icn">visibility</i>{{ $data->view_count +1 }}</span>
                    <h5>{{ $data->product_price }} Kyats</h5>
                    <p>{{ $data->description }}</p>
                    <div class="d-flex mt-4 btn_container">
                        <div class="input-group btn_gp input-group-sm">
                            <button class="btn btn-primary btn_minus"><i class="material-icons mt-1">remove</i></button>
                            <input type="text" class="form-control pl_mi" value="1">
                            <button class="btn btn-primary btn_plus"><i class="material-icons mt-1">add</i></button>
                        </div>
                        <button class="cart_ic btn btn-primary"><i class="material-icons mt-1">shopping_cart</i></button>
                    </div>
                    <input type="text" value="{{ $array[5] }}" hidden id="pizza_id">
                    <input type="text" value="{{ auth()->user()->id }}" id="user_id" hidden>
                </div>
            </div>
        </div>

        <div class="carousal_title">YOU MAY ALSO LIKE</div>
        <div class="carousal_container">
            <i id="prev_btn" class="material-icons mt-1 next_prev">navigate_before</i>
            <div class="carousal">
                @foreach ($product as $item)
                    <div class="img_container1">
                        <img src="{{ asset('storage/'.$item->product_image) }}" alt="">
                        <div class="icon_gp">
                            <a href="{{ route('user#details',$item->product_id) }}"><i class="material-icons">info</i></a>
                            {{-- <a href="javascript:{}" class=""><i class="material-icons">shopping_cart</i></a> --}}
                        </div>
                    </div>
                @endforeach
            </div>
            <i id="next_btn" class="material-icons mt-1 next_prev" @if (count($product) <= 4) hidden @endif>navigate_next</i>
        </div>
    </div>
    <!-- body end -->
@endsection

@section('script')
<script src="{{ asset('user/js/detail.js') }}"></script>
<script>
    $(document).ready(function(){
        $data = {
            'product_id' : $('#pizza_id').val(),
            'user_id' : $('#user_id').val()
        }
        $.ajaxSetup({ header:{ 'csrftoken' : '{{ csrf_token() }}' } })
        $.ajax({
            type : 'get',
            url: '{{ route('viewCount') }}',
            data: $data,
        })

        $('.cart_ic').click(function(){
            $quty = $(this).parent().find('input').val()*1;
            $pzid = $('#pizza_id').val();
            $usid = $('#user_id').val();

            $data = {
                'quantity' : $quty,
                'product_id' : $pzid,
                'user_id' : $usid
            }
            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/user/ajax/cart',
                data : {'data' : $data},
                success: function(res){
                    // console.log(res.status);
                    if(res.status == '200'){
                        window.location.href = 'http://127.0.0.1:8000/user/home';
                        sessionStorage.setItem("cartSuccess","200");
                    };
                }
            })
            $(this).parent().find('input').val(0);
        })
    })
</script>
@endsection

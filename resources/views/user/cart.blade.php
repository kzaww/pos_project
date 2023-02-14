@extends('user.layout.layout')

@section('title','Cart')

@section('content')
    <!-- body start -->
    <div class="cart_wrapper row offset-1 my-3">
        <div class="col-7">
            <div class="bg-white" style="width: 98%;padding:10px 20px;min-height: 80vh;">
                <table class="table table-borderless" id="cart_table" style="border-collapse: separate;border-spacing:0 15px;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <input type="text" id="user_id" value="{{ auth()->user()->id }}" hidden>
                        <?php $i=1; ?>
                        @foreach ( $cart as $item)
                        <tr class="bg-secondary text-white align-middle t_b">
                            <td class="no"><?php echo($i); ?></td>
                            <td class="">{{ $item->name }}</td>
                            <td class="product_id" hidden>{{ $item->product_id }}</td>
                            <td class="created_at" hidden>{{ $item->created_at }}</td>
                            <td class="col-3">
                                <div class="input-group btn_gp input-group-sm" style="width: 100px;">
                                    <button class="btn btn-primary btn_minus " style="width: 30px;height:30px;"><i class="material-icons fs-6" style="margin-top: 4px;transform: translateX(-2px);">remove</i></button>
                                    <input type="text" class="form-control pl_mi" value="{{ $item->quantity }}" style="height: 30px;border: none;">
                                    <button class="btn btn-primary btn_plus " style="width: 30px;height:30px;"><i class="material-icons fs-6" style="margin-top: 4px;transform: translateX(-2px);">add</i></button>
                                </div>
                            </td>
                            <td class="price">{{ $item->price }} Kyats</td>
                            <td class="total_price">{{ $item->price * $item->quantity }} Kyats</td>
                            <td class="">
                                <button class="btn btn-danger pb-3 btn_bin" style="width: 35px;height:35px;"><i class="material-icons fs-5" style="transform: translateX(-5px);">delete</i></button>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> --}}
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-4">
            <div class="bg-white py-3 px-5" style="height:250px">
                <div class="d-flex mb-2">
                    <h5>Pizza Price :</h5>
                    <span class="paycheck" style="margin-left: 100px;">{{ $total }} Kyats</span>
                </div>
                <div class="d-flex mb-2">
                    <h5>Delivery Fee :</h5>
                    <span class="deli_fee" style="margin-left: 85px;">3000 Kyats</span>
                </div>
                <div class="mb-2" style="border-top:dotted 1px rgb(0, 0, 0,0.5); "></div>
                <div class="d-flex mb-2">
                    <h5 class="mt-2">Total Price :</h5>
                    <span style="margin-left: 103px;"><span class="text-success fs-4 con_pay" style="font-weight:700"></span> Kyats</span>
                </div>
                <button class="btn btn-primary form-control con_order">Confirm Order</button>
                <button class="btn btn-danger form-control mt-2 cl_cart">Clear Cart</button>
            </div>
        </div>
    </div>
    <!-- body end -->

<!-- Modal -->
<div class="modal fade" id="clearConfirm" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" id="alertClose" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center h5 text-danger">
            Are You Sure?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Cancel">No</button>
            <button type="button" class="btn btn-secondary confirm_clear">Yes</button>
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="fku" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center h5 text-success">
            Fuck You!!
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script>

        window.onload = ()=>{
            let pay = document.querySelector('.paycheck').innerText.replace(' Kyats','')*1;
            let deli = document.querySelector('.deli_fee').innerText.replace(' Kyats','')*1;
            let confirm = document.querySelector('.con_pay');
            confirm.innerText = pay+deli;
        }

        //start jquery
        $(document).ready(function(){
            $('.btn_gp button').on('click', function() {
                var button = $(this);
                var oldValue = button.parent().find('input').val();
                var price = Number(button.parent().parent().parent().find('.price').text().replace(" Kyats",""));
                if (button.hasClass('btn_plus')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }

                $totalPrice = newVal*price+" Kyats";
                button.parent().parent().parent().find('.total_price').text($totalPrice);
                button.parent().find('input').val(newVal);

                // $('#table_body .t_b').each((index,row)=>{
                //     console.log($(row).find('.total_price').text());
                // })
                Paycalc()
            });

            $('.btn_bin').click(function(){
                $(this).parents('tr').remove();
                Paycalc();
                $i= 1;
                $('.no').each(function(index,row){
                    $(row).text($i);   //row ko kaw yin $(row) ne kaw
                    $i++;
                })
                var ll = $('.no').length;
                $('.cart_no').text(ll);

                $source = {
                    'product_id' : $(this).parents('tr').find('.product_id').text(),
                    'created_at' : $(this).parents('tr').find('.created_at').text()
                }

                $.ajax({
                    type:'get',
                    url:'http://127.0.0.1:8000/user/ajax/clear/cart',
                    data: $source,
                    dataType:'json',
                    success:function(res){

                    }
                })
            })

            //function
            function Paycalc(){
                $total = 0;
                document.querySelectorAll('#table_body .t_b').forEach(tb=>{
                    $total +=tb.querySelector('.total_price').innerText.replace(' Kyats','')*1;
                })

                $('.paycheck').text($total+' Kyats');

                let pay = document.querySelector('.paycheck').innerText.replace(' Kyats','')*1;
                let deli = document.querySelector('.deli_fee').innerText.replace(' Kyats','')*1;
                let confirm = document.querySelector('.con_pay');
                confirm.innerText = pay+deli;
            }

            $(document).on('click','.cl_cart',function(){
                if($('#cart_table tbody tr').length > 0){
                $('#clearConfirm').modal('show');
                }else{
                    $('#fku').modal('show');
                    setTimeout(() => {
                        $('#fku').modal('hide');
                    }, 2000);
                }
            })

            $(document).on('click','.confirm_clear',function(){
                $.ajax({
                    type:'get',
                    url:'http://127.0.0.1:8000/user/ajax/clearCart',
                    dataType:'json',
                    data : {'data':'clear'},
                    success:function(res){
                    }
                })
                $('#clearConfirm').modal('hide');
                $('#cart_table tbody tr').remove();
                $('.cart_no').text('0');
                $('.paycheck').text('0 Kyats');

                let pay = document.querySelector('.paycheck').innerText.replace(' Kyats','')*1;
                let deli = document.querySelector('.deli_fee').innerText.replace(' Kyats','')*1;
                let confirm = document.querySelector('.con_pay');
                confirm.innerText = pay+deli;
            })

            $('.con_order').click(function(){
                if($('#cart_table tbody tr').length > 0){
                    $cart = [];
                    let result = '';
                    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    const charactersLength = characters.length;
                    let counter = 0;
                    while (counter < 3) {
                      result += characters.charAt(Math.floor(Math.random() * charactersLength));
                      counter += 1;
                    }
                    let ranCode = result+Math.floor(Math.random()*(999999 - 100000)+1000000);
                    $('#cart_table tbody tr').each(function(index,row){
                        $cart.push({
                            'user_id' : $('#user_id').val(),
                            'product_id': $(row).find('.product_id').text(),
                            'quantity' : $(row).find('.pl_mi').val()*1,
                            'total' : $(row).find('.total_price').text(),
                            'order_code' : ranCode
                        })
                    })

                    $cart = Object.assign({},$cart);
                    $total_price = {'total_price': $('.con_pay').text()*1};
                    $source = {
                        orderList : $cart,
                        totalval :$total_price
                    }
                    $.ajax({
                        type:'get',
                        url:'http://127.0.0.1:8000/user/ajax/orderList',
                        data: $source,
                        dataType:'json',
                        success: function(res){
                            if(res.order == 'success'){
                                window.location.href = 'http://127.0.0.1:8000/user/home';
                                sessionStorage.setItem('order','success');
                            }
                        }
                    })
                }else{
                    $('#fku').modal('show');
                    setTimeout(() => {
                        $('#fku').modal('hide');
                    }, 2000);
                }
            })
        })
    </script>
@endsection

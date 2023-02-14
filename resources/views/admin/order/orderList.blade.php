@extends('admin.layout.overall')

@section('title','Order List')

@section('content')
    {{-- content --}}
        <div class="content">
            <div class="label mt-3 d-flex" style="position: relative;">
              <h2>Order List</h2>
                    <div class="d-flex" style="margin-left: 250px">
                        <input type="text" class="form-control" name="key" id="search_val"  placeholder="search..." style="width:400px">
                    </div>

                <h3 class="" style="position: absolute;right:0">Total : (<b class="text-success" id="count">{{ $data->total() }}</b>)</h3>

            </div>
              <div class="table_data">
                <table class="table table-borderless mt-1" style="border-collapse:separate;border-spacing:0 15px;">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th>User Name</th>
                          <th>Date</th>
                          <th>Order Code</th>
                          <th>Total Price</th>
                          <th>Status</th>
                      </tr>
                    </thead>
                    <tbody class="table_body">
                      <?php $i =(($data->currentPage()-1)*$data->perPage() +1); ?>
                      @foreach ($data as $item)
                          <tr class="align-middle tb_content">
                              <td>{{ $i }}</td>
                              <td class="order_id" hidden>{{ $item->order_id }}</td>
                              <td class="name">{{ $item->name }}</td>
                              <td>{{ $item->created_at->format('j/M/Y h:i:s') }}</td>
                              <td><a href="{{ route('admin#orderDetails',$item->order_code) }}" class="text-decoration-none">{{ $item->order_code }}</a></td>
                              <td>{{ $item->total_price }} Kyats</td>
                              <td>
                                  <div class="dropdown1" data-dropdown>
                                      @if ($item->status == '0')
                                      <button class="icon align-middle dddd bg-warning text-white" title="Change Status" data-dropdown-button>Pending</button>
                                      @elseif ($item->status == '1')
                                      <button class="icon align-middle dddd bg-success text-white" title="Change Status" data-dropdown-button>Success</button>
                                      @elseif ($item->status == '2')
                                      <button class="icon align-middle dddd bg-danger text-white" title="Change Status" data-dropdown-button>Rejected</button>
                                      @endif
                                          <ul class="dropdown_content1" style="z-index:9999;height:80px;padding:0;">
                                              <li class="status_change" data-status="0">Pending...</li>
                                              <li class="status_change" data-status="1">Success</li>
                                              <li class="status_change" data-status="2">Reject</li>
                                          </ul>
                                  </div>
                              </td>
                          </tr>

                          <?php $i++;?>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="d-flex justify-content-center pag">
                      {!!  $data->links() !!}
                  </div>
              </div>
          </div>

    {{-- end content --}}

@endsection


@section('script')
    <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>
    <script>
        document.addEventListener('click',e=>{
        let dropdownBtn = e.target.matches("[data-dropdown-button]");
        if(!dropdownBtn && e.target.closest('[data-dropdown]') != null) return;

        let currentDrop
        if(dropdownBtn){
            currentDrop = e.target.closest('[data-dropdown]');
            currentDrop.classList.toggle('auto');
        }

        document.querySelectorAll('[data-dropdown].auto').forEach(dropdown =>{
            if(dropdown ===currentDrop)return
            dropdown.classList.remove('auto')
        });
    })

    $(document).ready(function(){

        $(document).on('click','.status_change',function(){

            $status = $(this).data('status');
            $id =$(this).parents('.tb_content').find('.order_id').text();
            $source={
                'status' : $status,
                'order_id': $id
            }
            $(this).parents('.dropdown1').removeClass('auto');
            $el = $(this).parents('.dropdown1');

            $.ajax({
                type:'get',
                url:"http://127.0.0.1:8000/order/ajax/list",
                data: $source,
                dataType:'json',
                success:function(res){
                    if(res.message == 'pending'){
                        $list = `
                        <button class="icon align-middle dddd bg-warning text-white" title="Change Status" data-dropdown-button>Pending</button>
                        `;
                    }else if(res.message == 'success'){
                        $list = `
                        <button class="icon align-middle dddd bg-success text-white" title="Change Status" data-dropdown-button>Success</button>
                        `;
                    }else if(res.message == 'reject'){
                        $list = `
                        <button class="icon align-middle dddd bg-danger text-white" title="Change Status" data-dropdown-button>Rejected</button>
                        `;
                    }
                    $list += `

                    <ul class="dropdown_content1" style="z-index:9999;height:80px;padding:0;">
                        <li class="status_change" data-status="0">Pending...</li>
                        <li class="status_change" data-status="1">Success</li>
                        <li class="status_change" data-status="2">Reject</li>
                    </ul>
                    `;

                    $el.html($list);
                }
            })
        })

        $(document).on('click','.pagination a',function(e){
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let data= $('#search_val').val();
            if(data){
                pagination(page,data);
            }else{
                pagination(page);
            }
        })

        function pagination(p,data){
            if(data){
                $.ajax({
                    url : "/order/pagination_list?page="+p,
                    data :{data : data},
                    success:function(res){
                        $('.table_data').html(res);
                    }
                })
            }else{
                $.ajax({
                    url : "/order/pagination_list?page="+p,
                    success:function(res){
                        $('.table_data').html(res);
                    }
                })
            }
        }

        $('#search_val').keyup(function(e){
            e.preventDefault();
            $data= $(this).val();
            $('.pagination').addClass('search');

            $.ajax({
                type:'get',
                url:'{{ route('admin#orderTotalSearch') }}',
                data: {'data' : $data},
                success:function(res){
                    $('#count').text(res.count);
                }
            });
            $.ajax({
                type:'get',
                url:'{{ route('admin#orderSearch') }}',
                data: {'data' : $data},
                success:function(res){
                    $('.table_data').html(res);
                }
            });
        })
    })
    </script>
@endsection

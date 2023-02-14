@extends('admin.layout.overall')

@section('title','Product List')

@section('content')
    {{-- content --}}
        <div class="content">
            <div class="label mt-3 d-flex" style="position: relative;">
              <h2>Product List</h2>
                <form action="{{ route('admin#productList') }}" method="get">
                    @csrf
                    <div class="d-flex" style="margin-left: 250px">
                        <input type="text" class="form-control" name="key" id="" placeholder="search...">
                        <button class="btn btn-dark">Search</button>
                      </div>
                </form>
                <h3 class="" style="margin: 50px 0 0 450px">Total : (<b class="text-success">{{ $data->Total() }}</b>)</h3>



                <a href="{{ route('admin#productCreate') }}">
                    <button class="btn  mt-2" style="position:absolute;right:10px;background-color:rgb(115, 201, 115);">+ Add Product</button>
                </a>
            </div>
            <div class="col-4 offset-4">
                @if (session('createSuccess'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('createSuccess') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
                @endif
                @if (session('deleteSuccess'))
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ session('deleteSuccess') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('updateSuccess'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      {{ session('updateSuccess') }}
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                @endif
            </div>

              <table class="table table-borderless mt-5" >
                  <thead>
                    <tr>
                        <th class="text-center">Image</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Product Prize</th>
                        <th class="text-center">Category Name</th>
                        <th class="text-center">view Count</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody class="">
                    @if (!$status)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-center text-danger"><h2>There is NO DATA</h2></td>
                    </tr>
                    @else
                        @foreach ($data as $item)
                        <tr class="pro_tb_content">
                            <td class="align-middle text-center"><img class="img-thumbnail" src="{{ asset('storage/'.$item['product_image']) }}" alt="" style="width:130px;height:100px"></td>
                            <td class="align-middle text-center">{{ $item->product_name }}</td>
                            <td class="align-middle text-center">{{ $item->product_price }} <b>Ks</b></td>
                            <td class="align-middle text-center">{{ $item->category_name }}</td>
                            <td class="align-middle text-center">{{ $item->view_count==null? 0 : $item->view_count }}</td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin#productDetail',$item->product_id) }}" style="text-decoration: none">
                                    <button class="icon" title="detail"><i class='bx bx-show align-middle ic'></i></button>
                                </a>
                                <a href="{{ route('admin#productEdit',$item->product_id) }}" style="text-decoration: none">
                                    <button class="icon" title="edit" ><i class='bx bx-edit align-middle ic'></i></button>
                                </a>
                                <button class="icon modelshow" title="delete"  value="{{ $item->product_id }}"><i class='bx bx-trash align-middle ic'></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                    @endif

                  </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{$data->appends(request()->query())->links()}}
                </div>

                @if (request('key'))
                <span>Search Key:<b>{{ request('key') }}</b></span>
              @endif

          </div>

    {{-- end content --}}
  <!-- Modal -->
  <div class="modal fade" id="deleteModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ route('admin#productDelete') }}" method="post">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title text-danger " id="exampleModalLabel">Delete Confirm?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <input type="text" name="id" id="proId" hidden>
                  <span>Are you sure do u want to delete?</span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary">Yes</button>
              </div>
        </form>
      </div>
    </div>
  </div>

@endsection


@section('script')

    <script>
        $(document).ready(function(){
            $('.modelshow').click(function(e){
                e.preventDefault();

                var productId= $(this).val();
                $('#proId').val(productId);
                $('#deleteModel').modal('show');
            });
        });
    </script>

@endsection

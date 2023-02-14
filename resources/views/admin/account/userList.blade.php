@extends('admin.layout.overall')

@section('title','User List')

@section('content')
    {{-- content --}}
        <div class="content">
            <div class="label mt-3 d-flex" style="position: relative;">
              <h2>User List</h2>
                <form action="{{ route('admin#userList') }}" method="get">
                    @csrf
                    <div class="d-flex" style="margin-left: 250px">
                        <input type="text" class="form-control" name="key" id="" placeholder="search...">
                        <button class="btn btn-dark">Search</button>
                      </div>
                </form>
                <h3 class="" style="margin: 50px 0 0 450px">Total : (<b class="text-success">{{ $data->Total() }}</b>)</h3>


                <a href="{{ route('admin#adminList') }}">
                    <button class="btn  mt-2" style="position:absolute;right:10px;background-color:rgb(115, 201, 115);">Admin List Page</button>
                </a>
            </div>

            <div class="col-4 offset-4">
                @if (session('deleteSuccess'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('deleteSuccess') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
                @endif
            </div>

              <table class="table table-borderless mt-5" >
                  <thead>
                    <tr>
                        <th class="text-center">Profile</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Phone</th>
                        <th class="text-center">Address</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody class="">
                    @if (count($data) == 0)
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
                            @if ($item->name != auth()->user()->name)
                                <tr class="pro_tb_content">
                                    <td class="align-middle text-center"><img class="img-thumbnail" src="@if($item->image == null) {{asset('admin/defaultImage/download (1).png') }} @else {{ asset('admin/userImage/'.$item->image) }} @endif" alt="" style="width:130px;height:130px"></td>
                                    <td class="align-middle text-center">{{ $item->name }}</td>
                                    <td class="align-middle text-center">{{ $item->email }}</td>
                                    <td class="align-middle text-center">{{ $item->phone }}</td>
                                    <td class="align-middle text-center">{{ $item->address }}</td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown"data-dropdown  @if ($item->email == auth()->user()->email) hidden disabled @endif>
                                            <button class="icon align-middle dddd" data-dropdown-button title="change role"><i class='bx bxs-user-detail ic' style="width:100%;height:100%;margin-top:6px"></i></button>
                                                <ul class="dropdown_content">
                                                    <li @if ($item->role == 'admin') style="pointer-events: none" @endif>
                                                        <form action="{{ route('admin#changRole') }}" method="POST">
                                                            @csrf
                                                            <input type="text" name="role" value="admin" hidden>
                                                            <input type="text" name="id" value="{{$item->id}}" hidden>
                                                            <a href="javascript:{}" onclick="this.parentNode.submit();" @if ($item->role == 'admin') style="pointer-event:none" @endif>Admin</a>
                                                        </form>

                                                    </li>
                                                    <li @if ($item->role == 'user') style="pointer-events: none" @endif>
                                                        <form action="{{ route('admin#changRole') }}" method="POST">
                                                            @csrf
                                                            <input type="text" name="role" value="user" hidden>
                                                            <input type="text" name="id" value="{{$item->id}}" hidden>
                                                            <a href="javascript:{}" onclick="this.parentNode.submit();" @if ($item->role == 'user') style="pointer-event:none" @endif>User</a>
                                                        </form>
                                                    </li>
                                                </ul>
                                        </div>
                                        <button class="icon modelshow" title="delete"  value="{{ $item->id }}"><i class='bx bx-trash align-middle ic'></i></button>
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
                            @endif
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
        <form action="{{ route('admin#adminDelete') }}" method="post">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title text-danger " id="exampleModalLabel">Delete Confirm?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <input type="text" name="id" id="userId" hidden>
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

                var userID= $(this).val();
                $('#userId').val(userID);
                $('#deleteModel').modal('show');
            });

            $('.dropdown').click(function(e){
                e.preventDefault();


                $(this).toggleClass('auto');
            })
        });

        document.addEventListener('click',e=>{
            const dropdownBtn = e.target.matches("[data-dropdown-button]");
            if(!dropdownBtn && e.target.closest('[data-dropdown]') != null) return;

            let currentDrop
            console.log(dropdownBtn);
            if(dropdownBtn){
                currentDrop = e.target.closest('[data-dropdown]');
                currentDrop.classList.toggle('auto');
            }

            document.querySelectorAll('[data-dropdown].auto').forEach(dropdown =>{
                if(dropdown ===currentDrop)return
                dropdown.classList.remove('auto')
            });
        })

        function click(el){
            el.childNodes[1].click();
        }
    </script>

@endsection

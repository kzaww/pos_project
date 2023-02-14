@extends('user.layout.layout')

@section('title','Account')

@section('content')
{{-- content --}}
    <div class="content">
        <div class="col-8 offset-2">
            @if (session('updateSuccess'))
                <div class="alert alert-success alert-dissmissable fade show" role="alert">
                    {{ session('updateSuccess') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('updateFail'))
                <div class="alert alert-danger alert-dissmissable fade show" role="alert">
                    {{ session('updateFail') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    $(document).ready(function(){
                        $('#changeprofile').modal('show');
                    })
                </script>
            @endif
            @if (session('changeFail'))
                <div class="alert alert-danger alert-dissmissable fade show" role="alert">
                    {{ session('changeFail') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    $(document).ready(function(){
                        $('#changepassword').modal('show');
                    })
                </script>
            @endif
            @if (session('passwordFail'))
                <div class="alert alert-danger alert-dissmissable fade show" role="alert">
                    {{ session('passwordFail') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            @endif
            @if (session('passwordSuccess'))
                <div class="alert alert-danger alert-dissmissable fade show" role="alert">
                    {{ session('passwordSuccess') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('uploadSuccess'))
                <div class="alert alert-success alert-dissmissable fade show" role="alert">
                    {{ session('uploadSuccess') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('uploadFail'))
                <div class="alert alert-danger alert-dissmissable fade show" role="alert">
                    {{ session('uploadFail') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    $(document).ready(function(){
                        $('#uploadImage').modal('show');
                    })
                </script>
            @endif

        </div>
        <div class="col-6 offset-3" style="margin-top: 120px">
            <div class="card ">
                <div class="card-header bg-success">
                    <h3 class="text-center text-white">Profile</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 text-center py-4">
                            <img class="" @if(auth()->user()->image == null) src="{{ asset('admin/defaultImage/download (1).png') }}" @else src="{{ asset('admin/userImage/'.auth()->user()->image) }}"  @endif alt="" style="width:200px;height:200px;box-shadow:3px 2px 8px black;cursor:pointer;" data-bs-toggle="modal" data-bs-target="#uploadImage">
                        </div>
                        <div class="col-2 offset-1 py-4">
                            <span>Name :    </span><br>
                            <span>Email :   </span><br>
                            <span>Phone :   </span><br>
                            <span>Address : </span><br>
                            <span>Joined :  </span>
                        </div>
                        <div class="col-3 offset-1 py-4">
                            <b>{{ auth()->user()->name }}</b><br>
                            <b>{{ auth()->user()->email }}</b><br>
                            <b>{{ auth()->user()->phone }}</b><br>
                            <b>{{ auth()->user()->address }}</b><br>
                            <b>{{ auth()->user()->created_at->format('j/F/Y') }}</b><br>
                            <i class='bx bxs-info-circle ' style="transform: translateY(4px)" title="After Change Password
    ,You will be redirected to Login page"   ></i>
                            <a href="javascript:{}" id="cp" data-bs-toggle="modal" data-bs-target="#changepassword"><small style="white-space:nowrap">Change Password?</small></a>
                            <button class="btn btn-sm btn-primary mt-3 float-end" data-bs-toggle="modal" data-bs-target="#changeprofile">Change Profile</button><br>

                        </div>
                    </div>
                </div>
            </div>


            {{-- <div class="mt-2 float-end">
                <a href="{{ URL::previous() }}">
                    <button class="btn btn-secondary px-4" >Back</button>
                </a>
            </div> --}}


        </div>

    </div>


    {{-- end content --}}
    <!-- Modal -->
    <div class="modal fade" id="changeprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route('user#changeProfile') }}" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title text-danger " id="exampleModalLabel">Change Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <input type="text" name="id" value="{{ auth()->user()->id }}" hidden>
            <div class="">
                <label for="">Name :</label>
                <input type="text" id="name1" name="name" class="form-control @if ($errors->has('name')) is-invalid @elseif($errors->has('email')||$errors->has('phone')||$errors->has('address')) is-valid  @endif" id="" placeholder="name..." value="{{ old('name',auth()->user()->name) }}" autofocus>
            </div>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <br>
            <div class="">
                <label for="">Email :</label>
                <input type="email" id="email1" name="email" class="form-control @if ($errors->has('email')) is-invalid @elseif($errors->has('name')||$errors->has('phone')||$errors->has('address')) is-valid  @endif" id="" placeholder="example@..." value="{{ old('email',auth()->user()->email) }}">
            </div>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <br>
            <div class="">
                <label for="">Phone :</label>
                <input type="text" id="phone1" name="phone" class="form-control @if ($errors->has('phone')) is-invalid @elseif($errors->has('name')||$errors->has('email')||$errors->has('address')) is-valid  @endif" id="" placeholder="09..." value="{{ old('phone',auth()->user()->phone) }}">
            </div>
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <br>
            <div class="">
                <label for="">Address :</label>
                <input type="text" id="address1" name="address" class="form-control @if ($errors->has('address')) is-invalid @elseif($errors->has('name')||$errors->has('email')||$errors->has('phone')) is-valid  @endif" id="" placeholder="Yan..." value="{{ old('address',auth()->user()->address) }}">
            </div>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
    </div>
    </div>
    </div>
    {{-- modal end --}}

    {{-- modal start --}}
    <div class="modal fade" id="changepassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route('user#changePassword') }}" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title text-danger " id="exampleModalLabel">Change Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="text" name="id" value="{{ auth()->user()->id }}" hidden>
            <div class="">
                <label for="">Old Password :</label>
                <div class="input-group">
                    <input type="password" id="oi" class="form-control" name="oldPassword" placeholder="old password...">
                    <span class="input-group-text" id="os" onclick="myfunction('oi','os')" style="cursor: pointer;user-select:none;">show</span>
                </div>
            </div>
            @error('oldPassword')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <br>
            <div class="">
                <label for="">New Password :</label>
                <div class="input-group">
                    <input type="password" id="ni" class="form-control" name="newPassword" placeholder="new password...">
                    <span class="input-group-text" id="ns" onclick="myfunction('ni','ns')" style="cursor: pointer;user-select:none;">show</span>
                </div>
            </div>
            @error('newPassword')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <br>
            <div class="">
                <label for="">Confirm Password :</label>
                <div class="input-group">
                    <input type="password" id="ci" class="form-control" name="confirmPassword" placeholder="confirm password...">
                    <span class="input-group-text" id="cs" onclick="myfunction('ci','cs')" style="cursor: pointer;user-select:none;">show</span>
                </div>
            </div>
            @error('confirmPassword')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Change</button>
        </div>
    </form>
    </div>
    </div>
    </div>
    {{-- modal end --}}
    <!-- Modal -->
    <div class="modal fade" id="uploadImage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route('user#uploadImage') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title text-danger " id="exampleModalLabel">Upload Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="col-6 offset-3">
                <img class="" @if(auth()->user()->image == null) src="{{ asset('admin/defaultImage/download (1).png') }}" @else src="{{ asset('admin/userImage/'.auth()->user()->image) }}"    @endif alt="" style="box-shadow:3px 2px 8px black;width:250px;height:250px;">
                <a href="javascript:{}" style="white-space: nowrap" id="upimagename" class="ms-4 d-flex mt-3" onclick="$('#imgup').click()">Click Here To Upload Image</a>
                <input type="file" class="form-control mt-3 ms-3 @error('image') is-invalid @enderror" name="image" hidden id="imgup" >
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </form>
    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        password = true;
        function myfunction(id,id2){
            var x = document.getElementById(id);
            if(password){
                x.type = 'text';
                document.getElementById(id2).innerHTML="hide"
            }else{
                x.type = 'password';
                document.getElementById(id2).innerHTML="show"
            }
            password = !password;
        }

        $(document).ready(function(){
            $('#imgup').change(function(){
                let img = $(this).val().replace(/C:\\fakepath\\/i,'');
                let length = img.length;
                $('#upimagename').html(img);

                // if(length<=13){
                //     $('#upimagename').html(img);
                // }else{
                //     var part1 = img.substr(0,9);
                //     var part2 = img.substr(length - 12);

                //     $('#upimagename').html(part1+'...'+part2)
                // }

            })
        })

    </script>
@endsection

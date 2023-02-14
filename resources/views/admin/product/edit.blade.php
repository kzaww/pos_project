@extends('admin.layout.overall')

@section('title','Product Create')

@section('content')
    {{-- content --}}
        <div class="content">
            <div class="col-6 offset-3" style="margin-top: 20px">
                @if (session('fail'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('fail') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
                 @endif
                <div class="card ">
                    <div class="card-header bg-success">
                        <h3 class="text-center text-white">Product Create</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin#productUpdate') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="text" value="{{ $data->product_id }}" name="id" hidden>
                            <div class="">
                                <label for="" class="">Product Name :</label>
                                <input type="text" name="name" class="form-control mt-2 @if ($errors->has('name')) is-invalid @elseif($errors->has('category')||$errors->has('description')||$errors->has('image')||$errors->has('price')) is-valid  @endif" placeholder="Name..." value="{{ old('name',$data->product_name) }}" autofocus>
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <br>

                            <div class="">
                                <label for="" class="">Category Name :</label>
                                <select name="category" class="form-control @if ($errors->has('category')) is-invalid @elseif($errors->has('name')||$errors->has('description')||$errors->has('image')||$errors->has('price')) is-valid  @endif" id="" >
                                    <option value="" >Choose Option</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->category_id }}" @if ( $data->category_id == $item->category_id ) selected @endif>{{ $item->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <br>

                            <div class="">
                                <label for="" class="">Description :</label>
                                <textarea name="description" class="form-control @if ($errors->has('description')) is-invalid @elseif($errors->has('category')||$errors->has('name')||$errors->has('image')||$errors->has('price')) is-valid  @endif" value=""  id="" cols="30" rows="5" placeholder="description...">{{ old('description',$data->description) }}</textarea>
                            </div>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <br>

                            <div class="">
                                <label for="" class="">Product Image :</label>
                                <input type="file" name="image" class="form-control @if ($errors->has('image')) is-invalid @elseif($errors->has('category')||$errors->has('description')||$errors->has('name')||$errors->has('price')) is-valid  @endif" id="">
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <br>

                            <div class="">
                                <label for="" class="">Product Price :</label>
                                <input type="number" name="price" class="form-control mt-2 @if ($errors->has('price')) is-invalid @elseif($errors->has('category')||$errors->has('description')||$errors->has('image')||$errors->has('name')) is-valid  @endif" placeholder="Price..." value="{{ old('price',$data->product_price) }}" >
                            </div>
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <br>

                            <div class="">
                                <label for="" class="">Waiting Time :</label>
                                <input type="number" name="time" class="form-control mt-2 @if ($errors->has('time')) is-invalid @elseif($errors->has('category')||$errors->has('description')||$errors->has('image')||$errors->has('name')||$errors->has('price')) is-valid  @endif" placeholder="time..." value="{{ old('time',$data->waiting_time) }}" >
                            </div>
                            @error('time')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <br>

                            <input type="submit" class="btn btn-warning mt-2 float-end px-4" value="Create">
                        </form>
                    </div>
                </div>


                <div class="mt-2 float-end">
                    <i class='bx bxs-info-circle ' style="transform: translateY(4px)" title="if don't redirect list page
                    ,Just use navigator from sidebar"   ></i>
                    <a href="{{ URL::previous() }}">
                        <button class="btn btn-secondary px-4" >Back</button>
                    </a>
                </div>


            </div>
          </div>

    {{-- end content --}}
@endsection

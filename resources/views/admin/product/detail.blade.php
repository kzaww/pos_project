@extends('admin.layout.overall')

@section('title','Product Details')

@section('content')
    {{-- content --}}
        <div class="content">
            <div class="col-8 offset-2 " style="margin-top: 120px;margin-bottom:50px">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <a class="text-decoration-none text-dark" href="{{ URL::previous() }}">
                                    <span style="font-weight: 700;font-size:2rem;"><i class='bx bx-left-arrow-alt'></i></span>
                                </a>
                                <div class="text-center py-5">
                                    <img class="" src="{{ asset('storage/'.$data->product_image) }}" alt="" style="width: 400px;box-shadow:-2px 2px 4px black;filter:brightness(100%)">
                                </div>
                            </div>
                            <div class="col-6 py-5">
                                <div class="row">
                                    <div class="col-5">
                                        <b>Name</b><br><br>
                                        <b >Category</b><br><br>
                                        <b>Price</b><br><br>
                                        <b>Waiting Time</b><br><br>
                                        <b>Description</b><br><br>

                                    </div>
                                    <div class="col-6 ">
                                        <span class="text-danger">: {{ $data->product_name }}</span><br><br>
                                        <span >: {{ $data->category_name }}</span><br><br>
                                        <span >: {{ $data->product_price }} <b>Ks</b></span><br><br>
                                        <span >: {{ $data->waiting_time }} <b>Mins</b></span><br><br>
                                        :<div class="" style="width:230px;height:150px;overflow-y:auto;overflow-wrap:break-word;hyphens:auto;word-wrap:break-word;white-space;transform:translate(10px,-21px)">
                                            <span style="hyphens:auto;"> {{ $data->description }}</span><br><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <b>Date</b><br><br>
                                    </div>
                                    <div class="col-6 ">
                                        <span class="">: {{ $data->updated_at->format('j/F/Y') }}</span><br><br>

                                    </div>
                                </div>
                                <span class="d-flex float-end" style="transform: translateY(60px)"><i class='bx bxs-show fs-4' style="margin: 1px 2px 0 0;"></i><span class="">0</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- end content --}}
@endsection

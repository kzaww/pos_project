@extends('admin.layout.overall')

@section('title','Category Create')

@section('content')
    {{-- content --}}
        <div class="content">
            <div class="col-6 offset-3" style="margin-top: 120px">
                <div class="card ">
                    <div class="card-header bg-success">
                        <h3 class="text-center text-white">Category Create</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin#createCategory') }}" method="post">
                            @csrf
                            <label for="" class="">Category Name :</label>
                            <input type="text" name="name" class="form-control mt-2 @error('name') is-invalid @enderror" placeholder="Name..." value="{{ old('name') }}" autofocus>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <br>
                            <input type="submit" class="btn btn-warning mt-2 float-end px-4" value="Create">
                        </form>
                    </div>
                </div>


                <div class="mt-2 float-end">
                    <a href="{{ URL::previous() }}">
                        <button class="btn btn-secondary px-4" >Back</button>
                    </a>
                </div>


            </div>
          </div>

    {{-- end content --}}
@endsection

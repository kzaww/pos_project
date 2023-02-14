@extends('admin.layout.overall')

@section('title','Contact')

@section('content')
    {{-- content --}}
        <div class="content">
            <div class="label mt-3 d-flex" style="position: relative;">
              <h2>Contact List</h2>
                    <div class="d-flex" style="margin-left: 300px;">
                        <input type="text" class="form-control" name="key" id="contact_search" placeholder="search..." style="width:300px">
                      </div>
                <h3 class="" style="margin: 10px 0 0 0;position: absolute;right:0px" >Total : (<b class="text-success contact_count">{{ count($data) }}</b>)</h3>
            </div>
              {{-- <table class="table table-borderless mt-5" >
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Category Name</th>
                        <th>Created Date</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody class="">
                  </tbody>
                </table> --}}
                <ul class="mt-3 contact_ul">
                    <li class="contact_header">
                        <span>No</span>
                        <span>Name</span>
                        <span>Email</span>
                        <span>Message</span>
                    </li>
                    <div class="contact_item">
                        <?php $i=1; ?>
                        @foreach ($data as $item)
                        <li class="mt-3">
                            <span class="d-flex align-self-center" style="">{{ $i }}</span>
                            <span class="d-flex align-self-center" >{{ $item->name }}</span>
                            <span class="d-flex align-self-center">{{ $item->email }}</span>
                            <span >{{ $item->message }}</span>
                        </li>
                        <?php $i++; ?>
                        @endforeach
                    </div>
                </ul>

          </div>

    {{-- end content --}}
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            $('#contact_search').keyup(function(){
                $data = $(this).val();

                $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

                $.ajax({
                    type:'get',
                    url:'{{ route('admin#contactSearch') }}',
                    data: {'data':$data},
                    dataType:'json',
                    success: function(res){
                        $('.contact_item').html(res.data);
                        $('.contact_count').text(res.count);
                    }
                })
            })
        })
    </script>
@endsection

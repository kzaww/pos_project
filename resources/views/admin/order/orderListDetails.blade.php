@extends('admin.layout.overall')

@section('title','Order List Details')

@section('content')
    {{-- content --}}
        <div class="content">
            <div class="label mt-3 d-flex" style="position: relative;">
              <h2>Order List Details</h2>
                <h3 class="" style="margin: 10px 0 0 600px">Total : (<b class="text-success">{{ count($data) }}</b>)</h3>
                <button class="btn btn-secondary" style="margin: 10px 0 0 200px" id="moreDetails">More Detail</button>
            </div>

            <button class="btn btn-secondary mt-1" onclick="window.history.back()">Back</button>
              <table class="table table-borderless " style="border-collapse: separate;border-spacing:0 15px">
                  <thead>
                    <tr>
                        <th class="">Image</th>
                        <th class="">Product Name</th>
                        <th class="">Quantity</th>
                        <th class="">Total</th>
                    </tr>
                  </thead>
                  <tbody class="">
                    <?php $total = 0 ;?>
                    @foreach ($data as $item)
                    <tr class="pro_tb_content align-middle">
                        <td>
                            <img class="img-thumbnail" src="{{ asset('storage/'.$item->product_image) }}" alt="" style="width:130px;height:100px">
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->total }} Kyats</td>
                    </tr>

                    <?php $total+= $item->total ?>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="h3">Total :</td>
                        <td class="d-flex"><h3 class="text-primary me-3"><?php echo($total+3000); ?></h3><span class="mt-1">Kyats</span></td>
                    </tr>
                  </tbody>
                </table>
          </div>

    {{-- end content --}}

  <!-- Modal -->
  <div class="modal fade" id="more" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
              <div class="modal-body">
                    <button type="button" class="btn-close bg-danger float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row">
                        <div class="col">
                            <span class="h5 d-block">Name</span><hr>
                            <span class="h5 d-block">Date</span><hr>
                            <span class="h5 d-block ">Order Code</span><hr>
                            <span class="h5 d-block ">Total</span>
                        </div>
                        <div class="col">
                            <span class="h5 d-block">:  {{ strtoupper($data[0]->name) }}</span><hr>
                            <span class="h5 d-block">:  {{ date('j-F-Y', strtotime($data[0]->created_at)) }}</span><hr>
                            <span class="h5 d-block" style="user-select:text">:  {{ $data[0]->order_code }}</span><hr>
                            <span class="h5 d-block">:  <?php echo($total+3000); ?> Kyats</span>
                        </div>
                    </div>
            </div>
      </div>
    </div>
  </div>

@endsection


@section('script')
  <script>
    $(document).ready(function(){
        $('#moreDetails').click(function(){
            $('#more').modal('show');
        })
    })
  </script>
@endsection

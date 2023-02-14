@extends('user.layout.layout')

@section('title','History')

@section('content')
    <!-- body start -->
    <div class="cart_wrapper row my-3">
        <div class="col-8 offset-2">
            <div class="bg-white" style="width: 98%;padding:10px 20px;min-height: 50vh;">
                <table class="table table-borderless" id="cart_table" style="border-collapse: separate;border-spacing:0 15px;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Order Code</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <?php $i=1;?>
                        @foreach ($order as $o)
                            <tr class="bg-secondary text-white align-middle t_b">
                                <td>{{ $i; }}</td>
                                <td>{{ $o->created_at->format('j/M/Y') }}</td>
                                <td>{{ $o->total_price }} Kyats</td>
                                <td>{{ $o->order_code }}</td>
                                <td>
                                    @if ($o->status == '0')
                                    <span class="d-flex text-warning"><i class="material-icons fs-5" style="margin-top: 3px">timer</i>Pending...</span>
                                    @elseif ($o->status == '1')
                                        <span class="d-flex" style="color:rgb(117, 218, 117)"><i class="material-icons fs-5 mt-1">check_circle</i>Success</span>
                                    @elseif ($o->status == '2')
                                    <span class="d-flex" style="color:red"><i class="material-icons fs-5" style="margin-top: 3px">cancel</i>Reject</span>
                                    @endif
                                </td>
                            </tr>
                            <?php $i++;?>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{$order->links()}}
                </div>
            </div>
        </div>
    </div>
    <!-- body end -->

@endsection

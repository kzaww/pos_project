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

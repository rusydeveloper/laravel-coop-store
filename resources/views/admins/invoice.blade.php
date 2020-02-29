@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-clone"></span> Invoice
                    <!-- <a href="/admin/user/add">
                    <button class="btn btn-primary btn-md pull-right">+ Tambah</button>
                </a> -->
            </div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @elseif (session('danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('danger') }}
                </div>
                @endif

                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Unpaid</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Paid</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Semua Invoice</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <h3>Unpaid Invoice</h3>
                  <p><table class="table table-striped table-hover" style="font-size: 10pt">
                    <thead>
                      <tr>
                        <th>Kode Invoice</th>
                        <th>Created At</th>
                        <th>Kode Booking</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices_unpaid as $item)
                    <tr>
                        <td>{{$item->unique_id}}</td>
                        <td>{{date('d-M-Y H:i:s', strtotime($item->created_at))}}</td>
                        <td>{{$item->booking_id}}</td>
                        <td>
                            @if($item->status == 'unpaid')
                            <span class="badge badge-danger">{{$item->status}}</span>
                            @else
                            <span class="badge badge-secondary">{{$item->status}}</span>
                            @endif
                        </td>
                        <td style="text-align: right">

                            {{number_format($item->amount,0,",",".")}}
                        </td>
                        <td>{{$item->description}}</td>
                        <td>
                            @if($item->status == 'unpaid')
                            <form method="POST" action="/admin/invoice/paid" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                <button class="btn btn-danger btn-sm btn-space" style="float: left;">paid</button>
                            </form>
                            <form method="POST" action="/admin/invoice/cancel" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                <button class="btn btn-warning btn-sm btn-space" style="float: left;">cancel</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Data Kosong</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforelse

                </tbody>
            </table></p>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <h3>Paid Invoice</h3>
          <p><table class="table table-striped table-hover" style="font-size: 10pt">
            <thead>
              <tr>
                <th>Kode Invoice</th>
                <th>Created At</th>
                <th>Kode Booking</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices_paid as $item)
            <tr>
                <td>{{$item->unique_id}}</td>
                <td>{{date('d-M-Y H:i:s', strtotime($item->created_at))}}</td>
                <td>{{$item->booking_id}}</td>
                <td>
                    @if($item->status == 'unpaid')
                    <span class="badge badge-danger">{{$item->status}}</span>
                    @else
                    <span class="badge badge-secondary">{{$item->status}}</span>
                    @endif
                </td>
                <td style="text-align: right">

                    {{number_format($item->amount,0,",",".")}}
                </td>
                <td>{{$item->description}}</td>
                <td>

                </td>
            </tr>
            @empty
            <tr>
                <td></td>
                <td></td>
                <td>Data Kosong</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforelse

        </tbody>
    </table></p>
</div>
<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
  <h3>All Invoice</h3>
  <p><table class="table table-striped table-hover" style="font-size: 10pt">
    <thead>
      <tr>
        <th>Kode Invoice</th>
        <th>Created At</th>
        <th>Kode Booking</th>
        <th>Status</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @forelse($invoices_unpaid as $item)
    <tr>
        <td>{{$item->unique_id}}</td>
        <td>{{date('d-M-Y H:i:s', strtotime($item->created_at))}}</td>
        <td>{{$item->booking_id}}</td>
        <td>
            @if($item->status == 'unpaid')
            <span class="badge badge-danger">{{$item->status}}</span>
            @else
            <span class="badge badge-secondary">{{$item->status}}</span>
            @endif
        </td>
        <td style="text-align: right">

            {{number_format($item->amount,0,",",".")}}
        </td>
        <td>{{$item->description}}</td>
        <td>
            @if($item->status == 'unpaid')
            <form method="POST" action="/admin/invoice/paid" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                <button class="btn btn-danger btn-sm btn-space" style="float: left;">paid</button>
            </form>
            <form method="POST" action="/admin/invoice/cancel" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                <button class="btn btn-warning btn-sm btn-space" style="float: left;">cancel</button>
            </form>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td></td>
        <td></td>
        <td>Data Kosong</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endforelse

</tbody>
</table></p>
</div>
</div>
</div>


</div>
</div>
</div>
</div>
</div>
@endsection

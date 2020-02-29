@extends('layouts.manager') 
@section('content')
<style type="text/css">
    .table {
        width: 100%;
        font-size: 12pt
    }

    .date-information {
        font-size: 12pt
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span class="fa fa-shopping-basket"></span> Pesanan
                    <span class="pull-right date-information" id="live_time"></span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif @if (session('danger'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('danger') }}
                    </div>
                    @endif
                    <input type="text" class="input-search" id="searchInvoiceCode" onkeyup="searchInvoice()" placeholder="Masukan Usaha dan Kode Booking" style="font-size: 10pt; width: 100%; height: 50px">
                    <table id="invoiceTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Booking</th>
                                <th>Status</th>
                                <th>Waktu Pesan</th>
                                <th>Keterangan</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $item)
                            <tr>
                                <td>{{$item->booking_id}}</td>
                                <td>
                                    @if($item->status == 'unpaid')
                                    <span class="badge badge-danger">
                                        {{$item->status}}
                                    </span> @elseif($item->status == 'paid')
                                    <span class="badge badge-secondary">
                                        {{$item->status}}
                                    </span> @elseif($item->status == 'waiting approval')
                                    <span class="badge badge-warning">
                                    {{$item->status}}
                                </span> @else
                                    <span class="badge badge-secondary">
                                        {{$item->status}}
                                    </span> @endif

                                </td>
                                <td>{{date('d-M-Y H:i:s', strtotime($item->created_at))}}</td>
                                <td>{{$item->description}}</td>
                                <td>Rp {{number_format($item->amount-$item->discount,0,",",".")}}</td>
                                <td>
                                    @if($item->status == 'unpaid')
                                    <form method="POST" action="/manager/invoice/payment" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                        <button class="btn btn-md btn-danger">Bayar</button>
                                    </form>
                                    @endif
                                    <form method="POST" action="/manager/invoice/show" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                        <button class="btn btn-md btn-secondary">Rincian</button>
                                    </form>


                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Belum ada pesanan</td>
                                <td></td>
                                <td></td>
                                <td>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function searchInvoice() {
    var input, filter, table, tr, td, td2, i, txtValue, txtValue2;
    input = document.getElementById("searchInvoiceCode");
    filter = input.value.toUpperCase();
    table = document.getElementById("invoiceTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td2 = tr[i].getElementsByTagName("td")[3];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            if (td2) {
              txtValue2 = td2.textContent || td2.innerText;
              if (txtValue2.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}       
}
}
</script>
@endsection
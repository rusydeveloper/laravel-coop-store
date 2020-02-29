@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p>Laporan Penjualan Periode {{date('d M Y', strtotime($date_report_start))}} s.d
                        {{date('d M Y', strtotime($date_report_end))}}</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center text-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Jumlah Penjualan
                </div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->sum('amount'),0,",",".")}}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Jumlah Pemasukan
                </div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->sum('amount')*0.25,0,",",".")}}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center text-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Jumlah Tagihan
                </div>
                <div class="card-body">
                    {{number_format($invoices->count(),0,",",".")}}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Jumlah Tagihan Dibayar
                </div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->count(),0,",",".")}}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-clone"></span> Rekap {{date('d M Y', strtotime($date_report_start))}} -
                    {{date('d M Y', strtotime($date_report_end))}}
                </div>
                <div class="card-body">
                    <input type="text" class="input-search" id="searchTenantName" onkeyup="searchTenant()"
                        placeholder="Nama Tenant" title="Nama Tenant">
                    <table id="tenantTable" class="table table-responsive table-striped table-hover"
                        style="font-size: 10pt">
                        <tr>
                            <td class="table-head-sort" onclick="sortTable(0)">Nama</td>
                            <td class="table-head-sort" onclick="sortTable(1)">Jumlah</td>
                            <td class="table-head-sort" onclick="sortTable(2)">Hasil Tenant (75%)</td>
                            <td class="table-head-sort" onclick="sortTable(3)">Hasil Nectico (25%)</td>
                        </tr>
                        @foreach ($invoices_groupBy_tenant as $key => $value)
                        <tr>
                            <td>{{ App\User::find($key)->business->first()->name }} ({{ App\User::find($key)->name }})
                            </td>
                            <td style="text-align: right">{{ number_format($value,0,",",".")}}</td>
                            <td style="text-align: right">{{ number_format($value*0.75,0,",",".")}}</td>
                            <td style="text-align: right">{{ number_format($value*0.25,0,",",".")}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>Total</td>
                            <td style="text-align: right">
                                {{number_format($invoices->where('status', 'paid')->sum('amount'),0,",",".")}}</td>
                            <td style="text-align: right">
                                {{number_format($invoices->where('status', 'paid')->sum('amount')*0.75,0,",",".")}}</td>
                            <td style="text-align: right">
                                {{number_format($invoices->where('status', 'paid')->sum('amount')*0.25,0,",",".")}}</td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-clone"></span> Rincian Tagihan
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
                    <input type="text" class="input-search" id="searchInvoiceCode" onkeyup="searchInvoice()"
                        placeholder="Masukan Usaha dan Kode Booking">
                    <table id="invoiceTable" class="table table-striped table-hover" style="font-size: 10pt">
                        <thead>
                            <tr>
                                <th>Nama Tenant dan Nama Usaha</th>
                                <th>Created At</th>
                                <th>Kode Booking</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Description</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $item)
                            <tr>
                                <td>{{$item->business["name"]}}</td>
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
                                    <!-- <form method="POST" action="/admin/user/edit" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="id">
                            <button class="btn btn-warning btn-sm btn-space" style="float: left;">edit</button>
                            </form> -->
                                    {{number_format($item->amount,0,",",".")}}
                                </td>
                                <td>{{$item->description}}</td>

                            </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Data Kosong</td>
                                <td></td>
                                <td></td>

                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function searchTenant() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchTenantName");
      filter = input.value.toUpperCase();
      table = document.getElementById("tenantTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }       
}
}

function searchInvoice() {
    var input, filter, table, tr, td, td2, i, txtValue, txtValue2;
    input = document.getElementById("searchInvoiceCode");
    filter = input.value.toUpperCase();
    table = document.getElementById("invoiceTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td2 = tr[i].getElementsByTagName("td")[2];
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

function sortTable(z) {
  var table, rows, switching, i, x, y, z, shouldSwitch;
  table = document.getElementById("tenantTable");
  switching = true;
  

  while (switching) {
    switching = false;
    rows = table.rows;
  
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
     
      x = rows[i].getElementsByTagName("TD")[z];
      y = rows[i + 1].getElementsByTagName("TD")[z];
      
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>
@endsection
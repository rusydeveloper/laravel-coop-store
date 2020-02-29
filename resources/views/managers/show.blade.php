@extends('layouts.manager')

@section('content')
<style type="text/css">
.table{
   width: 100%;
   font-size: 10pt
}
.order-info{
    font-size: 10pt;
}
.payment-container{
    background-color: #ffc311;
    color: black
}
.payment-form{
    font-size: 12pt !important;
    color: black !important;
}
a{
    text-decoration: none !important;

}

a:active{
    color: green !important;
}
.nav >li{
    background-color: white;
    border-radius: 5px;
    margin: 5px;
}

.btn-pay{
    width: 100%
}
#amount, #change{
    text-align: right
}
.payment-text{
    font-size: 12pt;
    color: white;
    padding: 5px;
    background-color: #3679F6;
    border-radius: 5px;
}
.payment-type{
    color: black
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-shopping-basket"></span> 
                    Rincian Pesanan 
                    <span class="pull-right payment-text">Kode Order: {{$invoice->booking_id}}</span>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <span class="order-info">Waktu Pemesanan {{date('d-M-Y H:i:s', strtotime($invoice->created_at))}}</span>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Pesanan</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $item)
                            <tr>
                                <td>{{$item->product->name}}</td>
                                <td>Rp {{number_format($item->product->price,0,",",".")}}</td>
                                <td>{{$item->quantity}}</td>
                                <td class="text-right">Rp {{number_format($item->price,0,",",".")}}</td>
                                
                            </tr>
                            @empty
                            @endforelse
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <th>Total</th>
                                <td></td>
                                <td></td>
                                <th class="text-right"><span class="text-danger">Rp {{number_format($invoice->amount,0,",",".")}}</th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

    @endsection

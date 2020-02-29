@extends('layouts.tenant')

@section('content')
<style type="text/css">
    .invoice-container{
        width: 98%;
        margin: auto;
        margin-bottom: 10px;
    }
    .invoice-card{
        width: 100%;
        height: 100%;
        padding: 10px !important;
    }
    .invoice-detail{
        font-size: 11pt        
    }
    .invoice-customer{
     font-weight: 900;   
    }
    .invoice-code{
        font-size: 10pt;
        font-weight: 900;        
    }
    .invoice-date{
        color: grey;
        font-size: 8pt
    }
    .unpaid{
        background-color: #fce3c9;
    }
    .paid{
        background-color: #edffed;
    }
    tr{
        border: none !important;
        padding: 0px !important;
        margin: 0px !important;
    }
    td{
        border: none !important;
        padding: 0px !important;
        margin: 0px !important;
    }
</style>
<div class="container">
    @forelse($invoices as $item)
    <div class="row invoice-container">
        @if($item->status == 'unpaid')
        <div class="card invoice-card unpaid">
        @else
        <div class="card invoice-card paid">
        @endif
                <table class="table table-condensed table-borderless table-sm">
                    <tr>
                        <td style="text-align: left" colspan="2">
                            <p class="invoice-detail">
                                {{$item->description}}<br>
                                <span class="invoice-customer">{{$item->customer}}</span>
                            </p>
                            <p></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left">
                            <p>
                                Kode: <span class="invoice-code">{{$item->booking_id}}</span><br>
                                Rp {{number_format($item->amount,0,",",".")}}
                            </p>
                        </td>
                        <td style="text-align: right">
                            @if($item->status == 'unpaid')
                            <span class="badge badge-danger">{{$item->status}}</span>
                            @elseif($item->status == 'paid')
                            <span class="badge badge-success">{{$item->status}}</span>
                            @endif
                            <br>
                            <span class="invoice-date">{{date('d-M-Y H:i:s', strtotime($item->updated_at))}}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @empty
        @endforelse
</div>
@endsection

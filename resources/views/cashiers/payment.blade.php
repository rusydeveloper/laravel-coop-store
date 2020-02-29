@extends('layouts.cashier') 
@section('content')
<style type="text/css">
    .table {
        width: 100%;
        font-size: 10pt
    }

    .order-info {
        font-size: 10pt;
    }

    .payment-container {
        background-color: #ffc311;
        color: black
    }

    .payment-form {
        font-size: 12pt !important;
        color: black !important;
    }

    a {
        text-decoration: none !important;

    }

    a:active {
        color: green !important;
    }

    .nav>li {
        background-color: white;
        border-radius: 5px;
        margin: 5px;
    }

    .btn-pay {
        width: 100%
    }

    #amount,
    #change {
        text-align: right
    }

    .payment-text {
        font-size: 12pt;
        color: white;
        padding: 5px;
        background-color: #3679F6;
        border-radius: 5px;
    }

    .payment-type {
        color: black
    }

    .discount-button {
        float: left;
        margin-right: 5px;
    }

    #dialog {
        border: solid 1px #ccc;
        margin: 10px auto;
        padding: 20px 30px;
        display: inline-block;
        box-shadow: 0 0 4px #ccc;
        background-color: #FAF8F8;
        overflow: hidden;
        position: relative;
        max-width: 450px;
        #form {
            max-width: 240px;
            margin: 25px auto 0;

            input {
                margin: 0 5px;
                text-align: center;
                line-height: 80px;
                font-size: 50px;
                border: solid 1px #ccc;
                box-shadow: 0 0 5px #ccc inset;
                outline: none;
                width: 20%;
                transition: all .2s ease-in-out;
                border-radius: 3px;

                &:focus {
                    border-color: purple;
                    box-shadow: 0 0 5px purple inset;
                }

                &::selection {
                    background: transparent;
                }
            }
        }
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                    @endif
                    <span class="fa fa-shopping-basket"></span> Rincian Order
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
                            
                            <tr>
                                <th>Sub Total</th>
                                <td></td>
                                <td></td>
                                <th class="text-right">Rp {{number_format($invoice->amount,0,",",".")}}
                                </th>
                            </tr>
                            <tr>
                                <td>Discount ({{$invoice->discount/$invoice->amount*100}}%)</td>
                                <td></td>
                                <td></td>
                                <td class="text-right">
                                    @if($invoice->discount>0) {{number_format($invoice->discount,0,",",".")}} @else Rp 0 @endif
                                </td>
                            </tr>
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
                                <th class="text-right"><span class="text-danger">Rp {{number_format($invoice->amount-$invoice->discount,0,",",".")}}</th>
                                </tr>
                            </tbody>
                        </table>
                        <style type="text/css">
                            .calculator {
  font-size: 28px;
  margin: 0 auto;
  width: 10em;
  
  &::before,
  &::after {
    content: " ";
    display: table;
  }
  
  &::after {
    clear: both;
  }
}
.calculator-button {
  border: 0;
  background: rgba(42,50,113, .28);
  color: #6cacc5;
  cursor: pointer;
  float: left;
  font: inherit;
  margin: 0.25em;
  width: 2em;
  height: 2em;
  transition: all 0.5s;
  
  &:hover {
    background: #201e40;
  }
  
  &:focus {
    outline: 0; // Better check accessibility

    /* The value fade-ins that appear */
    &::after {
      animation: zoom 1s;
      animation-iteration-count: 1;
      animation-fill-mode: both; // Fix Firefox from firing animations only once
      content: attr(data-num);
      cursor: default;
      font-size: 100px;
      position: absolute;
           top: 1.5em;
           left: 50%;
      text-align: center;
      margin-left: -24px;
      opacity: 0;
      width: 48px;    
    }
  }
}
.ops:focus::after {
  content: attr(data-ops);
  margin-left: -210px;
  width: 420px;
}

/* Same as above, modified for result */
.equals:focus::after {
  content: attr(data-result);
  margin-left: -300px;
  width: 600px;
}
.reset {
  background: rgba(201,120,116,.28);
  color:#c97874;
  font-weight: 400;
  margin-left: -77px;
  padding: 0.5em 1em;
  position: absolute;
    top: -20em;
    left: 50%;
  width: auto;
  height: auto;
  
  &:hover {
    background: #c97874;
    color: #100a1c;    
  }
  
  /* When button is revealed */
  &.show {
    top: 20em;
    animation: fadein 4s;
  }
}

                        </style>
                        <div id="calculator" class="calculator" style="display: none">

  <button id="clear" class="clear">C</button>

  <div id="viewer" class="viewer">0</div>

  <button class="calculator-button num" data-num="7">7</button>
  <button class="calculator-button num" data-num="8">8</button>
  <button class="calculator-button num" data-num="9">9</button>
  <button data-ops="plus" class="calculator-button ops"><-Back </button>

  <button class="calculator-button num" data-num="4">4</button>
  <button class="calculator-button num" data-num="5">5</button>
  <button class="calculator-button num" data-num="6">6</button>
  <!-- <button data-ops="minus" class="calculator-button ops">-</button> -->

  <button class="calculator-button num" data-num="1">1</button>
  <button class="calculator-button num" data-num="2">2</button>
  <button class="calculator-button num" data-num="3">3</button>
  <!-- <button data-ops="times" class="calculator-button ops">*</button> -->

  <button class="calculator-button num" data-num="0">0</button>
  <button class="calculator-button num" data-num=".">.</button>
  <!-- <button id="equals" class="calculator-button equals" data-result="">=</button> -->
  <!-- <button data-ops="divided by" class="calculator-button ops">/</button> -->
</div>



                    </div>
                </div>
            </div>
            <div class="col-md-5">
                
             <div class="card payment-container">
                <div class="card-header">
                    Pembayaran<br>
                    <span id="payment-amount" class="pull-right payment-text">Total Rp {{number_format($invoice->amount,0,",",".")}}</span>
                </div>
                <div class="card-body">
                    <div>
                        <h5>Discount</h5>
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#discount" data-backdrop="static" onclick="discount(5)">5%</button>
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#discount" data-backdrop="static" onclick="discount(10)">10%</button>
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#discount" data-backdrop="static" onclick="discount(15)">15%</button>
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#discount" data-backdrop="static" onclick="discount(20)">20%</button>
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#customDiscount" data-backdrop="static">Custom</button>
                    </div>
                    <script>
                        function discount(percentage){
                            document.getElementById('discount_percentage_direct').value=percentage;
                            document.getElementById('discount_percentage_request').value=percentage;
                            document.getElementById('discount_display').innerHTML=percentage+ "%";
                        }
                    </script>
                    <!-- Modal -->
                    <!-- The Modal for discount button -->
                    <div class="modal fade" id="discount">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Formulir Diskon <span id="discount_display"></span></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body" style="text-align: center">
                                    <form method="POST" action="/cashier/discount/verify/{{$invoice->unique_id}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input id="discount_percentage_direct" name="discount" type="hidden" value="0" style="font-size: 18pt; text-align:right; width: 500px"
                                            required>
                                        <div id="dialog">
                                            <div id="form">
                                                <input name="verify_password" type="password" />
                                                <button class="btn btn-primary btn-lg btn-embossed">Verify</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr/> ATAU
                                    <hr/>
                                    <form method="POST" action="/cashier/discount/{{$invoice->unique_id}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input id="discount_percentage_request" name="discount" type="hidden" value="0" style="font-size: 18pt; text-align:right; width: 500px"
                                            required>
                                        <button class="btn btn-primary btn-lg">Kirim Request</button>
                                    </form>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- The Modal for custom discount -->
                    <div class="modal fade" id="customDiscount">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Formulir Diskon</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body" style="text-align: right">
                                    <form method="POST" action="/cashier/discount/{{$invoice->unique_id}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input name="discount" type="number" value="0" placeholder="Masukan angka saja Contoh: 20 untuk 20%" style="font-size: 18pt; text-align:right; width: 500px"
                                            required>%
                                        <button class="btn btn-primary">Kirim</button>
                                    </form>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="payment-form">
                        <h5>Tipe Pembayaran</h5>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link" id="pills-oncash-tab" data-toggle="pill" href="#pills-oncash" role="tab" aria-controls="pills-oncash"
                                    aria-selected="false">Cash</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-debit-tab" data-toggle="pill" href="#pills-debit" role="tab" aria-controls="pills-debit" aria-selected="false">Debit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-credit-tab" data-toggle="pill" href="#pills-credit" role="tab" aria-controls="pills-credit"
                                    aria-selected="false">Credit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-other-tab" data-toggle="pill" href="#pills-other" role="tab" aria-controls="pills-other" aria-selected="false">Lainnya</a>
                            </li>
                        </ul>
                        <hr>
                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade" id="pills-oncash" role="tabpanel" aria-labelledby="pills-oncash-tab">
                                <h4 class="payment-type">Cash</h4>
                                <hr>
                                <span id="amount_display" style="font-size: 10pt" class="pull-right"></span>
                                <form method="POST" action="/cashier/invoice/paid" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-control" id="method" name="method" value="cash" required>
                                    <input type="hidden" class="form-control" id="unique_id" name="unique_id" value="{{$invoice->unique_id}}" required>
                                    <div class="form-group">
                                        <label for="amount">Jumlah </label>
                                        <input type="number" class="form-control" id="amount" name="amount" min="0" placeholder="Uang Diterima Rp" onkeyup="cash_calculate()"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="change">Kembalian</label>
                                        <input type="text" class="form-control" id="change" name="change" placeholder="Uang Kembalian Rp" readonly>

                                    </div>
                                    <div class="form-group">
                                        <button type="submit" id="btn-pay-cash" class="btn btn-lg btn-primary btn-pay" disabled>Bayar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-debit" role="tabpanel" aria-labelledby="pills-debit-tab">
                                <h4 class="payment-type">Debit</h4>
                                <hr>
                                <form method="POST" action="/cashier/invoice/paid" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-control" id="method" name="method" value="debit" required>
                                    <div class="form-group">
                                        <label for="bank">Bank</label>
                                        <select class="form-control" id="bank" name="bank" required>
                                    <option value="" selected>Pilih Bank Provider Kartu</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BRI">BRI</option>
                                    @forelse($debit_providers as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                    @empty
                                    @endforelse
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Jenis</label>
                                        <select class="form-control" id="type" name="type" required>
                                    <option value="" selected>Pilih Jenis Kartu</option>
                                    <option value="Visa">Visa</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="Visa & Mastercard">Visa & Mastercard</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="card-number">Nomor Kartu</label>
                                        <input type="number" class="form-control" id="card-number-credit" name="card-number-credit" min="0" placeholder="Masukan Nomor Kartu"
                                            required>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-pay"> 
                                <i class="fa fa-lock"></i> Bayar Credit
                            </button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-credit" role="tabpanel" aria-labelledby="pills-credit-tab">
                                <h4 class="payment-type">Credit</h4>
                                <hr>
                                <form method="POST" action="/cashier/invoice/paid" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-control" id="method" name="method" value="credit" required>
                                    <div class="form-group">
                                        <label for="bank">Bank</label>
                                        <select class="form-control" id="bank" name="bank" required>
                                    <option value="" selected>Pilih Bank Provider Kartu</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BRI">BRI</option>
                                    @forelse($credit_providers as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                    @empty
                                    @endforelse
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Jenis</label>
                                        <select class="form-control" id="type" name="type" required>
                                    <option value="" selected>Pilih Jenis Kartu</option>
                                    <option value="Visa">Visa</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="Visa & Mastercard">Visa & Mastercard</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="card-number">Nomor Kartu</label>
                                        <input type="number" class="form-control" id="card-number-credit" name="card-number-credit" min="0" placeholder="Masukan Nomor Kartu"
                                            required>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-pay"> 
                                <i class="fa fa-lock"></i> Bayar Credit
                            </button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-other" role="tabpanel" aria-labelledby="pills-other-tab">
                                <h4 class="payment-type">Lainnya</h4>
                                <hr>
                                <form method="POST" action="/cashier/invoice/paid" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-control" id="method" name="method" value="other" required>
                                    <div class="form-group">
                                        <label for="bank">Bank</label>
                                        <select class="form-control" id="bank" name="bank" required>
                                    <option value="" selected>Pilih Provider Kartu</option>
                                    @forelse($other_providers as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                    @empty
                                    @endforelse
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Jenis</label>
                                        <select class="form-control" id="type" name="type" required>
                                    <option value="" selected>Pilih Jenis Kartu</option>
                                    <option value="Visa">Visa</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="Visa & Mastercard">Visa & Mastercard</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="card-number">Keterangan</label>
                                        <input type="number" class="form-control" id="card-number-credit" name="card-number-credit" min="0" placeholder="Masukan Nomor Kartu (Optional)">
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-pay"> 
                                <i class="fa fa-lock"></i> Bayar
                            </button>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<script type="text/javascript">
    function cash_calculate(){
        let amount = document.getElementById('amount').value;
        let change = document.getElementById('change').value;

        let payment = document.getElementById('payment-amount').innerHTML;
        
        payment = Number(payment.replace('Total Rp ', '').replace('.', '').replace('.', ''));

        // payment = Number(payment.replace('Total Rp ', '').replace(new RegExp('.', 'g'), ''));


        change = amount-payment;
        
        amount_display ="Rp "+amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        document.getElementById('amount_display').innerHTML = amount_display;

        if (change<0) {
            document.getElementById('change').value = "Rp "+0;
            document.getElementById('btn-pay-cash').setAttribute("disabled","disabled");
        }else{
            document.getElementById('change').value = "Rp "+change.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            document.getElementById('btn-pay-cash').removeAttribute("disabled");
        }
    }

</script>
@endsection
@extends('layouts.tenant')

@section('content')
<style type="text/css">
  .product-container {
    width: 98%;
    margin: auto;
    margin-bottom: 10px;
  }

  .card-product {
    width: 100%;
    padding: 5px !important;
  }

  .product-order-container {
    float: right;
  }

  .scan-qr {
    position: fixed;
    bottom: 120px;
    right: 10px;
    width: 75px !important;
    height: 75px !important;
    text-align: center;
    background-color: #00aa44;
    border-radius: 10px;
    font-size: 36pt;
    color: white
  }

  #cart-full {
    position: fixed;
    bottom: 10px;
    font-size: 10pt;
    width: 100%
  }

  #cart-container {
    width: 90%;
    margin: auto;
  }

  .card-header-cart {
    background-color: #00aa44;
    color: white;
    text-align: left;
  }

  .product-name {
    font-size: 12pt
  }

  .product-price {
    font-size: 9pt
  }

  .product-order,
  .product-add {
    text-align: right;
  }

  .product-order {
    display: none;
  }

  .flex-container {
    display: flex;
    align-content: stretch;
  }

  .flex-container>div {
    width: 100%;
    margin: 1px;
  }

  .form-custom {
    font-size: 10pt;
    border: none;
    border-bottom: 1px grey solid;
    background-color: #F5F8FA;
  }
</style>
<div class="container" style="margin-bottom: 250px">
  <small style="text-align:center">No Kartu: {{$card_number_qr}}</small>
  @forelse($products as $item)
  <div class="row product-container">
    <div class="card card-product">
      <table class="table table-condensed table-borderless table-sm">
        <tr>
          <td style="text-align: left" colspan="2">
            <span id="product-name-{{$item->unique_id}}" class="product-name">{{$item->name}}</span>
          </td>
        </tr>
        <tr>
          <td style="text-align: left">
            <span id="product-price-{{$item->unique_id}}" class="product-price">Rp
              {{number_format($item->price,0,",",".")}}</span>
          </td>
          <td style="text-align: right">

            <div id="product-add-{{$item->unique_id}}" class="product-add">
              <button type="button" class="btn btn-success btn-sm"
                onclick="addButton('{{$item->unique_id}}', '{{$item->name}}', '{{$item->price}}')">+ Tambah</button>
            </div>
            <div id="product-order-{{$item->unique_id}}" class="product-order">
              <div class="product-order-container">
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#notesModal"
                  data-backdrop="static" data-keyboard="false" onclick="modalNotes('{{$item->unique_id}}')"><i
                    class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-danger btn-sm"
                  onclick="minusButton('{{$item->unique_id}}', '{{$item->name}}', '{{$item->price}}')">-</button>
                <button>
                  <span id="product-quantity-{{$item->unique_id}}">0</span>
                </button>
                <button type="button" class="btn btn-success btn-sm"
                  onclick="plusButton('{{$item->unique_id}}', '{{$item->name}}', '{{$item->price}}')">+</button>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
  @empty
  @endforelse
</div>
{{-- <a href="/cards/">
  <div class="scan-qr">
    <span><i class="fa fa-qrcode"></i>
    </span>
  </div>
</a> --}}
<form id="order-form" method="POST" action="submit" enctype="multipart/form-data">
  {{ csrf_field() }}

  <input id="cardNumberQr" type="hidden" class="form-control" name="cardNumberQr" value="{{$card_number_qr}}" required>
  <input id="orderContent" type="hidden" class="form-control" name="orderContent" value="" required>
  <input id="invoiceContent" type="hidden" class="form-control" name="invoiceContent" value="" required>
  <div id="cart-full">
    <div id="cart-container">
      <div class="flex-container">
        <div>
          <input id="customer" type="text" class="form-custom form-control" name="customer" value=""
            placeholder="Pemesan" required>
        </div>
        <div>
          <input id="tableNumber" type="number" class="form-custom form-control" name="tableNumber" value=""
            placeholder="Nomor" required>
        </div>
      </div>
      <div class="card" id="submit-button">
        <div class="card-header card-header-cart">
          <div class="flex-container">
            <div>
              <span id="cart-item">0</span> Item | Rp <span id="cart-amount">0</span>
            </div>
            <div style="text-align: right">
              <span><i class="fa fa-cutlery" style="font-size:24px"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<div id="notesModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input id="notesContent" type="text" class="form-control" value="" placeholder="Isi catatan">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="saveNotes()" data-dismiss="modal">
          Simpan
        </button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
  var cart=[];
    var totalItem = 0;
    var totalPrice = 0;
    var orderProduct = {id:"", name:"", price:0, totalQuantity:0, totalPrice:0, notes:""};
    var cartText ="";
    var notesId ="";
    var form = document.getElementById("order-form");

    document.getElementById("submit-button").addEventListener("click", function () {
      form.submit();
  });

    function addButton(productId, name, price){
        var productAdd = "product-add-"+productId;
        var productOrder = "product-order-"+productId;
        var productOrderQuantity = "product-quantity-"+productId;
        document.getElementById(productAdd).style.display="none";
        document.getElementById(productOrder).style.display="block";
        document.getElementById(productOrderQuantity).innerHTML=1;
        addToCart(productId, name, price);
    }

    function plusButton(productId, name, price){
        var productAdd = "product-add-"+productId;
        var productOrder = "product-order-"+productId;
        var productOrderQuantity = "product-quantity-"+productId;

        for (i = 0; i < cart.length; i++) {
            if (productId == cart[i].id) {
                console.log("match");
                cart[i].totalQuantity += 1;
                cart[i].totalPrice = cart[i].totalQuantity*cart[i].price;
                document.getElementById(productOrderQuantity).innerHTML=cart[i].totalQuantity;
                break;
            }
        } 
        calculateCart();
    }

    function minusButton(productId, name, price){
        var productAdd = "product-add-"+productId;
        var productOrder = "product-order-"+productId;
        var productOrderQuantity = "product-quantity-"+productId;
        for (i = 0; i < cart.length; i++) {
            if (productId == cart[i].id) {
                console.log("match");
                cart[i].totalQuantity -= 1;
                cart[i].totalPrice = cart[i].totalQuantity*cart[i].price;
                document.getElementById(productOrderQuantity).innerHTML=cart[i].totalQuantity;

                if (cart[i].totalQuantity == 0) {
                    cart.splice(i, 1);
                    document.getElementById(productAdd).style.display="block";
                    document.getElementById(productOrder).style.display="none";
                    document.getElementById(productOrderQuantity).innerHTML=0;
                }
                break;
            }
        } 
        calculateCart();
    }

    function addToCart(productId, name, price){
        orderProduct = {id:"", name:"", price:0, totalQuantity:0, totalPrice:0, notes: ""};
        orderProduct.id = productId;
        orderProduct.name = name;
        orderProduct.price = price;
        orderProduct.totalQuantity = 1;
        orderProduct.totalPrice = price;
        orderProduct.notes = "";
        cart.push(orderProduct);
        calculateCart();
    }
    function modalNotes(productId){
        notesId = productId;
        for (i = 0; i < cart.length; i++) {
            if (notesId == cart[i].id) {
                document.getElementById("notesContent").value = cart[i].notes;
                break;
            }
        }
    }
    function saveNotes(){
        var notesContent = "";
        notesContent = document.getElementById("notesContent").value;
        console.log(notesContent); 
        for (i = 0; i < cart.length; i++) {
            if (notesId == cart[i].id) {
                console.log("match:"+notesContent);
                cart[i].notes = notesContent;
                break;
            }
        }
        calculateCart();
        document.getElementById("notesContent").value = "";
    }


    function calculateCart(){
        totalItem = 0;
        totalPrice = 0;
        cartOrderText ="";
        cartInvoiceText ="";

        for (i = 0; i < cart.length; i++) {
            cart[i];
            cartOrderText += '{"id":"'+cart[i].id+'", ';
            cartOrderText += '"name":"'+cart[i].name+'", ';
            cartOrderText += '"price":'+cart[i].price+', ';
            cartOrderText += '"totalQuantity": '+cart[i].totalQuantity+', ';
            cartOrderText += '"totalPrice": '+cart[i].totalPrice+', ';
            cartOrderText += '"notes": "'+cart[i].notes+'"},';
            totalItem += parseInt(cart[i].totalQuantity);
            totalPrice += parseInt(cart[i].totalPrice);
        }

        cartOrderText = cartOrderText.slice(0, -1);
        document.getElementById("cart-item").innerHTML=totalItem;
        document.getElementById("cart-amount").innerHTML=totalPrice.toLocaleString(['ban', 'id']);

        cartInvoiceText += '{"invoiceQuantity":'+totalItem+', ';
        cartInvoiceText += '"invoicePrice":'+totalPrice+'}';
        
        console.log(cartOrderText);
        document.getElementById("invoiceContent").value=cartInvoiceText;
        document.getElementById("orderContent").value=cartOrderText;
    }
</script>

@endsection
@extends('layouts.app')

@section('content')
<style>
.product-box{
    height: auto;
    width: 100%;
    background-color: white;
    border: #4A959C solid 2px;
    margin: 10px;
    border-radius: 10px;
}
.product-picture{
    background-color: grey;
    border-radius: 10px 10px 0px 0px;
    height: 400px;
    
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center; 
    margin-right: 0.5px;
    margin-left: 0.5px;
    /* -webkit-filter: brightness(95%);
    -moz-filter:  brightness(95%);
    -o-filter:  brightness(95%);
    -ms-filter:  brightness(95%);
    filter:  brightness(95%);     */
    /* -webkit-filter: blur(3px);
  -moz-filter: blur(3px);
  -o-filter: blur(3px);
  -ms-filter: blur(3px);
  filter: blur(3px); */
  border-bottom: #4A959C 2px solid;
}

.product-title{
    padding: 10px;
}

a{
    text-decoration: none !important;
    color: black
}

a:hover{
    color: black
}

.product-order{
    text-align: center;
    margin-bottom: 10px;

}
.order-container{
    /* background-color: #ffc311; */
    background-color: white;
    border-radius:10px;
    padding: 50px;
    border: 2px solid #4A959C;
    margin-top: 10px;
}
.product-form{
    width: 50px;
    height: 50px;
    border: 1px grey solid;
    border-radius: 15px;
    text-align: center;
    border: 1px solid #4A959C;
}
.btn-order{
    width: 100%;
    background-color:#4A959C ;
    color: white
}
.btn-add-minus{
    border-radius: 50px;
    height: 40px;
    width: 40px;
    background-color: #EF6C3B;
    color: white
}
.product-description{
    padding: 10px;
    
}
.product-price{
    font-size: 14pt
}
#notes{
    text-align: left
}
.product-container{
    padding: 50px
}
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="product-box">
                @empty($product->picture->first()->name)
                <div class="product-picture" style="background-image: url('{{asset('storage/products/product_default.jpg')}}');">
                </div>
                @else
                <div class="product-picture" style="background-image: url('{{asset('storage/products/'.$product->picture->first()->name)}}');">
                </div>
                @endempty
                <div class="product-container">
                    <div class="product-title">
                        <h3>
                            @if($product->category == "Minuman")
                            <span class="fa fa-beer"></span>
                            @else
                            <span class="fa fa-spoon"></span>
                            @endif
                             {{$product->name}} 
                            <span class="product-price pull-right">
                                Rp {{number_format($product->price,0,",",".")}}
                            </span>
                        </h3>
                    </div>
                    <div class="product-description">
                            <span class="product-restaurant"></span><span class="fa fa-home"> </span> {{$product->business->name}}</span><br>
                            {{-- <span class="product-category"><span class="fa fa-circle"></span> {{$product->category}}, <span class="product-subcategory">{{$product->subcategory}} --}}
                    
                        
                        
                        </span>
                        
                    </div>
                    <div class="product-description">
                        {!!$product->description!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <form method="POST" action="/order/add" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="order-container">
                    <h4>Yang Dipesan</h4>
                    <div class="product-order">
                        <div class="btn btn-md btn-add-minus" onclick="minus()">-</div>
                        <input type="hidden" name="product_id" value="{{$product->unique_id}}">
                        <input id="quantity" class="product-form" type="text" name="quantity" value="1">
                        <div class="btn btn-md btn-add-minus" onclick="plus()">+</div>
                    </div>
                    <script type="text/javascript">
                        function plus(){
                            var quantity = Number(document.getElementById('quantity').value);
                            var quantity_plus = quantity + 1;
                            document.getElementById('quantity').value = quantity_plus;
                        }

                        function minus(){
                            var quantity = Number(document.getElementById('quantity').value);
                            var quantity_minus = quantity - 1;
                            if (quantity_minus>0) {
                                document.getElementById('quantity').value = quantity_minus;
                            }

                        }
                    </script>
                    <p><i class="fa fa-sticky-note" aria-hidden="true"></i> Catatan</p>
                    <div class="form-group">
                        <textarea class="form-control" id="notes" name="notes" cols="3">
                        </textarea>
                    </div>
                    <button class="btn btn-lg btn-order" style="">Pesan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

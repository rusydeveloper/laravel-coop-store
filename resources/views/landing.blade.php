@extends('layouts.app')

@section('content')
<style>
.product-box{
    height: 350px;
    width: 250px;
    background-color: white;
    border: grey solid 0.5px;
    margin: 10px;
    border-radius: 10px;
}
.product-picture{
    background-color: grey;
    border-radius: 10px 10px 0px 0px;
    height: 150px;
    
    background-size: cover; 
    background-position: center;
    margin-right: 0.5px;
    margin-left: 0.5px;
    /* -webkit-filter: brightness(95%);
      -moz-filter:  brightness(95%);
      -o-filter:  brightness(95%);
      -ms-filter:  brightness(95%);
      filter:  brightness(95%);     */
      -webkit-filter: blur(5px);
      -moz-filter: blur(5px);
      -o-filter: blur(5px);
      -ms-filter: blur(5px);
      filter: blur(5px);
  }

  .product-container{
    padding: 10px;
}
.product-order{
    padding: 5px 5px;
}
.btn-order{
    width:100%; background-color: #EF6C3B; color: white; font-weight: 900
}

a{
    text-decoration: none !important;
    color: black
}

a:hover{
    color: black
}
.product-title{
    font-size: 16pt;
    color: #EF6C3B;
    font-weight: 800;
    display: block
}
.product-price{
    font-size: 10pt;
    color: black;
    font-weight: 500;
    display: block;
    text-align: right
}
.product-category{
    font-size: 12pt;
    color: black;
    font-weight: 500;
    
}
.product-subcategory{
    font-size: 11pt;
    color: black;
    font-weight: 500;
    
}

.product-restaurant{
    font-size: 11pt;
    color: black;
    font-weight: 500;
    display: block
    
}


</style>
<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @elseif (session('danger'))
    <div class="alert alert-danger" role="alert">
        {{ session('danger') }}
    </div>
    @elseif (session('warning'))
    <div class="alert alert-warning" role="alert">
        {{ session('warning') }}
    </div>
    @endif
    @if(!empty(Cart::count()))
                               
    <div class="" style="height:auto; width: 100%; background-color: white; padding: 20px 50px; text-align: center; position: fixed; bottom: 10px; left: 0px">
        <div class="row">
            <div class="col-sm-10"></div>
            <div class="col-sm-2"></div>
        </div>
         <span class="badge badge-success"style="background-color:#4A959C; font-family: 'Raleway' !important; font-size: 16pt;" >
                                        {{Cart::count()}}
                                </span>
        <a href="{{ route('cart') }}">
            <button class="btn btn-order" style="background-color: #4A959C">Selesai</button>
        </a>
    </div>
    @else
    @endif
    
    <div class="d-flex flex-wrap align-items-center align-content-center" style="height:auto">
        @forelse($products as $item)
        <a href="/product/show/{{$item->unique_id}}">
            <div class="product-box">
                @empty($item->picture->first()->name)
                <div class="product-picture" style="background-image: url('{{asset('/img/default/food.jpg')}}');">
                </div>
                @else
                <div class="product-picture" style="background-image: url('{{asset('/img/default/food.jpg')}}');">
                    @endempty
                    <div class="product-container">
                        <span class="product-title"><span class="fa fa-spoon"></span> {{$item->name}}</span>
                        <span class="product-price">
                            Rp {{number_format($item->price,0,",",".")}}
                        </span>

                        <span class="product-category"><span class="fa fa-circle-o"></span> {{$item->category}},</span>
                        <span class="product-subcategory">{{$item->subcategory}}</span>
                        <span class="product-restaurant"><span class="fa fa-home"> </span> {{$item->business->name}}</span>

                    </div>
                </div>
            </a>
            @empty
            @endforelse
        </div>
    </div>
    @endsection

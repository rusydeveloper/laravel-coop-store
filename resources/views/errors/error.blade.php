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
    height: 200px;
    
    background-size: cover; 
    margin-right: 0.5px;
    margin-left: 0.5px;
    -webkit-filter: brightness(95%);
      -moz-filter:  brightness(95%);
      -o-filter:  brightness(95%);
      -ms-filter:  brightness(95%);
      filter:  brightness(95%);    
}

.product-container{
    padding: 10px;
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
    color: black;
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
      <div class="d-flex flex-wrap align-items-center align-content-center" style="height:auto">
            @forelse($products as $item)
            <a href="/product/show/{{$item->unique_id}}">
            <div class="product-box">
                @empty($item->picture->first()->name)
                <div class="product-picture" style="background-image: url('{{asset('storage/products/product_default.jpg')}}');">
                </div>
                @else
                <div class="product-picture" style="background-image: url('{{asset('storage/products/'.$item->picture->first()->name)}}');">
                </div>
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

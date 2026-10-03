@extends('components.layouts.app')

@section('content')
<style>
    .box {
        max-width: 500px;
        margin: 60px auto;
        padding: 25px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        text-align: center;
    }

    .product-img {
        width: 180px;
        border-radius: 10px;
        margin: 15px 0;
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #0d6efd;
        margin: 15px 0;
    }
</style>

<div class="box">
    <h2>{{ $product->name }}</h2>

    <img src="{{ $product->image }}" class="product-img">

    <p>{{ $product->description }}</p>

    <div class="price">
        ${{ number_format($product->price, 2) }}
    </div>

    <form action="{{ route('checkout', $product->id) }}" method="POST">
        @csrf
        <button class="btn btn-success w-100">
            Generate KHQR to Pay
        </button>
    </form>
</div>
@endsection
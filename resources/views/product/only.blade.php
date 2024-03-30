@extends('layout')

@section('title')
    {{ $product->name }}
@endsection

@section('body')
    <div class="border border-secondary rounded m-2 p-3">
        @auth
            <div class="d-flex">
                @if (auth()->user()->role < 2)
                    <form action="{{ @route('productDelete', ['id' => $product->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-danger m-2">Удалить товар</button>
                    </form>
                    <form action="{{ @route('productEdit', ['id' => $product->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-secondary m-2">Редактировать товар</button>
                    </form>
                @endif
            </div>
        @endauth
        <h1>{{ $product->name }}</h1>
        <span>{{ $product->category }}</span>
        <img src="{{ asset('storage/imgs/products/'.$product->image) }}" alt="Изображение продукта">
        <span>{!! $product->description !!}</span>
        <h4>{{ $product->cost }}₽</h4>


        @auth
            <form action="{{ @route('addToCart', ['id' => $product->id]) }}" method="post">
                @csrf
                <button class="btn btn-primary">Добавить в корзину</button>
            </form>
        @endauth

    </div>
@endsection

@extends('layout')

@section('title')
    Каталог
@endsection

@php
    $products = $data['products'];
    $types = $data['types'];
@endphp

@section('body')
    <div class="border border-secondary rounded m-2 p-3">
        <div class="d-flex">
            @auth
                @if (auth()->user()->role < 2)
                    <form action="{{ @route('productNew') }}" method="post">
                        @csrf
                        <button class="btn btn-primary m-2">Новый товар</button>
                    </form>
                @endif
            @endauth
            <button type="button" class="btn btn-secondary m-2" data-toggle="modal" data-target="#exampleModal">
                Фильтры
            </button>
            <hr>
            
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form class="modal-content" method="GET" action="{{ route('shop') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Фильтрация</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach ($types as $type)
                                <input type="checkbox" name="{{ $type['id'] }}" id="type{{ $type['id'] }}" checked>
                                <label for="type{{ $type['id'] }}">{{ $type['name'] }}</label>
                            @endforeach
                            <br>
                            <select name="order_by" id="">
                                <option value="cost">По цене</option>
                                <option value="created_at">По дате добавления</option>
                            </select>
                            <select name="sequence" id="">
                                <option value="desc">Убывание</option>
                                <option value="asc">Возрастание</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            <button class="btn btn-primary">Применить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @foreach ($products as $product)
            <div>
                <a href="{{ route('seeProduct', ['id' => $product->id]) }}">
                    <h3>{{ $product->name }}</h3>
                </a>
                <p>{{ $product->cost }}₽</p>
                {{-- <p>{{ $product->category }}</p> --}}
            </div>
        @endforeach


        <div class="m-2">
            {{ $products->links() }}
        </div>
    </div>
@endsection

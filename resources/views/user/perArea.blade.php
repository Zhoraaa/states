@extends('layout')

@section('title')
    Личный кабинет
@endsection

@section('body')
    @php
        $user = auth()->user();
    @endphp
    <div class="border border-secondary rounded m-2 p-3">
        <h1>{{ $user->login }}</h1>
        <p>На сайте с {{ $user->created_at }}</p>
    </div>
@endsection

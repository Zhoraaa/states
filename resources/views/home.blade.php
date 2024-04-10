@extends('layout')

@section('title')
    Главная
@endsection

@php
    $posts = $data['posts'];
    $desc = $data['desc'];
@endphp

@section('body')
    <div class="border border-secondary rounded m-2 p-3">
        @auth
            @if (auth()->user()->role < 3)
                <a href="{{ route('postNew') }}" class="btn btn-primary m-2">Написать новость</a>
            @endif
        @endauth
        @if ($desc)
            <a href="?desc=true" class="btn btn-secondary">
                Сначала старые
            </a>
        @else
            <a href="?" class="btn btn-secondary">
                Сначала новые
            </a>
        @endif
        @if (isset($posts))
            <div class="m-2">
                {{ $posts->links() }}
            </div>
            @foreach ($posts as $post)
                <hr>
                <div class="border border-secondary rounded p-4">
                    <a href="{{ route('seePost', ['id' => $post->id]) }}">
                        <h2>
                            {{ $post->theme }}
                        </h2>
                    </a>
                    <span class="text-secondary font-weight-light font-italic">Автор: {{ $post['author'] }}</span>
                    <p>{!! substr($post->text, 0, 200) !!}</p>
                    @auth
                        @if (auth()->user()->role < 3)
                            @php
                                $btnClass = $post->blocked ? 'warning' : 'danger';
                                $btnText = $post->blocked ? 'Деблокировать' : 'Заблокировать';
                            @endphp
                            <a href="{{ route('block', ['id' => $post->id]) }}" class="btn btn-{{ $btnClass }}">
                                {{ $btnText }}
                            </a>
                        @endif
                    @endauth
                </div>
            @endforeach
            <div class="m-2">
                {{ $posts->links() }}
            </div>
        @else
            Новостей пока нет
        @endif
    </div>
@endsection

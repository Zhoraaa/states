@extends('layout')

@section('title')
    Главная
@endsection

@section('body')
    <div class="border border-secondary rounded m-2 p-3">
        @auth
            @if (auth()->user()->role < 3)
                <a href="{{ route('postNew') }}" class="btn btn-primary m-2">Написать новость</a>
            @endif
        @endauth
        @if (isset($posts))
            <div class="m-2">
                {{ $posts->links() }}
            </div>
            @foreach ($posts as $post)
                <hr>
                <div class="border border-secondary rounded p-4">
                    <a href="{{ route('seePost', ['id' => $post->id]) }}">
                        <h2>
                            Тема: {{ $post->theme }}
                        </h2>
                    </a>
                    <span class="text-secondary font-weight-light font-italic">Автор: ({{ $post['author'] }})</span>
                    <p>{!! substr($post->text, 0, 200) !!}</p>
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

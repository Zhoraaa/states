@php
    $post = $data['post'];
    $likes = $data['likes'] ?? 0;
    $dislikes = $data['dislikes'] ?? 0;
    $comments = $data['comments'] ?? null;
@endphp

@extends('layout')

@section('title')
    {{ $post->theme }}
@endsection

@section('body')
    @auth
        <div class="d-flex">
            @if (auth()->user()->id === $post->author_id || auth()->user()->role < 3)
                <a href="{{ @route('postEdit', ['id' => $post->id]) }}" class="btn btn-secondary m-2">Редактировать пост</a>
                <a href="{{ @route('postDelete', ['id' => $post->id]) }}" class="btn btn-danger m-2">Удалить пост</a>
            @endif
        </div>
    @endauth

    <div class="border border-secondary rounded m-2 p-3">
        <h1>
            {{ $post->theme }}
            <span class="text-secondary font-weight-light font-italic">({{ $post['author'] }})</span>
            <a href="{{ route('like', ['id' => $post->id]) }}" class="btn btn-success ml-2">Лайк ({{ $likes }})</a>
            <a href="{{ route('dislike', ['id' => $post->id]) }}" class="btn btn-danger ml-2">Дизлайк
                ({{ $dislikes }})</a>
        </h1>
        <span>{!! $post->text !!}</span>
    </div>

    <div class="m-3 p-2">
        <h2>Комментарии:</h2>
        @if (auth()->user() && !auth()->user()->banned)
            <form action="{{ route('commNew', ['id' => $post->id]) }}" method="POST">
                @csrf
                <textarea name="commText" cols="30" rows="10" id="tinyMCE"></textarea>
                <button class="btn btn-primary mt-2">Сохранить</button>
            </form>
        @endif

        @if (isset($comments))
            @foreach ($comments as $comment)
                <div>
                    <h4>
                        <b>{{ $comment->author }}</b>
                        <i>{{ $comment->created_at }}</i>
                    </h4>
                    <p>{!! $comment->text !!}</p>
                </div>
            @endforeach
        @endif
    </div>
@endsection

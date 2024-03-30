@php
    $post = $theme['firstPost'];
    $replies = $theme['replies'];
@endphp

@extends('layout')

@section('title')
    {{ $post->theme }}
@endsection

@section('body')
    @csrf
    @auth
        <div class="d-flex">
            @if (!auth()->user()->banned)
                <a href="{{ @route('postReply', ['idToReply' => $post->id]) }}">
                    <button class="btn btn-primary m-2">Продолжить ветку</button>
                </a>
            @endif
            @if (auth()->user()->id === $post->author_id || auth()->user()->role < 3)
                <form action="{{ @route('postEdit', ['id' => $post->id]) }}" method="post">
                    @csrf
                    <button class="btn btn-secondary m-2">Редактировать пост</button>
                </form>
                <form action="{{ @route('postDelete', ['id' => $post->id]) }}" method="post">
                    @csrf
                    <button class="btn btn-danger m-2">Удалить пост</button>
                </form>
            @endif
        </div>
    @endauth

    <div class="border border-secondary rounded m-2 p-3 post" id="{{ $post['id'] }}">
        <h1>
            {{ $post->theme }}
            <span class="text-secondary font-weight-light font-italic">{{ $post['author'] }}</span>

            <button class="btn btn-success react-btn" id="like">
                Лайк (0)
            </button>
            <button class="btn btn-danger react-btn" id="dislike">
                Дизлайк (0)
            </button>
        </h1>
        <span>{!! $post->text !!}</span>
    </div>

    @if ($replies)
        <div class="m-2 p-3">
            <h4>Ветка:</h4>
            @foreach ($replies as $reply)
                <div class="border border-secondary rounded m-2 p-3">
                    <h4 class="text-secondary">
                        <a href="{{ @route('seePost', ['id' => $reply['id']]) }}">{{ $reply['theme'] }}</a>
                        <span class="text-secondary font-weight-light font-italic">({{ $reply['author'] }})</span>
                    </h4>
                    <hr>
                    <p>{!! $reply['text'] !!}</p>
                </div>
            @endforeach
        </div>
    @endif

    <script>
        $('.react-btn').click(
            function() {
                let react = $(this).attr('id');
                let id = $('.post').attr('id')

                console.log(react + ' ' + id);

                $.ajax({
                    url: '/react/' + id + '/' + react,
                    method: 'POST',
                    success: function(response) {
                        console.log('Успех');
                    },
                    error: function(xhr, status, error) {
                        console.log('Ошибка');
                    }
                })
            }
        )
    </script>

@endsection

@extends('layout')

@section('title')
    Редактор статей
@endsection

@php
    $post = $data['post'];
    $categories = $data['categories'];
@endphp

@section('body')
    <form action="{{ @route('savePost') }}" method="POST" class="border border-secondary rounded m-2 p-3 form-auth">
        @csrf
        <input type="text" class="hide" name="post_id" value="{{ isset($post) ? $post->id : null }}">
        <div class="form-block-wrapper border border-secondary rounded">
            <input type="text" name="theme" class="theme-inp" placeholder="Тема поста..."
                value="{{ isset($post) ? $post->theme : null }}">
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <textarea name="text" id="tinyMCE" placeholder="Текст поста...">
                {{ isset($post) ? $post->text : null }}
            </textarea>
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <select name="category" id="">
                @if (!isset($post))
                    <option value="" selected disabled>Выберите категорию</option>
                @endif
                @foreach ($categories as $category)
                @php
                    $selected = null;
                    if (isset($post)) {
                        if ($post->category_id === $category->id) {
                            $selected = "selected";
                        }
                    }
                @endphp
                    <option value="{{ $category->id }}" {{$selected}}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-block-wrapper">
            <button type="submit" class="btn btn-primary">Опубликовать</button>
        </div>
    </form>
@endsection

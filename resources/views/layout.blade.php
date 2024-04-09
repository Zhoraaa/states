<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    {{-- TineMCE --}}
    <script src="https://cdn.tiny.cloud/1/uig2iyio5vvat8bnvd2319qa49zs1kp1ktl25x3q5u1l5og8/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#tinyMCE',
            language: 'ru',
            menubar: 'edit format insert view',
            plugins: '',
            toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough removeformat  | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap',
        });
    </script>
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    {{-- Local --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    <x-header></x-header>
    
    <x-messages></x-messages>

    @yield('body')

    <script src="{{ asset('scripts/fade-out-msgs.js') }}"></script>

</body>

</html>

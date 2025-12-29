@extends('layout.app')

@section('content')
    <section class="h-screen">
        <form action="{{ route('courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data" class="center form">
            @csrf

            <h2>Создание урока</h2>
            <div class="h2-subtitle">Укажите контент</div>
            <x-input name="name" placeholder="Название"/>
            <x-input name="description" placeholder="Описание"/>
            <x-input name="hours" type="number" placeholder="Длительность"/>
            <x-input name="video_link" type="url" placeholder="Ссылка"/>
            <button>Сохранить</button>
        </form>
    </section>
@endsection

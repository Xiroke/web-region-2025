@extends('layout.app')

@section('content')
<section class="h-screen">
    <form action="{{ route('courses.lessons.update', [$course, $lesson]) }}" method="POST" enctype="multipart/form-data" class="center form">
        @csrf

        @method('PUT')

        <h2>Редактирование курса</h2>
        <div class="h2-subtitle">Создайте качественный продукт</div>
        <x-input name="name" placeholder="Название" :value="$lesson->name ?? ''"/>
        <x-input name="description" placeholder="Описание" :value="$lesson->description ?? ''"/>
        <x-input name="hours" type="number" placeholder="Длительность" :value="$lesson->hours ?? ''"/>
        <x-input name="video_link" type="url" placeholder="Ссылка" :value="$lesson->video_link ?? ''"/>
        <button>Сохранить</button>
    </form>
</section>
@endsection

@extends('layout.app')

@section('content')
<section class="h-screen">
    <form action="{{ route('courses.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="center form">
        @csrf

        @method('PUT')

        <h2>Редактирование курса</h2>
        <div class="h2-subtitle">Создайте качественный продукт</div>
        <x-input name="name" placeholder="Название" :value="$item->name ?? ''"/>
        <x-input name="description" placeholder="Описание" :value="$item->description ?? ''"/>
        <x-input name="hours" type="number" placeholder="Длительность" :value="$item->hours ?? ''"/>
        <x-input name="price" step="0.01" type="number" placeholder="Цена" :value="$item->price ?? ''"/>
        <x-input-date name="start_date" placeholder="Дата начала" :value="$item->start_date ?? ''"/>
        <x-input-date name="end_date" placeholder="Дата окончания" :value="$item->end_date ?? ''"/>
        <x-input-file name="image" accept="image/jpeg"/>
        <button>Сохранить</button>
    </form>
</section>
@endsection

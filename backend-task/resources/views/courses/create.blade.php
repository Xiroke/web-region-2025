@extends('layout.app')

@section('content')
    <section class="h-screen">
        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="center form">
            @csrf

            <h2>Создание курса</h2>
            <div class="h2-subtitle">Создайте качественный продукт</div>
            <x-input name="name" placeholder="Название"/>
            <x-input name="description" placeholder="Описание"/>
            <x-input name="hours" type="number" placeholder="Длительность"/>
            <x-input name="price" step="0.01" type="number" placeholder="Цена"/>
            <x-input-date name="start_date" placeholder="Дата начала"/>
            <x-input-date name="end_date" placeholder="Дата окончания"/>
            <x-input-file name="image" accept="image/jpeg"/>
            <button>Сохранить</button>
        </form>
    </section>
@endsection

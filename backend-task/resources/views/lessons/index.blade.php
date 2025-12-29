@extends('layout.app')

@section('head')
  @vite(['resources/css/courses.css'])
@endsection

@section('content')
@if (session('success'))
  <div class="alert-success hide-3s">
    {{ session('success') }}
  </div>
@endif
<section class="courses">
  <div class="flex-between">
    <div>
      <h1>Курсы</h1>
      <div class="h1-subtitle">Управление каталогом и контентом</div>
    </div>
    <a href="{{ route('courses.create') }}" class="foreground btn">Добавить курс</a>
  </div>
  <div class="courses-list">
    @foreach($items as $item)
      <div class="block">
      <img
        src="{{asset('storage/' . $item->img)}}"
        alt="фото курса"
        class="block__image"
      >
      <h3>{{$item->name}}</h3>
      <div class="block__stats">
        <div class="block__stat">
          <div class="block__stat__title">Дата начала</div>
          <div class="block__stat__value">{{$item->start_date}}</div>
        </div>
        <div class="block__stat">
          <div class="block__stat__title">Дата конца</div>
          <div class="block__stat__value">{{$item->end_date}}</div>
        </div>
        <div class="block__stat">
          <div class="block__stat__title">Продолжительность</div>
          <div class="block__stat__value">{{$item->hours}}</div>
        </div>
        <div class="block__stat">
          <div class="block__stat__title">Цена</div>
          <div class="block__stat__value">{{$item->price}} Р</div>
        </div>
      </div>
      <a class="btn block__action w-full" href="{{route('courses.show', ['course' => $item->id])}}">Перейти</a>
    </div>
    @endforeach
  </div>
</section>
@endsection
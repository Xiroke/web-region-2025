@php use function PHPUnit\Framework\isEmpty; @endphp
@extends('layout.app')

@section('head')
@vite(['resources/css/course-detail.css'])
@endsection

@section('content')
  <section class="course-detail">
    <a href="{{route('courses.index')}}">&lt= Назад</a>
    <h1>Курс "{{$item->name}}"</h1>
    <div class="h1-subtitle">Общая информация</div>
    <div class="content">
      <div class="w-full">
        <h2>Управление курсом</h2>
        <div class="flex-12 w-full">
          <x-delete :action="route('courses.destroy', $item)">
            <button class="btn destructive" onclick="confirm('Вы уверены')">Удалить</button>
          </x-delete>
          <a href="{{route('courses.edit', $item)}}" class="btn">Обновить</a>
          <a href="{{route('courses.lessons.create', $item)}}" class="btn blue">Добавить урок</a>
        </div>
      </div>


      <div class="w-full">
        <h2>Уроки</h2>
        <table class="course-detail__table">
          <thead>
          <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Длительность</th>
            <th>Ссылка</th>
            <th>Действия</th>
          </tr>
          </thead>
          <tbody>
          @foreach($item->lessons as $lesson)
            <tr>
              <td>{{$lesson->name}}</td>
              <td>
                {{$lesson->description}}
              </td>
              <td>2 ч</td>
              <td>
                <a href="https://super-tube.cc/video/v23189">
                  {{$lesson->video_link}}
                </a>
              </td>
              <td>
                <a href="{{route('courses.lessons.edit', [$item, $lesson])}}">Обновить</a><br>
                <x-delete :action="route('courses.lessons.destroy', [$item, $lesson])">
                  <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Удалить</a>
                </x-delete>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection


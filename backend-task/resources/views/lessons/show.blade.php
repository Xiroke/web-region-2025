@extends('layout.app')

@section('head')
@vite(['resources/css/course-detail.css'])
@endsection

@section('content')
  <section class="course-detail">
    <h1>Курс "{{$item->name}}"</h1>
    <div class="h1-subtitle">Общая информация</div>
    <div class="content">
      <div class="w-full">
        <h2>Управление курсом</h2>
        <div class="flex-12 w-full">
          <x-delete :action="route('courses.destroy', $item)">
            <button class="btn destructive" onclick="confirm('Вы уверены')">Удалить</button>
          </x-delete>
          <a href="{{route('courses.edit', $item->id)}}" class="btn">Обновить</a>
          <a href="{{route('lessons.create')}}" class="btn blue">Добавить урок</a>
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
          <tr>
            <td>Основы</td>
            <td>
              Обьявление переменных, математические операции, условия и
              циклы
            </td>
            <td>2 ч</td>
            <td>
              <a href="https://super-tube.cc/video/v23189">
                https://super-tube.cc/video/v23189
              </a>
            </td>
            <td>
              <a href="">Обновить</a><br>
              <a href="">Удалить</a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection


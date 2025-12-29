@extends('layout.app')

@section('head')
  @vite(['resources/css/students.css'])
@endsection

@section('content')
  <section class="students">
    <a href="{{route('index')}}">&lt= Назад</a>
    <h1>Студенты</h1>
    <div class="h1-subtitle">Управление списком учащихся</div>
    <div class="content">
      <form action="" method="GET">
        <input id="search" type="text" placeholder="Поиск..." name="course_query" value="{{ request('course_id') }}">
        <button class="foreground">Поиск</button>
      </form>
      <table class="students__table">
        <thead>
        <tr>
          <th>Email</th>
          <th>Курс</th>
          <th>Дата записи</th>
          <th>Статус оплаты</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
          <tr>
            <td>{{$item->student->email}}</td>
            <td>{{$item->course->name}}</td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->status->label()}}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </section>
@endsection

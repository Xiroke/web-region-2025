@extends('layout.app')

@section('head')
@vite(['resources/css/index.css'])
@endsection

@section('content')
  <section class="main">
    <h1>Админ панель</h1>
    <div class="main__actions">
      <div class="block">
        <h3>Курсы</h3>
        <p>Управление каталогом и контентом</p>
        <a href="{{route('courses.index')}}" class="btn">Перейти</a>
      </div>

      <div class="block">
        <h3>Студенты</h3>
        <p>Управление списком учащихся</p>
        <a href="{{route('students.index')}}" class="btn">Перейти</a>
      </div>
    </div>
  </section>
@endsection



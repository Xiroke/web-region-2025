@extends('layout.app')

@section('head')
  @vite(['resources/css/login.css'])
@endsection

@section('content')
  <section class="h-screen login">
    <img class="login__image" src="{{ asset('login-image.jpg') }}" alt="фото входа в аккаунт"
    >
    <form action="{{ route('auth.authenticate') }}" method="post" class="center form">
      @csrf

      <h2>Вход</h2>
      <div class="h2-subtitle">Получите доступ к панели управления</div>
      <x-input name="email" type="email" placeholder="Email" />
      <x-input name="password" type="password" placeholder="Пароль" />
      <button>Войти</button>
    </form>
  </section>
@endsection




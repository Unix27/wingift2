@extends('layouts.app')
@section('content')

<div class="auth">
	<div class="container">
		<div class="login">
			<div class="login__wrapper">
				<h1 class="title">Рады видеть вас!</h1>
				<form action="{{ route('login') }}" method="POST">
					@csrf
					<div class="input @if($errors->has('email')) error @endif">
						<input name="email" type="text" placeholder="Введите email">
						<img src="{{ url('/icons/input-user.svg') }}">
						<div class="error__info"></div>
						<span class="error__text">{{ $errors->has('email')? $errors->get('email')[0] : '' }}</span>
					</div>
					<div class="input @if($errors->has('password')) error @endif">
						<input name="password" type="password" placeholder="Введите пароль">
						<img src="{{ url('/icons/input-lock.svg') }}">
						<div class="error__info"></div>
						<span class="error__text">{{ $errors->has('password')? $errors->get('password')[0] : '' }}</span>
					</div>
					<div class="forgot">
						<a href="{{ route('password.request') }}">Забыли пароль?</a>
					</div>
					<button class="button main-button">Войти</button>
				</form>
				<div class="auth__alt">Нет еще учетной записи? <a href="{{ route('register') }}">Создайте ее!</a></div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/auth.css">
@endpush
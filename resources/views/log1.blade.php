@extends('layouts.app')
@section('content')
<div class="auth">
	<div class="container">
		<div class="login">
			<div class="login__wrapper">
				<h1 class="title">Рады видеть вас!</h1>
				<form>
					<div class="input">
						<input name="email" type="text" placeholder="Введите email">
						<img src="{{ url('/icons/input-user.svg') }}">
					</div>
					<div class="input">
						<input name="password" type="text" placeholder="Введите пароль">
						<img src="{{ url('/icons/input-lock.svg') }}">
					</div>
					<div class="forgot">
						<a href="">Забыли пароль?</a>
					</div>
					<button class="button main-button">Войти</button>
				</form>
				<div class="auth__alt">Нет еще учетной записи? <a href="">Создайте ее!</a></div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/auth.css">
@endpush
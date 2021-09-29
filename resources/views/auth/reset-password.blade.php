@extends('layouts.app')
@section('content')

<div class="auth">
	<div class="container">
		<div class="login">
			<div class="login__wrapper">
				<h1 class="title">Изменение пароля</h1>
				<form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
					<div class="input @if($errors->has('email')) error @endif">
						<input name="email" type="text" placeholder="Введите email" value="{{ old('email', $request->email) }}">
						<img src="{{ url('/icons/input-user.svg') }}">
						<div class="error__info"></div>
						@error('email')
						<span class="error__text">{{ $message }}</span>
						@enderror
					</div>
					<div class="input @if($errors->has('password')) error @endif">
						<input name="password" type="password" placeholder="Введите пароль">
						<img src="{{ url('/icons/input-user.svg') }}">
						<div class="error__info"></div>
						@error('password')
						<span class="error__text">{{ $message }}</span>
						@enderror
					</div>
					<div class="input @if($errors->has('password_confirmation')) error @endif">
						<input name="password_confirmation" type="password" placeholder="Подтвердите пароль">
						<img src="{{ url('/icons/input-user.svg') }}">
						<div class="error__info"></div>
						@error('password_confirmation')
						<span class="error__text">{{ $message }}</span>
						@enderror
					</div>
					<button class="button main-button">Отправить</button>
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
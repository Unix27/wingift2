@extends('layouts.app')
@section('content')

<div class="auth">
	<div class="container">
		<div class="login">
			<div class="login__wrapper">
				<h1 class="title">Забыли пароль?</h1>
				<p>Введите свой email-адрес и мы отправим Вам ссылку для сброса пароля.</p>
				<form action="{{ route('password.email') }}" method="POST">
					@csrf
					<div class="input @if($errors->has('email')) error @endif">
						<input name="email" type="text" placeholder="Введите email">
						<img src="{{ url('/icons/input-user.svg') }}">
						<div class="error__info"></div>
						@error('email')
						<span class="error__text">{{ $message }}</span>
						@enderror
					  	@if (session('status'))
                            <div class="alert alert-success" style="padding-top: 15px;color: green;">
                                {{ session('status') }}
                            </div>
                        @endif
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
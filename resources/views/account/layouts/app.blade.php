@extends('layouts.app')
@section('content')

<div class="account">
	<div class="container account__wrapper">
		<div class="account__meta">
			<img class="account__photo" src="{{ url('images/user.png') }}">
			<div class="account__user">
				<span>{{ $user->fullname }}</span>
			</div>
			<div class="account__menu">
				<ul>
                    <li class="active"><a href="{{ route('account.draw.list') }}">Розыгрыши</a></li>
                    <li class="active"><a href="{{ route('account.course.list') }}">Курсы</a></li>
                    <li class="active"><a href="{{ route('account.settings.subscription') }}">Подписка</a></li>
					<li class="active"><a href="{{ route('account') }}">Настройки</a></li>
				</ul>
			</div>
			<a href="{{ route('logout') }}" class="account__logout">
				<img src="{{ url('/icons/logout.svg') }}">
				<span>Выйти</span>
			</a>
		</div>
		<div class="account__content">

			@yield('account_content')

            @yield('subscription_content')

            @yield('courses_content')

            @yield('draws_content')

		</div>
	</div>
</div>
@endsection
@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/account.css">
@endpush

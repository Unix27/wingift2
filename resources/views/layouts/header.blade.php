<header>

	<div class="container header">
		<a href="{{ url('/') }}" class="logo">
			<img src="{{ url('/images/logo.svg') }}">
			<span>wingifts</span>
		</a>
		<ul class="menu">
			<li><a href="{{ url('/help') }}">Помощь</a></li>
		</ul>
		@if($user)
		<a href="{{ route('account') }}" class="auth">
			<img src="{{ url('/icons/user.svg')}}">
			<span>{{ $user->name }}</span>
		</a>
			@if(!$subscribed)
				<a href="{{ route('account') }}" class="button main-button">Подписаться</a>
			@endif
		@else
		<a href="{{ route('login') }}" class="auth">
			<img src="{{ url('/icons/user.svg')}}">
			<span>Авторизация</span>
		</a>
		<a href="{{ route('register') }}" class="button main-button">Попробовать бесплатно</a>
		@endif
		<button class="hamburger hamburger--squeeze" type="button" onclick="this.classList.toggle('is-active'); document.getElementsByTagName('html')[0].classList.toggle('overflow') ">
		  <span class="hamburger-box">
		    <span class="hamburger-inner"></span>
		  </span>
		</button>
		<div class="mobile-menu">
			<ul>
				<li><a href="{{ url('/help') }}" onclick="document.querySelector('.hamburger').classList.toggle('is-active'); document.getElementsByTagName('html')[0].classList.toggle('overflow') ">Помощь</a></li>
			</ul>
			@if(!$user)
				<a href="{{ route('register') }}" class="button main-button large-button">Попробовать бесплатно</a>
			@elseif(!$user->hasRole('subscriber'))
				<a href="{{ route('account') }}" class="button main-button large-button">Оформить подписку</a>
			@endif
		</div>
	</div>
</header>

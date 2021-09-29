<DOCTYPE html>
<html lang=”en-US”>
	<head>
	<meta charset=”utf-8">
	</head>
	<body>
		<h2>Добро пожаловать на Wingifts</h2>
		<p>Ваш логин: {{ $login }}</p>
		<p>Ваш пароль: {{ $password }}</p>
		<br>	
		<p>Вы можете перейти в Личный кабинет: <a href="{{ url('/login') }}">{{ url('/login') }}</a></p>
	</body>
</html>
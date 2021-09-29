@extends('account.layouts.app')
@section('account_content')

<div class="account__content-header">
	Настройки
</div>
<div class="account__content-inner">
	<form method="POST" action="{{ route('account.update') }}" class="setting-group">
		@csrf
		<label>Личные данные</label>
		<div class="form-group">
			<div class="input @if($errors->has('name')) error @endif">
				<input name="name" type="text" placeholder="Имя" value="{{ $user->name }}">
				<img src="{{ url('/icons/input-user.svg') }}">
			</div>
			<div class="input">
				<input name="lastname" type="text" placeholder="Фамилия" value="{{ $user->lastname }}">
				<img src="{{ url('/icons/input-user.svg') }}">
			</div>
		</div>
		<button class="button main-button">Внести изменения</button>
	</form>

	<div class="setting-group">
		<label>E-mail</label>
		<div class="input">
			<input type="text" readonly="readonly" placeholder="Электронная почта" value="{{ $user->email }}">
			<img src="{{ url('/icons/input-mail.svg') }}">
		</div>
	</div>

	<div class="setting-group">
		<label>Изменение пароля</label>
		<br>
		<a href="#" class="button main-button" id="password-change">Сменить пароль</a>
	</div>
</div>



<div class="popup__wrapper" id="password-reset">
	<div class="popup">
		<div class="popup__header">
			<img src="{{ url('/icons/close.svg') }}" onclick="closePopup()">
		</div>
		<div class="popup__title"></div>
		<div class="popup__desc"></div>
	</div>
</div>
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

	$('#password-change').on('click', function() {
		let data = {
			email: '{{ $user->email }}'
		};

		$.ajax({
            url: "{{ url('account/password-reset') }}",
						type: 'POST',
						data: data,
						headers: {
							'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
						}
        }).done(function (response) {
					$('#password-reset .popup__desc').text(response);
					openPopup('password-reset');
        }).fail(function (response) {
	        console.log(response);
        });
	});
</script>
@endpush

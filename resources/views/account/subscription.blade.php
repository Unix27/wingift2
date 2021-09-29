@extends('account.layouts.app')
@section('subscription_content')

<div class="account__content-header">
	Подписка
</div>
<div class="account__content-inner">

	<label>Параметры подписки</label>

    <br>

    @if($user->activeSubscription || $user->failedSubscription)
        У вас оформлена подписка. Ваша подписка продлевается каждые {{ $subscription_days }} дней до момента пока вы ее не отмените и стоит {{ $subscription_amount_rub }} руб за {{ $subscription_days }} дней.
    @else
        <h2>У вас нет активных подписок</h2>
        Получите доступ ко всем курсам и розыгрышам
        <br>
    @endif

    <br>
    <br>

    <div class="switch__wrapper">
        <label class="switch a @if($user->activeSubscription || $user->failedSubscription) js-popup @endif" data-target="unsubscribe">
            <input type="checkbox" @if($user->activeSubscription || $user->failedSubscription) checked @endif>
            <span class="slider round"></span>
        </label>
        <div class="switch__wrapper-text">Использовать подписку</div>
    </div>


</div>

<div class="account__content-footer">
</div>

<div class="popup__wrapper" id="unsubscribe">
	<div class="popup">
		<div class="popup__header">
			<img src="{{ url('/icons/close.svg') }}" onclick="closePopup()">
		</div>
		<div class="popup__title">Вы действительно хотите отписаться?</div>
		<div class="popup__desc red">Отключение подписки приведёт к тому, что в дальнейшем у Вас не будет списываться оплата за пользование нашим сервисом, а также Вы потеряете доступ к платному контенту, который находится на платформе после окончания пробного или уже оплаченного периода.</div>

		<div class="popup__content">
			<div class="popup__content_buttons">
			<button class="button third-button large-button button-unsubscribe" onclick="closePopup()">Да</button>
			<button class="button main-button large-button" onclick="closePopup()">Нет</button>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$('.switch input').on('change', function(event) {
		if($('.switch').hasClass('js-popup')) {
			$(this).prop('checked', true);
			return;
		}

		$.ajax({
            url: "{{ route('account.subscription') }}",
						type: 'POST',
						headers: {
							'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
						}
        }).done(function (response) {
					console.log(response);
					openPopup('thanks');
					$('.switch').addClass('js-popup');
        }).fail(function (response) {
	        console.log(response);
        });
	});

	$('.button-unsubscribe').on('click', function() {
		$.ajax({
            url: "{{ route('account.subscription') }}",
						type: 'POST',
						headers: {
							'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
						}
        }).done(function (response) {
					console.log(response);
					$('.switch input').prop('checked', false);
					$('.switch').removeClass('js-popup');
        }).fail(function (response) {
	        console.log(response);
        });
	});

</script>
@endpush

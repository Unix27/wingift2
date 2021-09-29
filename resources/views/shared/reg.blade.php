<div class="auth">
	<div class="container">
		<div class="register">
			<div class="register__wrapper">
				<h1 class="register__title">Подписка WinGifts</h1>
				<div class="register__desc">Узнавай о топовых розыгрышах и изучай полезную информацию<br>в IT, PR и Digital направлениях 3 дня бесплатно<br>Ежедневно получай актуальную информацию за привязку карты</div>
				<form class="first-step">

					<div class="form-group">
						<div class="input input_firstname">
							<input name="firstname" type="text" placeholder="Имя">
							<img src="{{ url('/icons/input-user.svg') }}">
							<div class="error__info"></div>
							<span class="error__text"></span>
						</div>
						<div class="input input_lastname">
							<input name="lastname" type="text" placeholder="Фамилия">
							<img src="{{ url('/icons/input-user.svg') }}">
							<div class="error__info"></div>
							<span class="error__text"></span>
						</div>
					</div>

					<div class="input input_email">
						<input name="email" type="text" placeholder="Введите email" id="email">
						<img src="{{ url('/icons/input-mail.svg') }}">
						<div class="error__info"></div>
						<span class="error__text"></span>
					</div>

					<div class="input input_phone">
						<input name="phone" type="text" placeholder="Введите телефон" id="phone">
						<img src="{{ url('/icons/input-phone.svg') }}">
						<div class="error__info"></div>
						<span class="error__text"></span>
					</div>

					<label class="register__agreement">
						<input type="checkbox">
						<div class="error__info"></div>
						<span class="error__text">Необходимо принять условия</span>
					<p>Подвязав карту вы подтверждаете, что принимаете <a href="https://wingift.org/offer" target="_blank">«публичную оферту»</a> и <a href="https://wingift.org/terms" target="_blank">«условия использования и подписки»</a>, а также ознакомлены с тем, что через {{ $subscription_free_days }} дня тестового периода с Вас будет списана оплата в размере {{ $subscription_amount_rub }} руб. и будет списываться каждые {{ $subscription_days }} дней за использование нашего сервиса.</p>
				</label>
					<button class="button main-button large-button button-continue" type="button">Продолжить</button>
				</form>
				<div class="card second-step" style="display:none;">
					<!-- CARD CONTAINER START -->
					<div class="card__wrapper"></div>
					<!-- CARD CONTAINER END --> 
					<div class="card__form">
						<form id="form" action="" class="">


								<div class="input input__wrapper input__wrapper_name">

										<input type="hidden" data-cp="name">
										<input type="text" id="name" name="name" placeholder="Имя" class="form__input input-name" required>


										<img src="{{ url('/icons/input-user.svg') }}">
                                        <div class="error__info"></div>
										<span class="error__text"></span>
								</div>




								<div class="input input__wrapper input__wrapper_name">

										<input type="hidden" data-cp="lastname">
										<input type="text" id="lastname" name="lastname" placeholder="Фамилия" class="form__input input-name" required>

										<img src="{{ url('/icons/input-user.svg') }}">
                                        <div class="error__info"></div>
										<span class="error__text"></span>
								</div>



								<div class="input input__wrapper input__wrapper_cardNumber">
										<input type="hidden" data-cp="cardNumber">
										<input id="card-number" type="text" name="number" class="form__input" placeholder="Номер банковской карты">
										<img src="{{ url('/icons/input-card.svg') }}">
                                        <div class="error__info"></div>
										<span class="error__text"></span>
								</div>
							<div class="form-group">
								<div class="input input__wrapper input__wrapper_expDateMonth input__wrapper_expDateYear">
										<input type="hidden" data-cp="expDateMonth">
										<input type="hidden" data-cp="expDateYear">
										<input id="card-expiry" type="text" name="expiry" class="form__input" placeholder="ММ/ГГ">
										<img src="{{ url('/icons/input-calendar.svg') }}">
                                        <div class="error__info"></div>
										<span class="error__text"></span>
								</div>
								<div class="input input__wrapper input__wrapper_cvv">
										<input type="hidden" data-cp="cvv">
										<input id="card-cvc" type="text" name="cvc" class="form__input" placeholder="CVV">
										<img src="{{ url('/icons/input-cvv.svg') }}">
                                        <div class="error__info"></div>
										<span class="error__text"></span>
								</div>
							</div>
						</form>
						<button type="button" class="button main-button large-button button-submit">Оформить пробную версию</button>

					</div>
				</div>
				<div class="auth__alt">Уже зарегистрированы? <a href="https://wingift.org/login" target="_blank">Вход</a></div>
				<div class="register__info">
					<p style="opacity:0.7">Через 3 дня подписка продлится на 14 дней за 625р.</p>
					<p class="register__terms">
						Оплачивая подписку, я принимаю <a href="https://wingift.org/terms" target="_blank">условия оплаты и условия автоматического продления подписки на 14 дней вперед</a>
						<br>
						Отменить платное продление подписки можно в любой момент связавшись с поддержкой сервиса
						<br>
						Все платежи надежно защищены и соответствуют международным стандартам
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<form name="secure" id="secure" action="" method="POST">
	<input type="hidden" name="PaReq" value="">
	<input type="hidden" name="MD" value="">
	<input type="hidden" name="TermUrl" value="">
</form>

<form action="https://api.cloudpayments.ru/payments/cards/post3ds" id="post3ds" method="POST">
    <input type="hidden" name="PaRes" value="">
    <input type="hidden" name="TransactionId" value="">
</form>

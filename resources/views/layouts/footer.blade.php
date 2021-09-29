<footer>
	<div class="container footer">
		<div class="footer__main">
			<div class="footer__main_payments">
				<div class="footer__main_payments-title">Принимаем:</div>
				<div class="footer__main_payments-imgs">
					<img src="{{ url('/icons/p1.svg') }}">
					<img src="{{ url('/icons/p2.svg') }}">
					<img src="{{ url('/icons/p3.svg') }}">
					<img src="{{ url('/icons/p4.svg') }}">
					<img src="{{ url('/icons/p5.svg') }}">
				</div>
			</div>
			<div class="footer__main_contacts">
				<div class="footer__main_contacts-title">Служба поддержки:</div>

				<div class="footer__main_contacts-mail">
					<img src="{{ url('/icons/mail.svg') }}">
					help@wingifts.net
				</div>

				<div class="footer__main_contacts-phone">
					<img src="{{ url('/icons/input-phone2.svg') }}">
					+79675557213
				</div>
			</div>
			<div class="footer__main_info">
				<a class='space' href="/privacy">Политика конфиденциальности</a>
				<a href="/offer">Публичная оферта</a>
				<br/>
				<br/>
				<a class='space' href="/terms">Условия использования</a>
				<a href="/cancelsubscription">Отменить подписку</a>
				<div class="footer__main_info-rights">© Wingifts, 2021  |  Все права защищены</div>
			</div>
		</div>
		<div class="footer__logo">
			<img src="{{ url('/images/logo.svg') }}">
			<div>wingifts</div>
		</div>
		<div class="footer__sale">
			<div class="footer__sale_title">Остались вопросы?</div>
			<div class="footer__sale_desc">Задайте их нам прямо сейчас</div>
			<button class="button main-button js-popup" data-target="feedback" >Задать вопрос</button>
		</div>
	</div>
</footer>

<div class="popup__wrapper" id="leave">
	<div class="popup">
		<div class="popup__header">
			<img src="{{ url('/icons/close.svg') }}" onclick="closePopup()">
		</div>
		<div class="popup__image">
			<img src="{{ url('/images/popup-card.png') }}">
		</div>
		<div class="popup__title">Стой!</div>
		<div class="popup__desc">Хотите первыми узнавать об уникальных курсах и розыгрышах в рунете с максимальным профитом?</div>
		
		<div class="popup__content">
			<div class="popup__content_buttons">
			<a href="" class="button main-button large-button">Получить пробную версию </a>
			</div>
		</div>
	</div>
</div>

<div class="popup__wrapper" id="feedback">
	<div class="popup">
		<div class="popup__header">
			<img src="{{ url('/icons/close.svg') }}" onclick="closePopup()">
		</div>
		<div class="popup__title">Связаться с нами</div>
		<div class="popup__desc">Введите некоторую информацию, и наш менеджер свяжеться с вами в ближейшее время!</div>
		
		<div class="popup__content">
			<form method="post" action="{{ url('feedback/send') }}">
				@csrf
				<div class="input @if($errors->has('feedback_name')) error @endif">
					<input name="feedback_name" type="text" placeholder="Ваше имя" value="{{ old('feedback_name') }}">
					<img src="{{ url('/icons/input-user.svg') }}">
						<div class="error__info"></div>
						@error('feedback_name')
						<span class="error__text">{{ $message }}</span>
						@enderror
				</div>
				<div class="input @if($errors->has('feedback_phone')) error @endif">
					<input name="feedback_phone" type="text" placeholder="Телефон" value="{{ old('feedback_phone') }}">
					<img src="{{ url('/icons/input-phone.svg') }}">
						<div class="error__info"></div>
						@error('feedback_phone')
						<span class="error__text">{{ $message }}</span>
						@enderror
				</div>
				<div class="input @if($errors->has('feedback_email')) error @endif">
					<input name="feedback_email" type="text" placeholder="E-mail" value="{{ old('feedback_email') }}">
					<img src="{{ url('/icons/input-mail.svg') }}">
						<div class="error__info"></div>
						@error('feedback_email')
						<span class="error__text">{{ $message }}</span>
						@enderror
				</div>
				<div class="input">
					<textarea name="feedback_text" placeholder="Здесь может быть ваш комментарий...">{{ old('feedback_text') }}</textarea>
					<img src="{{ url('/icons/input-message.svg') }}">
						<div class="error__info"></div>
						<span class="error__text"></span>
				</div>
				
				<button class="button main-button large-button">Отправить</button>
			</form>
		</div>
	</div>
</div>


<div class="popup__wrapper" id="thanks">
	<div class="popup">
		<div class="popup__header">
			<img src="{{ url('/icons/close.svg') }}" onclick="closePopup()">
		</div>
		<div class="popup__title">Спасибо!</div>
		<div class="popup__desc">Подписка успешно оформлена.</div>
	</div>
</div>


<div class="popup__wrapper" id="thanks-feedback">
	<div class="popup">
		<div class="popup__header">
			<img src="{{ url('/icons/close.svg') }}" onclick="closePopup()">
		</div>
		<div class="popup__title">Спасибо!</div>
		<div class="popup__desc">Ваша заявка успешно отправлена. Мы свяжемся с Вами в ближайшее время.</div>
	</div>
</div>
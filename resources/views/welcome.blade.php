@extends('layouts.app')
@section('content')
<div class="banner-wrapper">
	<div class="container banner">
		<div class="banner__content">
			<div class="banner__content_title">wingifts</div>
			<div class="banner__content_desc">Получи по одной подписке информацию о всех актуальных розыгрышах рунета, а также доступ к базе знаний с 100+ курсами в SMM  и Digital направлении</div>
			<div class="banner__content_sup">Возможность ежедневно развиваться и следить за топовыми розыгрышами рунета
всего за <span class="red"><strong>625 рублей</strong></span> в 14 дней</div>
			@if(!$user)
				<a href="{{ route('register') }}" class="button main-button large-button">3 дня бесплатно</a>
			@elseif(!$user->hasRole('subscriber'))
				<a href="{{ route('account') }}" class="button main-button large-button">Оформить подписку</a>
			@endif
			<br>
			<div class="banner__count">
				<div class="banner__count-item">
					<div><span class="red">100+</span></div>
					<div>Обучающих курсов</div>
				</div>
				<div class="banner__count-spacer"></div>
				<div class="banner__count-item">
					<div><span class="red">1.000+</span></div>
					<div>Пользователей на платформе</div>
				</div>
			</div>
		</div>
		<div class="banner__image">
			<img src="{{ url('/images/top.png') }}">
		</div>
	</div>
</div>

@include('shared/drawpersons')

@include('shared/draws')

@include('shared/coursesmain')






<div class="about">
	<div class="container about__wrapper">
		<h2 class="title">Что такое <span class="red">wingifts?</span></h2>
		<div class="about__texts">
			<div class="about__item">
				<div class="about__item_icon">
					<img src="{{ url('/icons/what1.svg') }}">
				</div>
				<div class="about__item_title">
					Иметь доступ к топовой подборке развивающей информации
				</div>
				<div class="about__item_desc">
					Большинство  людей в 21 веке стремятся развивать свою карьеру онлайн и быть не  привязанными к одному месту работы. Мы отчетливо чувствуем, что из-за  переизбытка информации в интернете на различные темы, людям, которые  начинаются разбираться в той или иной теме, сложно фильтровать  информацию и определять какая еще актуальна, а какая уже устарела. Мы  попытались закрыть эту потребность и отобрали базу, на наш взгляд,  актуальной информации на различные темы в SMM и Digital  направлениях, которую регулярно пополняем.
				</div>
			</div>
			<div class="about__item">
				<div class="about__item_icon">
					<img src="{{ url('/icons/what2.svg') }}">
				</div>
				<div class="about__item_title">
					Возможность всегда быть в курсе топовых розыгрышей
				</div>
				<div class="about__item_desc">
					Ежедневно блогеры и различные медиа площадки устраивают розыгрыши для своих  подписчиков. У каждого есть огромное желание стать победителем и  выиграть что-либо в этих розыгрышах, но большенство желающих выиграть  даже не знают, что сейчас тот или иной розыгрыш проходит. Поэтому мы и  создали платформу, которая собирает информацию о практически всех  розыгрышах в Instagram и дает возможность каждому желающему быть в курсе  этого.
				</div>
			</div>
			<div class="about__item">
				<div class="about__item_icon">
					<img src="{{ url('/icons/what3.svg') }}">
				</div>
				<div class="about__item_title">
					Не быть подписанным на сотни блогеров/меди-личностей
				</div>
				<div class="about__item_desc">
					Большинство  людей подписывается на сотни, а то и тысячи блогеров / меди-личностей,  чтобы следить за ними и в случае анонса какого-то розыгрыша быть в курсе  и участвовать в нем, но это крайне не удобно, потому что тогда контент  людей, которые по-настоящему интересен, просто теряется и у человека  пропадает удовольствие от пользования социальной сетью. С помощью нашей  платформы ему не нужно быть на всех подписанным, а нужно просто следить  за обновлением информации в его личном кабинете, где он видит кто и  когда проводит розыгрыш.
				</div>
			</div>
			<div class="about__item">
				<div class="about__item_icon">
					<img src="{{ url('/icons/what4.svg') }}">
				</div>
				<div class="about__item_title">
					Система проверенная временем
				</div>
				<div class="about__item_desc">
					Наш сервис разработан и поддерживается топовыми IT-специалистами, поэтому мы предоставляем  стабильный и совершенный сервис, который регулярно пополняется новой  информацией, который не будет лагать и зависать, а будет выполнять свою  задачу по предоставлению информации пользователю на 100%.
				</div>
			</div>
			<div style="clear:both"></div>
		</div>
		@if(!$user)
		<div class="free">
			<div class="free__texts">
				<div class="free__title">Получите 3 дня <br>пробной версии <span class="red">бесплатно!</span></div>
				<div class="free__desc">Для этого заполните короткую форму для идентификации вашей личностио</div>
			</div>
			<a href="{{ route('register') }}" class="button main-button large-button">Получить пробную версию </a>
			<div class="free__decor">
				<img src="{{ url('/images/gift.svg') }}" class="decor-1">
				<img src="{{ url('/images/gift.svg') }}" class="decor-2">
				<img src="{{ url('/images/gift.svg') }}" class="decor-3">
			</div>
		</div>
		@endif
	</div>
</div>

<div class="container review" id="reviews">
	<h2 class="title">Отзывы</h2>
	<div class="review__wrapper">
		<div class="review__item" v-for="(item, key) in reviews.data" :class="{active: key === activeSlide }">
			<img :src="item.image" v-if="item.image">
			<div class="review__item_name">
				@{{ item.name }}
			</div>
			<div class="review__item_text">@{{ item.content }}</div>
		</div>

		<div style="clear:both"></div>
	</div>
	<div class="review__nav" v-if="reviewTabs">
		<div class="review__nav_item" v-for="item in reviewTabs" :class="{active: reviews_tab === item}" @click="reviews_tab = item"></div>
	</div>
</div>
@endsection
@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/welcome.css?v=1.1">
@endpush
@push('scripts')
	<script type="text/javascript" src="{{ asset('js/manifest.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/index/index.js') }}"></script>
@endpush

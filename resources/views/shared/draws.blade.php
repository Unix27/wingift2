<div class="container raffles" id="draws">
	<h2 class="title">Розыгрыши от компаний</h2>
	<div class="raffles__wrapper">
		<template v-for="item in draws.data">
		<div class="raffles__item locked" v-if="!logged && !item.is_free">
				<img src="{{ url('/icons/lock.svg') }}">
				<div class="raffles__item_details">
					<div class="raffles__item_desc">
						Для получения доступа вам необходимо оформить 3 дневную бесплатную подписку
					</div>
				</div>
				<div class="raffles__item_actions">
					<a href="{{ route('register') }}" class="button main-button small-button">Попробовать бесплатно</a>
				</div>
		</div>
		<div class="raffles__item locked" v-else-if="!subscribed && !item.is_free">
				<img src="{{ url('/icons/lock.svg') }}">
				<div class="raffles__item_details">
					<div class="raffles__item_desc">
						Для получения доступа вам необходимо возобновить подписку
					</div>
				</div>
				<div class="raffles__item_actions">
					<a href="{{ route('account') }}" class="button main-button small-button">Перейти в аккаунт</a>
				</div>
		</div>
		<div class="raffles__item" v-else>
			<a v-bind:href="'/draws/' + item.slug "><img :src="item.image" v-if="item.image"></a>

			<div class="raffles__item_details">
				<div class="raffles__item_name">
					<span>@{{ item.title }}</span>
				</div>
				<div class="raffles__item_date">
					<img src="{{ url('/icons/calendar.svg') }}">
					до @{{ item.end_date }}
				</div>
			</div>
			<div class="raffles__item_actions">
				<div class="raffles__item_price">@{{ item.prize }} ₽</div>
				<a v-bind:href="'/draws/' + item.slug " class="button main-button small-button" v-if="item.link">Подробнее</a>
			</div>
		</div>
		</template>
		<div class="gradient" v-if="!subscribed && draws.meta.current_page !== draws.meta.last_page"></div>
		<div style="clear:both"></div>
	</div>
	<div class="loadmore__wrapper">
		<div class="loadmore" v-if="draws.meta.current_page !== draws.meta.last_page" @click="loadmoreDraws"><img src="{{ url('/icons/reload.svg') }}"> Показать еще...</div>
	</div>
</div>

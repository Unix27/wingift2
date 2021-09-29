<div class="courses-page" >
	<div class="container">
		<h1 class="page-title">Все обучающие курсы</h1>
		<div class="flexer">
			<div class="categories">
				<ul>
					<li onclick="this.classList.toggle('opened')">
						<a href="{{ url('courses') }}" class="button main-button large-button" :class="{active: category === null}" @click.prevent="category = null">Все направления <img src="{{ url('/icons/down.svg') }}"></a>
					</li>
					<li v-for="item in categories" v-cloak>
						<a :href='item.link' class="button category-button large-button" :class="{active: category && category.id === item.id}" @click.prevent="category = item">@{{ item.title }}</a>
					</li>
				</ul>
			</div>
			<div class="courses">
				<div class="courses__wrapper">

					<course v-for="(item, key) in courses.data" :data-item="item" :key="key"></course>

					<div style="clear:both"></div>
				</div>
				<div class="loadmore__wrapper">
					<div class="loadmore" v-if="courses.meta.current_page !== courses.meta.last_page" @click="loadmore" v-cloak><img src="{{ url('/icons/reload.svg') }}"> Показать еще...</div>
				</div>
			</div>
		</div>
	</div>
</div>

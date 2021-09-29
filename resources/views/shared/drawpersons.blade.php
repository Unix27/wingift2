<div class="container rafflepersons" id="drawpersons">
    <h2 class="title">Розыгрыши от блогеров</h2>
    <div class="rafflepersons__wrapper">
        <template v-for="item in drawpersons.data">
            <div class="rafflepersons__item">
                <a v-bind:href="'/draws/' + item.slug "><img :src="item.image" v-if="item.image"></a>
                <div class="rafflepersons__item_details">
                    <div class="rafflepersons__item_name">
                        <span>@{{ item.title }}</span>
                    </div>
                    <div class="rafflepersons__item_date">
                        <img src="{{ url('/icons/calendar.svg') }}">
                        до @{{ item.end_date }}
                    </div>
                </div>
                <div class="rafflepersons__item_actions">
                    <div class="rafflepersons__item_price">@{{ item.prize }} ₽</div>
                    <a v-bind:href="'/draws/' + item.slug " class="button main-button small-button" v-if="item.link">Подробнее</a>
                </div>
            </div>
        </template>
        <div class="gradient" v-if="!subscribed && drawpersons.meta.current_page !== drawpersons.meta.last_page"></div>
        <div style="clear:both"></div>
    </div>
    <div class="loadmore__wrapper">
        <div class="loadmore" v-if="drawpersons.meta.current_page !== drawpersons.meta.last_page" @click="loadmoreDrawPersons"><img src="{{ url('/icons/reload.svg') }}"> Показать еще...</div>
    </div>
</div>

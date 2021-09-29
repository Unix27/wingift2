<div class="container courses">
    <h2 class="title">Другие курсы</h2>
    <div class="courses__wrapper">
        <course v-for="(item, key) in courses.data" :data-item="item" :key="key"></course>
        <div style="clear:both"></div>
    </div>
    <div class="loadmore__wrapper">
        <div class="loadmore" v-if="courses.meta.current_page !== courses.meta.last_page" @click="loadmoreCourses"><img src="{{ url('/icons/reload.svg') }}"> Показать еще...</div>
    </div>
</div>

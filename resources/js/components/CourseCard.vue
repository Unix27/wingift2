<template>
  <a :href="link" class="courses__item" :class="{locked: locked}">
    <div class="courses__item_theme">{{ item.category_title }}</div>
    <div class="courses__item_title">{{ item.title }}</div>
    <div class="courses__item_rating"><img v-bind:src="'/images/' + item.rating + '-star.png'" ></div>
    <div class="courses__item_desc">{{ item.excerpt }}</div>
    <div class="courses__lock" v-if="!$parent.logged && !item.is_free">
      <img src="/icons/lock.svg">
      <div class="courses__lock_desc">Для получения доступа вам необходимо оформить 3 дневную бесплатную подписку</div>
      <a href="/register" class="button secondary-button small-button">Попробовать бесплатно</a>
    </div>
    <div class="courses__lock" v-if="$parent.logged && !$parent.subscribed && !item.is_free">
      <img src="/icons/lock.svg">
      <div class="courses__lock_desc">Для получения доступа вам необходимо возобновить подписку</div>
      <a href="/account" class="button secondary-button small-button">Перейти в аккаунт</a>
    </div>
  </a>
</template>

<script>
  export default {
    name: "course",
    data() {
      return {
        item: this.dataItem
      }
    },
    computed: {
      locked: function() {
        return (!this.$parent.logged || !this.$parent.subscribed) && !this.item.is_free;
      },
      link: function() {
        if(!this.$parent.logged && !this.item.is_free)
          return '/register';
        else if(!this.$parent.subscribed && !this.item.is_free)
          return '/account';

        return this.item.link;
      }
    },
    props: ['dataItem'],
    watch: {
      dataItem: function(value) {
        this.item = value;
      }
    },
  }
</script>

require('../bootstrap');

import course from '../components/CourseCard.vue'

const app = new Vue({
  el: '#app',
  data: {
    courses: {
      data: [],
      meta: {
        current_page: 1,
        last_page: 1
      }
    },
    draws: {
      data: [],
      meta: {
        current_page: 1,
        last_page: 1
      }
    },
    drawpersons: {
      data: [],
      meta: {
          current_page: 1,
          last_page: 1
      }
    },
    reviews: {
      data: [],
      meta: {
        current_page: 1,
        last_page: 1,
        total: 0
      }
    },
    subscribed: subscribed,
    logged: logged,
    reviews_tab: 1,
    reviews_per_tab: 4,
  },
  computed: {
    reviewTabs() {
      return Math.ceil(this.reviews.meta.total / this.reviews_per_tab);
    },
    activeSlide() {
      return (this.reviews_tab - 1) * this.reviews_per_tab;
    }
  },
  components: {
    course: course
  },
  methods: {
    getCourses(page, free = false) {
      axios.post('/api/courses/paginate/6', {page: page, free: free}).then((response) => {

        if(page > 1){
          let currentData = this.courses.data;
          this.courses = response.data;

          currentData.reverse().forEach(item => {
            this.courses.data.unshift(item);
          });
      } else
        this.courses = response.data;
      });
    },
    getDraws(page, free = false) {
      axios.post('/api/draws/paginate/6', {page: page, free: free}).then((response) => {

        if(page > 1){
          let currentData = this.draws.data;
          this.draws = response.data;

          currentData.reverse().forEach(item => {
            this.draws.data.unshift(item);
          });
      } else
        this.draws = response.data;
      });
    },
      getDrawPersons(page, free = false) {
          axios.post('/api/drawpersons/paginate/6', {page: page, free: free}).then((response) => {

              if(page > 1){
                  let currentData = this.drawpersons.data;
                  this.drawpersons = response.data;

                  currentData.reverse().forEach(item => {
                      this.drawpersons.data.unshift(item);
                  });
              } else
                  this.drawpersons = response.data;
          });
      },
    getReviews() {
      axios.post('/api/reviews/paginate/8').then((response) => {
        this.reviews = response.data;
      });
    },
    loadmoreCourses() {
      if(!this.subscribed || !this.logged)
        this.getCourses(this.courses.meta.current_page + 1, true);
      else
        this.getCourses(this.courses.meta.current_page + 1);
    },
    loadmoreDraws() {
      if(!this.subscribed || !this.logged)
        this.getDraws(this.draws.meta.current_page + 1, true);
      else
        this.getDraws(this.draws.meta.current_page + 1);
    },
      loadmoreDrawPersons() {
          if(!this.subscribed || !this.logged)
              this.getDrawPersons(this.drawpersons.meta.current_page + 1, true);
          else
              this.getDrawPersons(this.drawpersons.meta.current_page + 1);
      }
  },
  created: function(){
    if(window.innerWidth <= 533)
      this.reviews_per_tab = 1;
    else if(window.innerWidth <= 769)
      this.reviews_per_tab = 2;

    if(!this.subscribed){
      this.getCourses(1, true);
      this.getDraws(1, true);
      this.getDrawPersons(1, true);
    } else {
      this.getCourses(1);
      this.getDraws(1);
      this.getDrawPersons(1);
    }

    this.getReviews();
  }
});

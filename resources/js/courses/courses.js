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
    categories: categories,
    category: category,
    subscribed: subscribed,
    logged: logged
  },
  components: {
    course: course
  },
  methods: {
    getCourses(page = 1, free = false) {
      let category_id = this.category? this.category.id : null;

      axios.post('/api/courses/paginate/6', {page: page, category_id: category_id, free: free}).then((response) => {
        
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
    loadmore() {
      if(this.subscribed)
        this.getCourses(this.courses.meta.current_page + 1);
      else
        this.getCourses(this.courses.meta.current_page + 1, true);
    }
  },
  watch: {
    category: {
      handler: function() {
        let newUrl = location.protocol + '//' + location.host;

        if(this.subscribed)
		newUrl += '/account';

	newUrl += '/courses';

        if(this.category)
          newUrl += '/' + this.category.slug;

        history.pushState({
            id: 'analitics'
        }, 'analitics', newUrl);

        console.log(this.subscribed);
        if(this.subscribed)
          this.getCourses(1);
        else
          this.getCourses(1, true);
      },
      deep: true
    }
  },
  created() {
    console.log('created');
    if(this.subscribed)
      this.getCourses(1);
    else
      this.getCourses(1, true);
  }
});
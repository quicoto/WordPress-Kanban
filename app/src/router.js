import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const router = new Router({
  linkActiveClass: 'get mabn',
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('./views/Boards.vue'),
      meta: {
        title: 'All boards',
      },
    },
    {
      path: '/board/:board_id',
      name: 'board',
      component: () => import('./views/Boards.vue'),
      meta: {
        title: '%board%',
      }
    },
    {
      path: '/not-logged-in',
      name: 'notLoggedIn',
      component: () => import('./views/NotLoggedIn.vue'),
      meta: {
        title: 'Not Logged In',
      },
    },
  ],
});

router.afterEach((to) => {
  const metaTitle = `${to.meta.title} | Kanban`;

  document.title = metaTitle;
});

export default router;

import {RouteConfig} from 'vue-router'
import {LocalStorage} from 'quasar';

const routes: RouteConfig[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '', component: () => import('pages/Index.vue'),
        beforeEnter: ((to, from, next) => {
          if (!LocalStorage.has('access_token')) {
            next('/login')
          }else{
            next()
          }
        })
      },
      {
        path: 'projects/:projectID', component: () => import('pages/Project.vue'),
        beforeEnter: ((to, from, next) => {
          if (!LocalStorage.has('access_token')) {
            next('/login')
          }else{
            next()
          }
        })
      },
      {path: '/login', component: () => import('pages/Login.vue'),
        beforeEnter: ((to, from, next) => {
          if (LocalStorage.has('access_token')) {
            next('/')
          }else{
            next()
          }
        })
      },
      {path: '/register', component: () => import('pages/Register.vue'),
        beforeEnter: ((to, from, next) => {
          if (LocalStorage.has('access_token')) {
            next('/')
          }else{
            next()
          }
        })
      },
      // {
      //   path: '/profile/:profile', component: () => import('pages/Profile.vue'),
      //   beforeEnter: ((to, from, next) => {
      //     if (!LocalStorage.has('access_token')) {
      //       next('/login')
      //     }else{
      //       next()
      //     }
      //   })
      // },
      {
        path: '/profile', component: () => import('pages/MyProfile.vue'),
        beforeEnter: ((to, from, next) => {
          if (!LocalStorage.has('access_token')) {
            next('/login')
          }else{
            next()
          }
        })
      },
      {
        path: '/logout', component: () => import('pages/Logout.vue'),
        beforeEnter: ((to, from, next) => {
          if (!LocalStorage.has('access_token')) {
            next('/login')
          }else{
            next()
          }
        })
      }],
  }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes

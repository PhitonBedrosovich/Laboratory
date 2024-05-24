import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/foods',
    name: 'Foods',
    component: () => import('@/views/FoodsPage')
  },
  {
    path: '/menu',
    name: 'Menu',
    component: () => import('@/views/MenuPage'),
  },
  {
    path: '/foods-edit/:id?',
    name: 'FoodsEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/FoodsEdit'),
  },
  {
    path: '/menu-edit/:id?',
    name: 'MenuEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/MenuEdit'),
  },
  {
    path: '/:catchAll(.*)',
    name: 'NotFound',
    component: () => import('@/views/FoodsPage'),
  },
  {
    path: '/foods-menu',
    name: 'FoodsMenu',
    props: (route) =>{
      return{
        id: route.params.id,
      }
    },
    component: () => import('@/views/FoodsMenuPage')
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
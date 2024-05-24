import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/dishes',
    name: 'Dishes',
    component: () => import('@/views/DishesPage')
  },
  {
    path: '/menus',
    name: 'Menus',
    component: () => import('@/views/MenusPage'),
  },
  {
    path: '/dish-edit/:id?',
    name: 'DishEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/DishEdit'),
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
    component: () => import('@/views/DishesPage'),
  },
  {
    path: '/dishes-on-the-menus',
    name: 'DishesOnTheMenus',
    component: () => import('@/views/DishesOnTheMenusPage')
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router

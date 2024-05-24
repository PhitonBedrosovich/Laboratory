import { createStore } from 'vuex'
import dishes from './dishes';
import menus from './menus';
export default createStore({
  modules: {
    dishes,
    menus,
  },
  state: {},
  mutations: {},
  actions: {},
})

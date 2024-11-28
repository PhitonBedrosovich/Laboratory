import api from './api';

export default {
  namespaced: true,
  state: {
    items: [],
  },
  getters: {
    items: state => state.items,
    itemsByKey: state => state.items.reduce((res, cur) => {
      res[cur['id']] = cur;
      return res;
    }, {}),
  },
  mutations: {
    setItems: (state, items) => {
      state.items = items;
    },
    addItem: (state, item) => {
      state.items.push(item);
    },
    removeItem: (state, idRemove) => {
      state.items = state.items.filter(({ id }) => id !== idRemove);
    },
    updateItem: (state, updateItem) => {
      const index = state.items.findIndex(item => +item.id === +updateItem.id);
      state.items[index] = updateItem;
    }
  },
  actions: {
    fetchMenus: async ({ commit }) => {
      try {
        const response = await api.menus();
      const items = await response.json();
      commit('setItems', items);}
      catch (error) {
        console.error('Error fetching groups:', error);
      }
    },
    removeItem: async ({ commit }, id) => {
      try {
        await api.remove(id);
        commit('removeItem', id);
      } catch (error) {
        console.error('Error removing menus:', error);
      }
    },
    addItem: async ({ commit }, { name}) => {
      try {
        const item = await api.add({ name });
        commit('addItem', item);
      } catch (error) {
        console.error('Error adding menus:', error);

      }
    },
    updateItem: async ({ commit }, { id, name}) => {
      try {const item = await api.update({ id, name});
      commit('updateItem', item);
      } catch (error) {
        console.error('Error updating group:', error);
      }
    }
  },
}
}//добавил скобку

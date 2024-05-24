import api from './api';

export default {
  namespaced: true,
  state: {
    items: [],
    itemsBydishID: []
  },
  getters: {
    items: state => state.items,
    itemsByKey: state => state.items.reduce((res, cur) => {
      res[cur['id']] = cur;
      return res;
    }, {}),
  },
  mutations: {
    setItemsBydishID: (state, items) => {
      state.itemsBydishID = items;
    },

    setItems: (state, items) => {
      state.items = items;
    },
    setItem: (state, item) => {
      state.items.push(item);
    },
    removeItem: (state, idRemove) => {
      state.items = state.items.filter(({ id }) => id !== idRemove)
    },
    updateItem: (state, updateItem) => {
      const index = state.items.findIndex(item => +item.id === +updateItem.id);
      state.items[index] = updateItem;
    },

    itemsByID: (state, idItem) =>{
      state.items = state.items.filter(({ id_dishes }) => id_dishes !== idItem);
    }
  },
  actions: {
    fetchItems: async ({ commit }) => {
      try {
        const response = await api.foods();
        const items = await response.json();
        commit('setItems', items);
      } catch (error) {
        console.error('Error fetching foods:', error);
      }
    },
    removeItem: async ({ commit }, id) => {
      const idRemovedItem = await api.remove( id );
      commit('removeItem', idRemovedItem);

    },
    fetchItemsBydishID: async ({ commit }, dishID) => {
      try {
        const items = await api.foodId(dishID);
        commit('setItemsBydishID', items);
      } catch (error) {
        console.error('Error fetching items by dish ID:', error);
      }
    },
    addItem: async ({ commit }, { id, img_path, name, description, weight, id_dishes}) => {
      const item = await api.add({ id, img_path, name, description, weight, id_dishes })
      commit('setItem', item)
    },
    updateItem: async ({ commit }, { id, img_path, name, description, weight, id_dishes }) => {
      const item = await api.update({ id, img_path, name, description, weight, id_dishes });
      commit('updateItem', item);
    }
  },
}

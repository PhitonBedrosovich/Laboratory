import axios from 'axios';
export const fetchMenus = async (store) => {
  try {
    // Отправляем GET-запрос на правильный URL
    const response = await axios.get('http://localhost/crud_rest/rest/menus/list.json');

    // Если запрос успешен, передаем полученные данные в хранилище через мутацию
    store.commit('menus/setItems', response.data);
  } catch (error) {
    // Если произошла ошибка, выводим ее в консоль
    console.error('Error fetching items:', error);
  }
};
export const selectItems = ( store ) => {
  const { getters } = store;
  return getters['menus/items']
}

export const removeItem = ( store, id ) => {
  const { dispatch } = store;
  dispatch('menus/removeItem', id);
}

export const addItem = ( store, { name } ) => {
  const { dispatch } = store;
  dispatch('menus/addItem', { name });
}

export const updateItem = ( store, { id, name } ) => {
  const { dispatch } = store;
  dispatch('menus/updateItem', { id, name });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['menus/itemsByKey'][id] || {};
}

import axios from 'axios';

export const fetchItems = async (store) => {
  try {
    // Отправляем GET-запрос на правильный URL
    const response = await axios.get('http://localhost/crud_rest/rest/foods/list.json');

    // Если запрос успешен, передаем полученные данные в хранилище через мутацию
    store.commit('foods/setItems', response.data);
  } catch (error) {
    // Если произошла ошибка, выводим ее в консоль
    console.error('Error fetching items:', error);
  }
};


export const selectItems = (store) => {
  const { getters } = store;
  return getters['foods/items']
}

export const removeItem = (store, id) => {
  const { dispatch } = store;
  dispatch('foods/removeItem', id);
}

export const addItem = (store, {img_path, name, description, weight, id_dishes }) => {
  const { dispatch } = store;
  dispatch('foods/addItem', { img_path, name, description, weight, id_dishes });
}

export const updateItem = (store, { id, img_path, name, description, weight, id_dishes }) => {
  const { dispatch } = store;
  dispatch('foods/updateItem', { id, img_path, name, description, weight, id_dishes });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['foods/itemsByKey'][id] || {};
}


export const selectItemsBydishID = async (store, dishID) => {
  try {
    const response = await axios.get(`http://localhost/crud_rest/rest/foods/SelectByID?id_dishes=${dishID}`);
    return response.data; // Возвращаем данные без коммита изменений в store
  } catch (error) {
    console.error('Error fetching items:', error);
    return []; // Возвращаем пустой массив в случае ошибки
  }
};

export const fetchItemsBydishID = async (store, dishID) => {
  try {
    const items  = await selectItemsBydishID(store, dishID);
    store.commit('foods/setItemsBydishID', items);
  } catch (error) {
    console.error('Error fetching items by dish ID:', error);
  }
};

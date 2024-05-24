export const fetchItems = ( store ) => {
  const { dispatch } = store;
  dispatch('menus/fetchItems');
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

export const updateItem = ( store, { id, name }) => {
  const { dispatch } = store;
  dispatch('menus/updateItem', { id, name });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['menus/itemsByKey'][id] || {};
}
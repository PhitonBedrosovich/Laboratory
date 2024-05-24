export const fetchItems = (store) => {
  const { dispatch } = store;
  dispatch('dishes/fetchItems');
};

export const selectItems = (store) => {
  const { getters } = store;
  return getters['dishes/items']
}

export const removeItem = (store, id) => {
  const { dispatch } = store;
  dispatch('dishes/removeItem', id);
}

export const addItem = (store, { img_path, name, id_dishes, description, weight }) => {
  const { dispatch } = store;
  dispatch('dishes/addItem', { img_path, name, id_dishes, description, weight });
}

export const updateItem = (store, { id, img_path, name, id_dishes, description, weight }) => {
  const { dispatch } = store;
  dispatch('dishes/updateItem', { id, img_path, name, id_dishes, description, weight });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['dishes/itemsByKey'][id] || {};
}

export const selectItemsByMenuId = (store, menuId) => {
  const { getters } = store;
  const allDishes = getters['dishes/items'] || [];
  return allDishes.filter(dish => dish.id_dishes === menuId);
}
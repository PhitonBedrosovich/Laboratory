<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <DishForm @submit="onSubmit" :id="id"  />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateItem, addItem } from '@/store/dishes/selectors';
import DishForm from '@/components/DishForm/DishForm.vue';
import Layout from '@/components/Layout/Layout';

export default {
  name: 'DishEdit',
  props: {
    id: String,
  },
  components: {
    Layout,
    DishForm,
  },
  setup() {
    const store = useStore();
    return {
      onSubmit: ({ id, img_path, name, id_dishes, description, weight }) => id ?
          updateItem(store, { id, img_path, name, id_dishes, description, weight }) :
          addItem(store, { img_path, name, id_dishes, description, weight } )
    }
  }

}
</script>


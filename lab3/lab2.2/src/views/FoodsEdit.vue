<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <FoodsForm @submit="onSubmit" :id="id"  />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateItem, addItem } from '@/store/foods/selectors';
import FoodsForm from '@/components/FoodsForm/FoodsForm.vue';
import Layout from '@/components/Layout/Layout';

export default {
  name: 'FoodsEdit',
  props: {
    id: String,
  },
  components: {
    Layout,
    FoodsForm,
  },
  setup() {
    const store = useStore();
    return {
      onSubmit: ({ id, img_path ,name, description , weight , id_dishes}) => id ?
          updateItem(store, { id, img_path , name, description , weight , id_dishes}) :
          addItem(store, { img_path , name, description , weight , id_dishes} )
    }
  }

}
</script>


<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <MenuForm
        :id="id"
        @submit="onSubmit"
    />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateItem, addItem } from '@/store/menus/selectors';
import Layout from '@/components/Layout/Layout';
import MenuForm from '@/components/MenuForm/MenuForm';

export default {
  name: 'MenuEdit',
  props: {
    id: String,
  },
  components: {
    MenuForm,
    Layout
  },
  setup() {
    const store = useStore();
    return {
      onSubmit: ({ id , name }) => id ?
          updateItem(store, { id, name } ) :
          addItem(store, { name } ),
    };
  }
}
</script>


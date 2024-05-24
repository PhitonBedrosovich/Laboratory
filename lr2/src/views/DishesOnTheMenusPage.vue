<template>
  <div :class="$style.root">
    <Table
        :headers="[
          {value: 'id', text: 'ID'},
          {value: 'img_path', text: 'Изображение'},
          {value: 'name', text: 'Название'},
          {value: 'id_dishes', text: 'Номер блюда'},
          {value: 'description', text: 'Описание'},
          {value: 'weight', text: 'Вес'},
          {value: 'control', text: 'Действие'},
        ]"
        :items="items"
    >
      <template v-slot:img_path="{ item }">
        <img :src="require(`@/assets/${item.img_path}`)" alt="Изображение" width="100px" height="100px"/>
      </template>
      <template v-slot:control="{ item }">
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
      </template>
    </Table>
    <router-link :to="{ name: 'DishEdit' }">
      <Btn :class="$style.create" theme="info">Создать</Btn>
    </router-link>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

import {selectItemsByMenuId, removeItem, fetchItems } from '@/store/dishes/selectors';
import  {selectItemById } from '@/store/menus/selectors';
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';

export default {
  name: 'DishesOnTheMenusPage',
  components: {
    Table,
    Btn,
  },
  setup() {
    const store = useStore();
    const router = useRouter();

    onMounted(() => {
      fetchItems(store);
    });

    const menuId = router.currentRoute.value.query.menuId;
    const items = computed(() => {
      const dishes = selectItemsByMenuId(store, menuId);
      return dishes.map(dish => {
        const menu = selectItemById(store, dish.id_dishes);
        return { ...dish, id_dishes: menu ? menu.name : '' };
      });
    });

    const onClickRemove = id => {
      const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
      if (isConfirmRemove) {
        removeItem(store, id)
      }
    };

    const onClickEdit = id => {
      router.push({ name: 'DishEdit', params: { id } })
    };

    return {
      items,
      onClickRemove,
      onClickEdit,
    };
  },
}
</script>

<style module lang="scss">
.root {
  .create {
    margin-top: 16px;
  }
}
</style>
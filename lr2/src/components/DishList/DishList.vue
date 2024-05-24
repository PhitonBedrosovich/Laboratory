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
      <template v-slot:control="{ item }">
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
      </template>

      <template v-slot:img_path="{ item }">
        <img :src="require(`@/assets/${item.img_path}`)" alt="Изображение" width="100px" height="100px"/>
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

import { selectItems, removeItem, fetchItems } from '@/store/dishes/selectors';
import { selectItemById, fetchItems as fetchMenus } from '@/store/menus/selectors';
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';

export default {
  name: 'DishList',
  components: {
    Table,
    Btn,
  },
  setup() {
    const store = useStore();
    const router = useRouter();
    onMounted(() => {
      fetchItems(store);
      fetchMenus(store);
    });
    return {
      items: computed(() => {
        return selectItems(store).map(item => ({
          ...item,
          id_dishes: selectItemById(store, item.id_dishes).name
        }));
      }),
      onClickRemove: id => {
        const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
        if (isConfirmRemove) {
          removeItem(store, id)
        }
      },
      onClickEdit: id => {
        router.push({ name: 'DishEdit', params: { id } })
      },
      getImgUrl: imgPath => {
        return require( '@/assets/' + imgPath.slice(7));
      }
    }
  }

}
</script>

<style module lang="scss">
.root {

  .create {
    margin-top: 16px;
  }

}
</style>

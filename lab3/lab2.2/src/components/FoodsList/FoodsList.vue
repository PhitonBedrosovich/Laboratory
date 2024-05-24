<template>
  <div :class="$style.root">
    <Table
        :headers="[
        {value: 'id', text: 'ID'},
        {value: 'name', text: 'Название'},
        {value: 'img_path', text: 'Фотография'},
        {value: 'description', text: 'Описание'},
        {value: 'weight', text: 'Вес'},
        {value: 'id_dishes', text: 'Меню'},
        {value: 'control', text: 'Действие'},
      ]"
        :items="items"
    >
      <template v-slot:control="{ item }">
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
      </template>

      <template v-slot:img_path="{ item }">
        <img :src="require(`C:/xampp/htdocs/lab2.2/src/assets/img/${item.img_path}`)" alt="Изображение" style="max-width: 200px;" />
      </template>
      <template>

        </template>
    </Table>

    <router-link :to="{ name: 'FoodsEdit' }">
      <Btn :class="$style.create" theme="info">Создать</Btn>
    </router-link>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';


import { selectItems, removeItem, fetchItems } from '@/store/foods/selectors';
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';
import {fetchMenus,selectItemById} from '@/store/menus/selectors';
export default {
  name: 'FoodsList',
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
        const isConfirmRemove = confirm('Вы действительно хотите удалить запись?');
        if (isConfirmRemove) {
          removeItem(store, id);
        }
      },
      onClickEdit: id => {
        router.push({ name: 'FoodsEdit', params: { id } });
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


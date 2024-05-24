<template>
  <div :class="$style.root">
    <Table
        :headers="[
          {value: 'id', text: 'ID'},
          {value: 'name', text: 'Меню'},
          {value: 'control', text: 'Действие'},
        ]"
        :items="items"
    >
      <template v-slot:control="{ item }">
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
        <Btn @click="onClickFilter(item.id)" theme="info">Фильтр</Btn>
      </template>
      <template v-slot:img_path="{ item }">
        <img :src="require(`@/assets/${item.img_path}`)" alt="Изображение" width="100px" height="100px"/>
      </template>
    </Table>
    <RouterLink :to="{ name: 'MenuEdit' }">
      <Btn :class="$style.create" theme="info">Создать</Btn>
    </RouterLink>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

import { selectItems, removeItem, fetchItems  } from '@/store/menus/selectors'
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';
export default {
  name: 'MenuList',
  components: {
    Btn,
    Table,
  },
  setup() {
    const store = useStore();
    const router = useRouter();
    onMounted(() => {
      fetchItems(store);
    });
    return {
      items: computed(() => selectItems(store)),
      onClickRemove: id => {
        const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
        if (isConfirmRemove) {
          removeItem(store, id)
        }
      },
        onClickFilter: id => {
          router.push({ name: 'DishesOnTheMenus', query: { menuId: id } })

      },
      onClickEdit: ( id ) => {
        router.push({ name: 'MenuEdit', params: { id } })
      }
    }
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

<template>
  <div :class="$style.root">
    <Table
        :headers="[
        {value: 'id', text: 'ID'},
        {value: 'name', text: 'Название'},
        {value: 'img_path', text: 'Картинка'},
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
        <img :src="require(`@/assets/img/${item.img_path}`)" alt="Изображение" style="max-width: 200px;" />
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
import { removeItem,fetchItemsBydishID } from '@/store/foods/selectors';
import  { fetchMenus } from '@/store/menus/selectors';
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';

export default {
  name: 'FoodsMenuPage',
  components: {
    Table,
    Btn,
  },
  setup() {
    const store = useStore();
    const router = useRouter();
    onMounted(() => {
      const dishID = router.currentRoute.value.query.dishID;
      fetchMenus(store);
      fetchItemsBydishID(store, dishID);
    });

    const items = computed(() => store.state.foods.itemsBydishID);
    // Удаление блюда
    const onClickRemove = id => {
      const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
      if (isConfirmRemove) {
        removeItem(store, id)
      }
    };

    // Редактирование блюда
    const onClickEdit = id => {
      router.push({ name: 'FoodsEdit', params: { id } })
    };

    return {
      items,
      onClickRemove,
      onClickEdit
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


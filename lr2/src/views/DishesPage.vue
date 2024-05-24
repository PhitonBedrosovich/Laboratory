<template>
  <Layout title="Блюда">
    <DishList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';
import DishList from '@/components/DishList/DishList.vue';

export default {
  name: 'Dishes',
  components: {
    Layout,
    DishList,
  }
}
</script>

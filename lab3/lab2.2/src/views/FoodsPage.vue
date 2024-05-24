<template>
  <Layout title="Блюда">
    <FoodsList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';
import FoodsList from '@/components/FoodsList/FoodsList';


export default {
  name: 'Foods',
  components: {
    Layout,
    FoodsList,
  }
}
</script>

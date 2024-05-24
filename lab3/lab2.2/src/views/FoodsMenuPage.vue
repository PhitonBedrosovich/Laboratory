<template>
  <Layout title="Блюда">
    <FoodsMenuList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';

import FoodsMenuList from "../components/FoodsMenuList/FoodsMenuList.vue";


export default {
  name: 'Foods',
  components: {
    Layout,
    FoodsMenuList,
  }
}
</script>



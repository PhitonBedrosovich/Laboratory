<template>
  <Layout title="Меню">
    <MenuList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';
import MenuList from '@/components/MenuList/MenuList';


export default {
  name: 'MenuPage',
  components: {
    Layout,
    MenuList,
  }
}
</script>

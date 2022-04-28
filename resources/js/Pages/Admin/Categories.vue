

<template>
  <AdminLayout>

    <template #title>
      Categories
    </template>
    <template #default>
      <Categories :categories="categories" :subcategories="subcategories"/>
    </template>
  </AdminLayout>
</template>

<script>

import AdminLayout from '@/Layouts/AdminLayout';
import Categories from "@/Dashboard/Categories/index";


export default {
  props:['auth','categories','subcategories'],
  components: {

    Categories,
    AdminLayout
  },
  setup() {
    return {

    };
  },
};
</script>
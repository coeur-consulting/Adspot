<template lang="">
  <input placeholder="Search name" v-model="query" class="py-2 px-4 border rounded md:w-[250px]" />
</template>
<script>
import { ref } from "vue";
import axios from 'axios'
export default {

  setup() {
    const query = ref("");
    const searchProducts = ref([]);

  axios
      .get(`/searchproducts?query=${this.query}`)
      .then((res) => {
        searchProducts.value = res.data;
      });
    return {
      searchProducts,
      query,
    };
  },
};
</script>
<style lang="">
</style>
<template lang="">
  <input placeholder="Search name" v-model="query" class="py-2 px-4 border rounded md:w-[250px]" />
</template>
<script>
import { ref } from "vue";
import axios from 'axios'
export default {

  setup() {
    const query = ref("");
    const searchBlogs = ref([]);

    const searchBlogs = axios
      .get(`/searchblogs?query=${this.query}`)
      .then((res) => {
        searchBlogs.value = res.data;
      });
    return {
      searchBlogs,
      query,
    };
  },
};
</script>
<style lang="">
</style>
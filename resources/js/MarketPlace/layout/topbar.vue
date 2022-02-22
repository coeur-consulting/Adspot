<!-- This example requires Tailwind CSS v2.0+ -->
<template>
<div class="bg-gray-100 p-4">
    <div class="container mx-auto  flex items-center">
    <span
      class="px-6 py-1 rounded-full mr-5 capitalize text-xs"
      @click="setCategory(0)"
      :class="
        !active  ? 'text-orange-500 bg-gray-200' : 'bg-transparent'
      "
      >All</span
    >
    <span
      class="px-6 py-1 text-xs rounded-full mr-5 capitalize"
      @click="setCategory(item.id)"
      :class="
        active === item.id ? 'text-orange-500 bg-gray-200' : 'bg-transparent'
      "
      v-for="item in $page.props.categories"
      :key="item.id"
      >{{ item.name }}</span
    >
  </div>
</div>

</template>

<script>
import { ref,inject } from "vue";

export default {

  setup() {
     const emitter = inject('emitter');
    const active = ref(0);
    const setCategory = (data) => {
      active.value = data;
      emitter.emit("getCategory", data);

    };
    return {
      active,
      setCategory,
    };
  },
};
</script>
<style scoped lang="scss">
nav {
}
</style>
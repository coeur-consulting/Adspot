<template>
  <div class="flex ">
    <TopBar class="w-[25%]" />
    <Filter class="w-[75%]" />
  </div>
</template>

<script>
import TopBar from "./topbar";
import Filter from "./filter";
export default {
  components:{
    TopBar,
    Filter
  }
};
</script>

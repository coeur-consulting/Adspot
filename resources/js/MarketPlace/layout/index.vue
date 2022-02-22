<template lang="">

  <Navigation />
<TopBar/>
<Filter/>
  <div class=" main_body">
 <MainPage/>
  </div>

</template>
<script>
import Navigation from "@/Navigation/GeneralHeader.vue";
import TopBar from "./topbar";
import Filter from "./filter";
import MainPage from "./mainpage";

export default {

  components: {
    TopBar,
    Filter,
    MainPage,
    Navigation
  },
};
</script>
<style lang="scss" scoped>
.main_body {
  height: auto;
}
</style>
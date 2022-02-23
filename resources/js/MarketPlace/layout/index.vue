<template lang="">

  <Navigation />
<TopBar/>
<Filter/>
  <div class=" pb-10">
 <MainPage/>
  </div>
  <Footer/>

</template>
<script>
import Navigation from "@/Navigation/GeneralHeader.vue";
import Footer from "@/Navigation/Footer.vue";
import TopBar from "./topbar";
import Filter from "./filter";
import MainPage from "./mainpage";

export default {

  components: {
    TopBar,
    Filter,
    MainPage,
    Navigation,
    Footer
  },
};
</script>
<style lang="scss" scoped>
.main_body {
  height: auto;
}
</style>
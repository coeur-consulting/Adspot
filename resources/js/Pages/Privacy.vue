<template lang="">
<Head title="Privacy Policy"/>
<Navigation />
<Banner title="Contact Us" :breadcrumbs="breadcrumbs"/>
<div class=" mt-8 relative">
  <div class="relative">

    <div class="w-[80%] grid grid-cols-1 md:grid-cols-3 gap-8 mx-auto py-10 bg-white mb-8 z-10 relative">
    <div class=" min-h-[100px] shadow bg-white w-full text-center p-8 rounded-lg" v-for="item in contents" :key="item.name">
      <img :src="item.img" class="w-16 h-16 mx-auto mb-4" />
      <h5 class="mb-2 font-bold">{{item.title}}</h5>
      <p>
       {{ item.text }}
      </p>
    </div>

  </div>

  </div>



</div>
<div class="container min-h-screen"></div>
  <Footer />
</template>
<script>
import Navigation from "@/Navigation/Header";
import Footer from "@/Navigation/Footer";
import { Head } from "@inertiajs/inertia-vue3";
import Banner from "@/Components/Banner";
import { reactive } from "vue";
import { SearchIcon } from "@heroicons/vue/solid";

export default {
  components: {
    Navigation,
    Head,
    Banner,
    Footer,
    SearchIcon,
  },
  setup() {
    const breadcrumbs = reactive([
      { name: "home", url: "/" },
      { name: "privacy policy", url: null },
    ]);

    return {
      breadcrumbs,
    };
  },
};
</script>
<style lang="scss" scoped>
.side_tab {
  background-image: url("/images/about.png");
  background-size: contain;
  background-position: center;
  background-repeat: no-repeat;
}
</style>
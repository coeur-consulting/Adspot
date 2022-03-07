
<template lang="">
<Head title="Notifications"/>
<Navigation />


     <Notifications />

  <Footer />
</template>
<script>
import Navigation from "@/Navigation/GeneralHeader";
import Footer from "@/Navigation/Footer";
import { Head } from "@inertiajs/inertia-vue3";
import Banner from "@/Components/Banner";
import { reactive } from "vue";
import Notifications from "@/UserComponents/notifications";

export default {
  components: {
    Navigation,
    Head,
    Banner,
    Footer,
    Notifications,
  },
  setup() {
    const breadcrumbs = reactive([
      { name: "home", url: "/" },
      { name: "notifications", url: null },
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


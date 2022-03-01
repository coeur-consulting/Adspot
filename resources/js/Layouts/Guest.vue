<template>
  <div class="min-h-screen flex relative">
    <div class="hidden md:inline-block md:w-2/4 h-screen relative" id="banner">
      <carousel :items-to-show="1" :autoplay="5000" :wrapAround="true">
        <slide v-for="(item, index) in banners" :key="index">
          <img class="h-screen w-full object-cover" :src="item" />
        </slide>
      </carousel>
    </div>

    <div class="w-full md:w-2/4 text-white relative overflow-hidden">
      <div
        class="
          relative
          z-10
          h-screen
          px-5
          py-5
          md:px-16 md:py-8
          flex flex-col
          justify-center
          relative
          overflow-hidden
        "
      >
       <div>
          <div class="text-center mb-4">
        <Link href="/">
          <img src="/images/logo-orange.png" width="100" class="mx-auto" />
        </Link>
        </div>

        <slot />
       </div>
      </div>
      <!-- <span class="absolute -bottom-[30%] -left-[30%]"
        ><img src="/images/dark.png"
      /></span> -->

      <!-- <span class="absolute -top-[30%] -right-[40%]"
        ><img src="/images/dark.png"
      /></span> -->
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide } from "vue3-carousel";
const banners = ["images/banner.png", "images/banner1.png"];
export default {
  components: {
    Link,
    Carousel,
    Slide,
  },
  setup() {
    return {
      banners,
    };
  },
};
</script>
<style scoped lang="scss">
#banner {
  &::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    // background: linear-gradient(
    //   100.82deg,
    //   rgba(253, 186, 116, 0.6) 46.67%,
    //   rgba(255, 255, 255, 0.2) 119.99%
    // );
    z-index: 1;
  }
}

.carousel_line {
  span {
    width: 24px;
    height: 5px;
  }
}
</style>

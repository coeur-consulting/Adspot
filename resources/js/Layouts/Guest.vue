<template>
  <div class=" min-h-screen flex relative">

    <div class="hidden md:inline-block md:w-2/4  h-screen relative"  id="banner">
      <div class="absolute top-10 text-center z-40 flex flex-col items-center w-full py-10 px-12 ">
           <div class="mb-3">
                <Link href="/">
                <BreezeApplicationLogo class="w-40 h-auto fill-current text-gray-500 mb-4" />
            </Link>
           </div>
            <h4 class="text-white font-extrabold text-3xl">Adspot Marketplace</h4>
            <p class="text-white text-2xl"> Nigeria’s number 1 aggregator of advertising spaces and brand solutions </p>
        </div>
      <carousel
        :items-to-show="1"
        :autoplay="5000"
        :loop="true"


      >
        <slide v-for="(item, index) in banners" :key="index">
          <img class="h-screen w-full object-cover" :src="item" />
        </slide>
      </carousel>
    </div>

    <div class="w-full md:w-2/4 bg-orange-300 text-white relative overflow-hidden">
     <div class="relative z-10 h-screen px-5 py-5 md:px-16 md:py-16 flex flex-col justify-between relative overflow-hidden">
          <div class=" md:hidden md:absolute top-10 text-center z-40 flex flex-col items-center w-full py-5 px-1 ">
           <div class="mb-3">
                <Link href="/">
                <BreezeApplicationLogo class="w-40 h-auto fill-current text-gray-500 mb-4" />
            </Link>
           </div>
            <h4 class="text-white font-extrabold text-xl">Adspot Marketplace</h4>
            <p class="text-white text-sm"> Nigeria’s number 1 aggregator of advertising spaces and brand solutions </p>
        </div>
          <slot />
     </div>
       <span class="absolute -bottom-[30%] -left-[30%] "><img src="/images/white.png"  /></span>

       <span class="absolute -top-[30%] -right-[40%] "><img src="/images/white.png"  /></span>




    </div>
  </div>
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide } from "vue3-carousel";
const banners = ["images/banner.png", "images/banner1.png"];
export default {
  components: {
    BreezeApplicationLogo,
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

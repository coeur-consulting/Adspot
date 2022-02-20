<template lang="">
  <section id="Popular" class="relative  bg-gray-50 z-[1]">
    <div class="container mx-auto py-44">
      <div class="mb-5 flex justify-between">
        <h6 class="font-bold">Most Popular Adspot</h6>
       <span class="w-[200px] flex justify-end items-center">
          <span class="text-xs text-orange-500 mr-4 cursor-pointer">View all</span>
          <span class="flex"> <span class="bg-white p-1 mr-2 rounded-full cursor-pointer"  @click="goto('prev')"><ChevronLeftIcon class="w-4 h-4  cursor-pointer"/></span>
  <span class="bg-white p-1 rounded-full cursor-pointer"  @click="goto('next')"><ChevronRightIcon class="w-4 h-4"/></span></span>
       </span>
      </div>
        <carousel
        :wrap-around="true"
        :pauseAutoplayOnHover="true"
      :items-to-show="3.5"
      :autoplay="5000"
      :loop="true"
      ref="slider"
      class="h-full w-full z-10"
    >
      <slide v-for="(item, index) in 6" :key="index" class="p-5">
       <div class="h-[400px] bg-white rounded-lg shadow w-full overflow-hidden z-10">
         <div class=" h-2/4 w-full">
          <img class=" w-full h-full object-center object-cover" src="/images/banner.png" />

         </div>
         <div class="h-2/4 w-full p-4 text-left">
          <p class="text-sm">90,000 Weekly impressions</p>
          <p class="font-bold text-xl"> ₦80,000 /4 week</p>
         <p class="text-xs"><span >Ad type</span> : <span class="text-slate-400">Billboard</span> </p>
          <p class="text-xs"><span>Location</span> : <span class="text-slate-400"> Marina Express Ibeju Lekki, Lagos</span> </p>
           <p class="text-xs"><span>Dimension</span> : <span class="text-slate-400">4000 x 5000</span></p>
<div class="flex justify-between mt-5">
   <a
            v-if="!$page.props.auth.user"
            href="/register"
            class="
              hidden
              md:inline

              whitespace-nowrap
              inline-flex
              items-center
              justify-center
              px-8
              py-2
              border border-orange-500
              rounded-full
              shadow-sm
              text-xs
              text-orange-500
              font-bold
              text-white
              bg-white
              hover:bg-orange-500
              hover:text-white
            "
          >
          More details
          </a>
           <a
            v-if="!$page.props.auth.user"
            href="/register"
            class="
              hidden
              md:inline

              whitespace-nowrap
              inline-flex
              items-center
              justify-center
              px-8
              py-2
              border border-orange-500
              rounded-full
              shadow-sm
              text-xs
              text-white
              font-bold
              text-white
             bg-orange-500
              hover:bg-orange-300

            "
          >
          Place bid
          </a>
</div>
         </div>
       </div>
      </slide>

      <template #addons="{ currentSlide }">
        <span class="hidden">{{ (index = currentSlide) }}</span>
      </template>
    </carousel>


    </div>
     <span class="absolute top-[2%] left-[-4%] z-[1] rotate-45"><img src="/images/spiral.png" class="w-[100%]" /></span>

  </section>
</template>
<script>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/solid";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide } from "vue3-carousel";
export default {
  components: {
    Carousel,
    Slide,
    ChevronLeftIcon,
    ChevronRightIcon,
  },
  data() {
    return {
      index: 0,
    };
  },
  methods: {
    goto(n) {
      n === "next"
        ? this.$refs.slider.next()
        : this.$refs.slider.prev();
    },
  },
};
</script>
<style lang="">
</style>
<template>
  <section id="banner" class="relative h-[92vh] group">
    <carousel
      :items-to-show="1"
       :autoplay="5000"
        :wrapAround="true"
      ref="slider"
      class="h-full w-full "
    >
      <slide v-for="(item, index) in banners" :key="index" class="group">
        <img class="h-full md:h-[92vh] w-full kenburns-top-right" :src="item" />
      </slide>

      <template #addons="{ currentSlide }">
        <span>{{ (index = currentSlide) }}</span>
      </template>
    </carousel>

    <div
      class="
      peer
        container
        mx-auto
        flex flex-col
        justify-center
        h-full
        w-full
        z-10
        absolute
        top-0
        left-0
        right-0
        bottom-0
      "
    >
      <div class="left_banner w-full md:w-4/6 py-5  text-white">
        <h1 class="text-white text-3xl font-extrabold mb-4">
          Adspots Digital
            Solutions, Nigeria’s number 1 aggregator of advertising spaces and brand
          solutions
        </h1>
        <div class="banner_m text-left mb-6">
          <p class="leading-normal text-white">
            We exist to help advertisers and agencies find, negotiate and pay
            for advertising spaces easily and transparently. We also provide
            data and insight that help our clients make informed decisions and
            reach their target audience efficiently and effectively.
          </p>
        </div>
        <div class="md:hidden">
          <button
            type="button"
            class="
              px-4
              py-2
              border border-transparent
              rounded-full
              shadow-lg
              text-xs text-white
              bg-orange-500
              focus:ring-2 focus:ring-inset focus:ring-orange-500
              flex
              items-center
            "
          >
            <span class="mr-2 text-white font-bold">Search inventory</span>
            <SearchIcon class="w-3 h-3" />
          </button>
        </div>
      </div>
      <div class="banner_b text-left w-full  hidden md:block">
        <SearchBox />
      </div>

      <div class="absolute bottom-10 z-20 right-10 flex items-center">
        <span class="text-white">0{{ index + 1 }}</span>
        <span
          class="
            carousel_line
            grid grid-cols-2
            mx-2
            rounded-full
            overflow-hidden
          "
        >
          <span
            class="carousel_1 cursor-pointer"
            v-for="n in 2"
            :key="n"
            :class="n === index + 1 ? 'bg-orange-500' : 'bg-white'"
            @click="goto(n - 1)"
          >
          </span>
        </span>
        <span class="text-white">02</span>
      </div>
    </div>
  </section>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import SearchBox from "@/Components/SearchBox.vue";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide } from "vue3-carousel";
import { ref } from "vue";
import { SearchIcon } from "@heroicons/vue/solid";
const banners = ["images/banner.png", "images/banner1.png"];
export default {
  components: {
    Link,
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    BreezeDropdown,
    BreezeDropdownLink,
    SearchBox,
    SearchIcon,
    Carousel,
    Slide,
  },
  data() {
    return {
      index: 0,
    };
  },
  setup() {
    return {
      banners,
    };
  },

  methods: {
    goto(n) {
      this.$refs.slider.slideTo(n);
      this.index = n;
    },
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
    background: linear-gradient(
      100.82deg,
      #000000 46.67%,
      rgba(255, 255, 255, 0) 119.99%
    );
    z-index: 1;
  }
}

.banner_h {
  margin-bottom: 4rem;
}
.banner_m {
  margin-bottom: 4rem;
  p {
    font-size: 1rem;
  }
}
.right_banner {
}
.search {
  position: absolute;
  top: 8%;
  left: 20%;
}
.carousel_line {
  span {
    width: 24px;
    height: 5px;
  }
}
</style>
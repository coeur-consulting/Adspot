<template>
  <div class="bg-white h-full relative">
    <div class="h-[450px] product_image"></div>
    <div class="w-4/6 mr-auto px-5 py-10">
      <div class="mr-5 flex justify-between">
        <div class="mb-4 w-[73%]">
          <div class="flex mr-5 mb-5 items-center">
            <h4 class="mr-5 font-extrabold text-xl">Title Here</h4>
            <div>
              <span
                class="
                  text-orange-600
                  bg-orange-100
                  rounded-full
                  px-5
                  py-2
                  text-base
                "
                >Rarely available</span
              >
            </div>
          </div>
          <p>
            Desccription about the ad spot Lorem ipsum dolor sit amet,
            consectetur adipiscing elit. Integer bibendum, lorem id pellentesque
            susci pit, dolor nibh dignissim orci, at condimentum ipsum magna
            vehicula massa. Null am leo eros, aliquam ac pellentesque ut,
            gravida et magna. Etiam ut enim mollis , vulputate ante vel,
            vehicula arcu.
          </p>
        </div>
        <div class="map bg-blue-100 p-10 rounded-lg w-[25%] mb-12">
          <GMapMap
            :center="center"
            :zoom="7"
            map-type-id="terrain"
            style="width: 300px; height: 300px"
          >
            <GMapCluster>
              <GMapMarker
                :key="index"
                v-for="(m, index) in markers"
                :position="m.position"
                :clickable="true"
                :draggable="true"
                @click="center = m.position"
              />
            </GMapCluster>
          </GMapMap>
        </div>
      </div>
      <hr />
      <div class="py-5 mt-6">
        <v-date-picker
          v-model="range"
          :columns="2"
          is-range
          is-expanded
          :modelConfig="modelConfig"
        />
      </div>
    </div>

    <div class="w-[350px] fixed right-8 top-[25%] z-40">
      <div class="bg-white shadow-lg px-5 py-8 text-left rounded-lg mb-8">
        <p class="mb-2 text-xl text-black">90,000 Weekly impressions</p>
        <p class="mb-1 font-bold text-3xl text-black">₦80,000 /4 week</p>
        <p class="mb-1 text-base">
          <span class="text-black">Ad type</span> :
          <span class="text-slate-400">Billboard</span>
        </p>
        <p class="mb-1 text-base leading-snug">
          <span class="text-black">Location</span> :
          <span class="text-slate-400"> Marina Express Ibeju Lekki, Lagos</span>
        </p>
        <p class="mb-2 text-base">
          <span class="text-black">Dimension</span> :
          <span class="text-slate-400">4000 x 5000</span>
        </p>

        <div class="my-6 border rounded-lg grid grid-cols-2 gap-6 p-4">
          <div>
            <p class="text-base text-slate-400">Start Date</p>
            <p class="font-bold">May 2, 2019</p>
          </div>
          <div>
            <p class="text-base text-slate-400">End Date</p>
            <p class="font-bold">May 21, 2019</p>
          </div>
        </div>
        <div class="mt-8">
          <button
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
              shadow-base
              text-base text-white
              font-bold
              text-white
              bg-orange-500
              hover:bg-orange-300
              w-full
            "
          >
            Add to cart
          </button>
        </div>
      </div>

      <div class="bg-gray-50 rounded-lg p-5">
        <h5 class="font-bold mb-2 text-black">For Enquiries</h5>
        <p class="text-sm">
          <span class="">Email</span> : <span class="">tester@test.com</span>
        </p>
        <p class="text-sm">
          <span class="">Call Phone</span> : <span class="">+234901258839</span>
        </p>
        <p class="text-sm">
          <span class="">Whatsapp</span> : <span class="">+234901258839</span>
        </p>
      </div>
    </div>

    <div></div>
    <XCircleIcon
      class="w-8 h-8 absolute top-8 right-8 text-white"
      @click="toggleModal(null)"
    />
  </div>
</template>

<script>
import { ref, computed, reactive, toRefs } from "vue";
import { XCircleIcon } from "@heroicons/vue/solid";
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { ShoppingCartIcon } from "@heroicons/vue/solid";

import "v-calendar/dist/style.css";
export default {
  inject: ["currency", "emitter"],
  props: ["product"],
  components: {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    XCircleIcon,
    ShoppingCartIcon,
  },
  setup(props, context) {

    const { product } = toRefs(props);
    
    const range = reactive({
      start: new Date(),
      end: null,
    });
    const modelConfig = reactive({
      type: "string",
      mask: "YYYY-MM-DD", // Uses 'iso' if missing
    });
    const center = reactive({ lat: 51.093048, lng: 6.84212 });
    const markers = reactive([
      {
        position: {
          lat: 51.093048,
          lng: 6.84212,
        },
      },
      // Along list of clusters
    ]);
    const toggleModal = (data) => {
      context.emit("toggleModal", data);
    };

    return {
      range,
      modelConfig,
      center,
      markers,
      toggleModal,
      product,
    };
  },
  data() {
    return {
      date: new Date(),
    };
  },

  methods: {
    addtocart(product) {
      this.emitter.emit("addtocart", product);
      this.cartItems = JSON.parse(localStorage.getItem("cartItems"));
    },
    inCart(id) {
      return this.cartItems.some((item) => item.id == id);
    },
  },
};
</script>
<style scoped lang="scss">
.product_image {
  background-image: url("/images/banner.png");
  background-size: cover;
}
</style>
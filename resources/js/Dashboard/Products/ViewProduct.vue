<template>

  <div
    class="bg-white h-full relative px-3 py-4 md:px-0 md:py-0"
    v-if="product"
  >
    <div
      class="h-[200px] md:h-[450px] product_image"
      :style="`background-image:url(${
        product.media ? product.media[0] : '/images/banner.png'
      })`"
    ></div>
    <div class="w-full md:w-4/6 mr-auto px-5 py-10">
      <div class="mr-5 flex flex-col md:flex-row justify-between">
        <div class="mb-4 w-full md:w-[73%]">
          <div class="flex mr-5 mb-5 items-center">
            <h4 class="mr-5 font-extrabold text-xl">{{ product.name }}</h4>
          </div>
          <p>
            {{ product.description }}
          </p>
        </div>
        <div class="map bg-blue-100 p-10 rounded-lg w-full md:w-[25%] mb-12">
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
          color="orange"
          mode="date"
          v-model="range"
          :columns="$screens({ default: 1, lg: 2 })"
          is-range
          is-expanded
          :modelConfig="modelConfig"
          :min-date="product.start_time"
          :max-date="product.end_time"
        />
      </div>
    </div>

    <div
      class="
        w-[100%]
        mx-auto
        md:w-[350px] md:fixed md:right-8 md:top-[25%]
        z-40
      "
    >
      <div class="bg-white md:shadow-lg px-5 py-8 text-left rounded-lg mb-8">
        <!-- <p class="mb-2 text-base text-black">
          {{ product.impressions.toLocaleString("en-US") }} Weekly impressions
        </p> -->
        <p class="mb-1 font-bold text-3xl text-black">
          {{ currency(product.price) }}
          <span class="text-xs">/ {{ product.duration }} days</span>
        </p>
        <p class="mb-1 text-base">
          <span class="text-black">Duration </span> :
          <span class="text-slate-600 capitalize">{{
            product.duration_type
          }}</span>
        </p>
        <p class="mb-1 text-base">
          <span class="text-black">Ad type</span> :
          <span class="text-slate-600 capitalize">{{
            product.subcategory.name
          }}</span>
        </p>
        <p class="mb-1 text-base leading-snug">
          <span class="text-black">Location</span> :
          <span class="text-slate-600"> {{ product.location }}</span>
        </p>
        <p class="mb-2 text-base">
          <span class="text-black">Dimension</span> :
          <span class="text-slate-600">{{ product.dimension }}</span>
        </p>
        <p class="mb-1 text-base">
          <span class="text-black">Type</span> :
          <span class="text-slate-600 capitalize">{{ product.type }}</span>
        </p>

        <div>
          <div
            class="my-6 border bg-gray-50 rounded-lg grid grid-cols-2 gap-6 p-4"
          >
            <div>
              <p class="text-xs text-slate-600">Start Date</p>
              <p class="font-bold text-sm">
                {{ moment(product.start_time).format("MMM DD, yyyy") }}
              </p>
            </div>
            <div>
              <p class="text-xs text-slate-600">End Date</p>
              <p class="font-bold text-sm">
                {{ moment(product.end_time).format("MMM DD, yyyy") }}
              </p>
            </div>
          </div>
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
import { ref, reactive, toRefs } from "vue";
import { XCircleIcon } from "@heroicons/vue/solid";
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";
import { ShoppingCartIcon } from "@heroicons/vue/solid";
import moment from "moment";
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
      modelConfig,
      center,
      markers,
      toggleModal,
      product,
      moment,

    };
  },

  computed: {
    range() {
      let range = {};
      range.start = this.product.start_time;
      range.end = this.product.end_time;
      return range;
    },
  },
};
</script>
<style scoped lang="scss">
.product_image {
  background-size: cover;
}
</style>
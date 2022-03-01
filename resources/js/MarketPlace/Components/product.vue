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
        <p class="mb-2 text-base text-black">
          {{ product.impressions }} Weekly impressions
        </p>
        <p class="mb-1 font-bold text-3xl text-black">
          {{ currency(product.price) }} / {{ product.duration }}
        </p>
        <p class="mb-1 text-base">
          <span class="text-black">Ad type</span> :
          <span class="text-slate-400">{{ product.subcategory.name }}</span>
        </p>
        <p class="mb-1 text-base leading-snug">
          <span class="text-black">Location</span> :
          <span class="text-slate-400"> {{ product.location }}</span>
        </p>
        <p class="mb-2 text-base">
          <span class="text-black">Dimension</span> :
          <span class="text-slate-400">{{ product.dimension }}</span>
        </p>

        <div
          class="my-6 border bg-gray-50 rounded-lg grid grid-cols-2 gap-6 p-4"
        >
          <div>
            <p class="text-xs text-slate-400">Start Date</p>
            <p class="font-bold text-sm">
              {{ moment(range.start).format("MMM DD, yyyy") }}
            </p>
          </div>
          <div>
            <p class="text-xs text-slate-400">End Date</p>
            <p class="font-bold text-sm">
              {{moment(range.end).format("MMM DD, yyyy") }}
            </p>
          </div>
        </div>
        <div class="my-3" v-if="product.negotiable">
          <label for="negotiate" class="block font-medium text-sm text-gray-700"
            >Negotiation</label
          >
          <div
            class="
              flex
              shadow-sm
              rounded
              overflow-hidden
              border border-gray-300
            "
          >
            <div
              class="bg-slate-100 px-3 py-1 flex-none text-xs flex items-center"
            >
              NGN
            </div>
            <div class="grow">
              <input
                class="
                  w-full
                  h-full
                  px-3
                  py-2
                  border-gray-300
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                "
                v-model="negotiation"
                type="number"
                placeholder="Price"
              />
            </div>
          </div>
        </div>
        <div class="mt-8">
        <AddToCart :product="product" :negotiation="negotiation"/>
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
import moment from "moment";
import "v-calendar/dist/style.css";
import AddToCart from '@/Components/AddToCart'
export default {
  inject: ["currency", "emitter"],
  props: ["product"],
  components: {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    XCircleIcon,
    ShoppingCartIcon,
    AddToCart
  },
  setup(props, context) {
    const { product } = toRefs(props);
  const negotiation = ref(product.price)
    const range = reactive({
      start: new Date(),
      end:  moment().add(product.duration,'days').format('YYYY-MM-DD'),
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
      moment,
      negotiation
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
  background-size: cover;
}
</style>
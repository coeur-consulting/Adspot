<!-- This example requires Tailwind CSS v2.0+ -->
<template>


  <div class="flex flex-col bg-white  shadow rounded">
    <div class="-my-2  sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-3 lg:px-8 overflow-x-auto">

        <div
          class=" overflow-hidden border-b border-gray-200 sm:rounded-lg"
        >
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="
                    px-3
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  S/N
                </th>
                <th
                  scope="col"
                  class="
                    px-3
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Name
                </th>

                <th
                  scope="col"
                  class="
                    px-3
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Type
                </th>
                <th
                  scope="col"
                  class="
                    px-3
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Duration
                </th>
                <th
                  scope="col"
                  class="
                    px-3
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Price
                </th>

                <th
                  scope="col"
                  class="
                    px-3
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Status
                </th>
                <th
                  scope="col"
                  class="
                    px-3
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Offers
                </th>

                <th scope="col" class=" px-3
                    py-3
                    text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider">
                  <span class="">Action</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="(product, index) in products"
                :key="product.id"
              >
                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ index + 1 }}
                </td>
                <td class="px-3 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-6 w-6" v-if="product.media">
                      <img
                        class="h-6 w-6 rounded-full"
                        :src="product.media[0]"
                        alt=""
                      />
                    </div>
                    <div class="ml-2">
                      <div
                        class="
                          text-sm
                          font-medium
                          text-gray-900
                          truncate
                          overflow-hidden
                          ...
                        "
                      >
                        {{ product.name }}
                      </div>
                    </div>
                  </div>
                </td>

                <td class="px-3 py-4 whitespace-nowrap">
                  <span
                    class="
                      px-2
                      inline-flex
                      text-xs
                      leading-5
                      font-semibold
                      rounded-full
                      bg-gray-100
                      text-gray-500
                      capitalize
                    "
                  >
                    {{ product.type }}
                  </span>
                </td>
                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">

                  <span class="flex p-1 border justify-between text-xs rounded">
                    <span>{{moment(product.start_time).format("MMM DD, yyyy")}}</span>
                    <span class="mx-1">-</span>
                      <span>{{moment(product.end_time).format("MMM DD, yyyy")}}</span>
                  </span>
                </td>
                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ currency(product.price) }}
                </td>


                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                 <span class="py-1 px-2 text-xs rounded-full" :class="!product.status ? 'bg-red-100 text-red-500' : 'bg-green-100 text-green-500'"> {{ !product.status ? "Inactive" : "Active" }}</span>
                </td>

                <td class="px-3 py-4 whitespace-nowrap">
                  <div
                    class="
                      text-sm text-gray-900 text-ellipsis
                      overflow-hidden
                      ...
                    "
                  >
                    {{ product.offers }}
                  </div>
                </td>
                 <td class="px-3 py-4 whitespace-nowrap">
                  <div
                    class="
                      text-sm text-gray-900
                    "
                  >
                    <span

                     @click="viewoffers(product.id,product.status)"
                    class="mr-3 cursor-pointer"
                    >View offers</span
                  >
                  </div>
                </td>

              </tr>
            </tbody>

          </table>
        </div>

        <div class="text-right py-5 px-4">
       <a href="/products" class="flex justify-end items-center">   <span class="text-orange-500 mr-1">View all</span> <ArrowNarrowRightIcon class="w-4 h-4 text-orange-500"/></a>
        </div>
      </div>
    </div>
  </div>


</template>

<script>

import {
  ExclamationIcon,
  ArrowCircleLeftIcon,
  ArrowCircleRightIcon,
  EyeIcon, TrashIcon,PencilAltIcon
} from "@heroicons/vue/outline";

import { PlusCircleIcon,ArrowNarrowRightIcon } from "@heroicons/vue/solid";
import { usePage } from "@inertiajs/inertia-vue3";
import { ref, onMounted, computed, watch, inject, reactive } from "vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeLabel from "@/Components/Label.vue";
import moment from 'moment'
export default {
  inject: ["emitter", "currency"],
  components: {
    PlusCircleIcon,
    ExclamationIcon,
    ArrowNarrowRightIcon,
    ArrowCircleLeftIcon,
    ArrowCircleRightIcon,
    BreezeCheckbox,
    BreezeLabel,
    EyeIcon,
    TrashIcon,
    PencilAltIcon
  },
  data() {
    return {
      open: false,
      type: "",
    };
  },
  setup() {
    const products = ref([]);
    const query = ref("");
    const current_page = ref(1);
    const showFeatured = ref(false);
    const showNegotiable = ref(false);
    const showNonnegotiable = ref(false);
    const last_page = ref(1);
   onMounted(()=>{
     getproducts()
   })

    function getproducts() {
      axios.get(`get-products-mini`).then((res) => {
        if (res.status === 200) {
          products.value = res.data.data;

        }
      });
    }

    function viewoffers(id,status) {

      window.location.href = `/offers/${id}`;
    }
    return {
      viewoffers,
      products,
moment

    };
  },
  methods: {
    toggleModal(val, product) {
      this.open = !this.open;
      this.type = val;
      this.product = product;
    },
    updatepage(data) {
      if (this.type == "edit") {
        this.products.map((item) => {
          if (item.id == this.product.id) {
            item = data.data;
          }
          return item;
        });
      } else {
        this.products.unshift(data.data);
      }
      this.open = false;
    },
    dropProduct(id) {
      var res = confirm("Are you sure");
      if (res) {
        axios.delete(`/products/${id}`).then((res) => {
          if (res.status === 200) {
            this.products = this.products.filter((item) => item.id != id);
          }
        });
      }
    },
  },
};
</script>
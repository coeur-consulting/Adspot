<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="mb-3">
    <ul class="breadcrumb text-xs">
      <li><a href="/dashboard">Dashboard</a></li>
      <li><a href="/products">Products</a></li>
      <li class="capitalize">{{ product.name }} offers</li>
    </ul>
  </div>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div
          class="
            shadow
            overflow-hidden
            border-b border-gray-200
            sm:rounded-lg
            p-4
            bg-white
          "
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
                    px-6
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
                    px-6
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
                    px-6
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
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Verdict
                </th>

                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-center text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  <span class="">Actions</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(offer, index) in offers" :key="offer.id">
                <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                  {{ index + 1 }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-base leading-5 capitalize">
                    {{ offer.user.name }}
                  </span>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    v-if="offer.result == 'success'"
                    class="
                      text-base
                      rounded-full
                      text-green-800
                      font-semibold
                      bg-green-100
                      px-4
                      py-1
                    "
                  >
                    {{ currency(offer.bid_price) }}
                  </span>
                  <span
                    v-if="offer.result == 'pending'"
                    class="
                      text-base
                      rounded-full
                      text-yellow-800
                      font-semibold
                      bg-yellow-100
                      px-4
                      py-1
                    "
                  >
                    {{ currency(offer.bid_price) }}
                  </span>
                  <span
                    v-if="offer.result == 'failed'"
                    class="line-through text-red-500"
                  >
                    {{ currency(offer.bid_price) }}</span
                  >
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex text-base leading-5 capitalize">
                    <span>{{
                      moment(offer.start).format("MMM DD, yyyy")
                    }}</span>
                    <span class="mx-2">-</span>
                    <span class="mr-4">{{
                      moment(offer.end).format("MMM DD, yyyy")
                    }}</span>
                    <span>({{ offer.duration }} days)</span>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-base leading-5 capitalize">
                    {{ offer.result }}
                  </span>
                </td>
                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-right text-base
                    font-medium
                    flex
                    items-center
                    justify-center
                  "
                >
                  <span v-if="!offer.status">Done</span>
                  <div
                    class="flex items-center justify-end"
                    v-if="offer.status && product.type == 'negotiable'"
                  >
                    <span
                      class="
                        mr-4
                        text-green-600
                        hover:text-green-900
                        flex
                        cursor-pointer
                      "
                      @click="handleOffer('accept', offer.id)"
                      ><span class="mr-2">Approve</span>
                      <CheckIcon class="w-6 h-6" />
                    </span>

                    <span
                      @click="handleOffer('reject', offer.id)"
                      class="
                        text-red-600
                        hover:text-red-900
                        flex
                        cursor-pointer
                      "
                      ><span class="mr-2">Decline</span> <XIcon class="w-6 h-6"
                    /></span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="text-center mt-8" v-if="!offers.length">
            <span class="px-6 py-2 bg-blue-50 rounded">No offer available</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { ExclamationIcon, CheckIcon, XIcon } from "@heroicons/vue/outline";
import { PlusCircleIcon } from "@heroicons/vue/solid";
import moment from "moment";
export default {
  setup() {
    const open = ref(false);

    return {
      open,
      moment,
    };
  },
  inject: ["emitter", "currency"],
  data() {
    return {
      offers: [],
      product: {},
    };
  },
  mounted() {
    this.offers = this.$page.props.product.offers;
    this.product = this.$page.props.product;
  },
  methods: {
    handleOffer(type, id) {
      let info = { id, type };
      axios.post("/handle/offers", info).then((res) => {
        if (type === "reject") {
          this.offers = this.offers.slice().map((item) => {
            if (item.id === id) {
              item.result = res.data.result;
              item.status = res.data.status;
            }
            return item;
          });
        } else {
          this.offers = res.data;
        }
      });
    },
  },
  components: {
    CheckIcon,
    XIcon,
    PlusCircleIcon,
    ExclamationIcon,
  },
};
</script>
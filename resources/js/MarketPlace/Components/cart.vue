<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <TransitionRoot as="template" :show="open">
    <Dialog
      as="div"
      class="fixed inset-0 overflow-hidden"
      style="z-index: 999"
      @close="open = false"
    >
      <div class="absolute inset-0 overflow-hidden">
        <TransitionChild
          as="template"
          enter="ease-in-out duration-500"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in-out duration-500"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <DialogOverlay
            class="
              absolute
              inset-0
              bg-gray-500 bg-opacity-75
              transition-opacity
            "
          />
        </TransitionChild>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
          <TransitionChild
            as="template"
            enter="transform transition ease-in-out duration-500 sm:duration-700"
            enter-from="translate-x-full"
            enter-to="translate-x-0"
            leave="transform transition ease-in-out duration-500 sm:duration-700"
            leave-from="translate-x-0"
            leave-to="translate-x-full"
          >
            <div class="w-screen max-w-md">
              <div
                class="
                  h-full
                  flex flex-col
                  bg-white
                  shadow-xl
                  overflow-y-scroll
                "
              >
                <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-3">
                  <div class="flex items-start justify-between">
                    <DialogTitle class="text-lg font-medium text-gray-900">
                      Shopping cart
                    </DialogTitle>
                    <div class="ml-3 h-7 flex items-center">
                      <button
                        type="button"
                        class="-m-2 p-2 text-gray-400 hover:text-gray-500"
                        @click="open = false"
                      >
                        <span class="sr-only">Close panel</span>
                        <XIcon class="h-6 w-6" aria-hidden="true" />
                      </button>
                    </div>
                  </div>

                  <div class="mt-8">
                    <div class="flow-root">
                      <div class="text-right mb-3" v-if="cart.length">
                        <span
                          @click="clearcart"
                          class="flex items-center ml-auto"
                        >
                          Clear cart <XIcon class="w-4 h-4 ml-1"
                        /></span>
                      </div>
                      <ul role="list" class="divide-y divide-gray-200">
                        <li
                          v-for="item in cart"
                          :key="item.product.id"
                          class="
                            py-3
                            px-3
                            flex
                            item-center
                            border
                            rounded-lg

                            mb-4
                          "
                        >
                          <div
                            class="
                             mr-4
                              w-16
                              h-16
                              border border-gray-200
                              rounded-md
                              overflow-hidden
                            "
                          >
                            <img
                              v-if="item.product.media"
                              :src="item.product.media[0]"
                              :alt="item.product.name"
                              class="w-full h-full object-center object-cover"
                            />
                          </div>

                          <div class="flex flex-col grow">
                            <div>
                              <div class="text-base font-medium text-gray-900">
                                <h3 class="mb-2">
                                  {{ item.product.name }}
                                </h3>
                                <p class="text-xs text-slate-500">{{item.duration}} x days</p>

                                <div class="flex justify-between items-end">
                                  <div class="leading-3 flex items-end">
                                    <span class="text-xs text-muted mr-2"
                                      >Subtotal</span
                                    >
                                    <p
                                      class="
                                        text-sm
                                        font-medium
                                        text-gray-900
                                        mb-0
                                      "
                                    >
                                      {{ currency(item.price) }}
                                    </p>
                                  </div>
                                  <TrashIcon
                                    @click="removefromcart(item.id)"
                                    class="w-4 h-4 ml-4 text-red-500"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                      <div v-if="!cart.length" class="text-center py-40">
                        <p>Your cart is empty!</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="border-t border-gray-200 py-6 px-4 sm:px-3"
                  v-if="cart.length"
                >
                  <div
                    class="
                      flex
                      justify-between
                      text-base
                      font-medium
                      text-gray-900
                    "
                  >
                    <p>Subtotal</p>
                    <div class="leading-3">
                      <p class="text-sm font-medium text-gray-900 mb-0">
                        {{ currency(total) }}
                      </p>
                    </div>
                  </div>
                  <p class="mt-0.5 text-sm text-gray-500">
                   Taxes calculated at checkout.
                  </p>
                  <div class="mt-6">
                    <a
                      href="/cart"
                      class="
                        flex
                        justify-center
                        items-center
                        px-3
                        py-3
                        border border-transparent
                        rounded-md
                        shadow-sm
                        text-base
                        font-medium
                        text-white
                        bg-orange-600
                        hover:bg-orange-700
                      "
                      >View Summary</a
                    >
                  </div>
                  <div
                    class="
                      mt-6
                      flex
                      justify-center
                      text-sm text-center text-gray-500
                    "
                  >
                    <p>
                      or
                      <button
                        type="button"
                        class="
                          text-orange-600
                          font-medium
                          hover:text-orange-500
                        "
                        @click="open = false"
                      >
                        Continue Shopping<span aria-hidden="true"> &rarr;</span>
                      </button>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import { ref } from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XIcon } from "@heroicons/vue/outline";
import {
  PlusCircleIcon,
  MinusCircleIcon,
  TrashIcon,
} from "@heroicons/vue/solid";

export default {
  components: {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    XIcon,
    PlusCircleIcon,
    MinusCircleIcon,
    TrashIcon,
  },
  inject: ["emitter", "currency"],
  props: ["open"],
  setup() {
    const open = ref(false);

    return {};
  },
  data() {
    return {
      cart: [],
      cartItems: [],
      rate: null,
    };
  },
  created() {
    this.cartItems = JSON.parse(localStorage.getItem("cartItems"));
    this.emitter.on("addtocart", () => {
      this.cartItems = JSON.parse(localStorage.getItem("cartItems"));
    });
  },
  computed: {
    total() {
      if (!this.cart.length) return 0;
      return this.cart.map((item) => item.price).reduce((a, b) => a + b);
    },
  },
  watch: {
    open: "getcart",
  },
  methods: {
    getcart() {
      this.cartItems = JSON.parse(localStorage.getItem("cartItems"));
      axios.get("/getfullcart").then((res) => {
        this.cart = res.data;
      });
    },
    removefromcart(id) {
     let confirm = window.confirm('Are you sure?')
     if(confirm){
        axios.delete(`/remove/cart/${id}`).then((res) => {
        if (res.status === 200) {
          this.emitter.emit("addtocart");
          this.cart = this.cart.slice().filter((item) => item.id != id);
        }
      });
     }

      // this.cartItems = this.cartItems.filter((item) => item.id !== id);
      // localStorage.setItem(
      //   "cartItems",
      //   JSON.stringify(this.cartItems.length ? this.cartItems : [])
      // );
    },

    clearcart() {
      axios.get(`/clear/cart`).then((res) => {
        if (res.status === 200) {
          this.emitter.emit("addtocart");
          this.cart = [];
        }
      });
      // this.cartItems = this.cartItems.map((item) => {
      //   if (item.id == id && item.quanity > 1) {
      //     item.quanity = item.quantity--;
      //   }
      //   return item;
      // });
      // localStorage.setItem("cartItems", JSON.stringify(this.cartItems));
    },
  },
};
</script>
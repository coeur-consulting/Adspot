<template lang="">
    <div class="relative container mx-auto">
        <div class="container mx-auto py-10 z-10 relative">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-14 mb-5">
                <div
                    class="md:col-span-2 overflow-auto max-h-[90vh] px-5 md:px-0"
                >
                    <h4 class="mb-6 font-bold">
                        My Shopping Cart
                        <span class="text-xs text-slate-400 ml-1"
                            >({{ carts.length }} items)</span
                        >
                    </h4>
                    <div
                        class="p-4 shadow-sm rounded border mb-5 bg-white"
                        v-for="cart in carts"
                        :key="cart.id"
                    >
                        <div v-if="cart.product.type == 'negotiable'">
                            <div
                                class="p-1 bg-orange-100 text-orange-500 text-xs rounded text-center mb-3"
                                v-if="cart.offer.result == 'pending'"
                            >
                                The price you offered for the adspot
                                <span class="font-extrabold">{{
                                    currency(cart.price)
                                }}</span>
                                is in review you will be allowed to checkout if
                                the amount meets the negotiation range
                            </div>
                            <div
                                class="p-1 bg-green-100 text-green-500 text-xs rounded text-center mb-3"
                                v-if="cart.offer.result == 'success'"
                            >
                                <span class="font-extrabold">{{
                                    currency(cart.price)
                                }}</span>
                                the negotiated price has been accepted you can
                                now proceed to checkout the price will be
                                updated on your order summary
                            </div>
                            <div
                                class="p-1 bg-red-100 text-red-500 text-xs rounded text-center mb-3"
                                v-if="cart.offer.result == 'failed'"
                            >
                                <span class="font-extrabold">{{
                                    currency(cart.price)
                                }}</span>
                                the negotiated price has been declined you can
                                reapply if it is still available
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="md:mr-4">
                                <img
                                    :src="cart.product.media[0]"
                                    class="w-full md:w-[150px] h-[100px] rounded-lg"
                                />
                            </div>
                            <div
                                class="flex flex-col md:flex-row justify-between items-end grow p-3 md:p-0"
                            >
                                <span>
                                    <p>
                                        <span class="font-semibold text-base">{{
                                            currency(cart.product.price)
                                        }}</span>
                                        <span class="text-sm text-slate-400"
                                            >/ {{ cart.product.duration }} days</span
                                        >
                                    </p>
                                    <!-- <p class="font-bold text-sm">
                                        {{
                                            cart.product.impressions.toLocaleString(
                                                "en-US"
                                            )
                                        }}
                                        Weekly Impression
                                    </p> -->
                                    <p
                                        class="font-bold text-base"
                                        v-if="cart.offer"
                                    >
                                        Negotiated Price:
                                        {{ currency(cart.price) }} / {{ cart.duration }} days
                                    </p>
                                    <p class="text-slate-400 text-sm">
                                        <span class="capitalize">{{
                                            cart.product.subcategory.name
                                        }}</span>
                                        @ {{ cart.product.location }}
                                    </p>
                                    <p class="text-slate-400 text-xs">
                                        {{ cart.product.dimension }}
                                    </p>
                                </span>
                                <div class="text-right w-full md:w-auto">
                                    <p
                                        class="flex mb-2 items-center justify-end"
                                    >
                                        <span
                                            class="mr-3 cursor-pointer"
                                            v-if="
                                                cart.product.type ==
                                                    'negotiable' &&
                                                cart.offer.result == 'failed'
                                            "
                                            @click="reapply(cart)"
                                            >Re-apply</span
                                        >
                                        <TrashIcon
                                            @click="removefromcart(cart.id)"
                                            class="w-4 h-4 ml-1 text-red-500 cursor-pointer"
                                        />
                                    </p>
                                    <div
                                        class="text-slate-400 p-1 border flex bg-gray-50 text-xs justify-center rounded-sm"
                                    >
                                        <span class="mr-1 text-xs">{{
                                            moment(cart.offer.start).format(
                                                "MMM DD, yyyy"
                                            )
                                        }}</span>
                                        <span class="mx-1">-</span>
                                        <span class="text-xs">{{
                                            moment(cart.offer.end).format(
                                                "MMM DD, yyyy"
                                            )
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-16" v-if="!carts.length">
                        <span class="px-6 py-3 bg-blue-50 rounded">
                            Your cart is empty</span
                        >
                    </div>
                </div>
                <div class="">
                    <div class="bg-gray-50 rounded-lg py-8">
                        <div class="p-5">
                            <h6 class="font-black">Order Summary</h6>
                            <small
                                >{{ carts.length }} Ad location reserved for
                                {{ totaldays }} days</small
                            >
                        </div>
                        <hr />

                        <div class="p-5">
                            <p class="flex justify-between mb-2">
                                <span class="text-sm">Sub total</span>
                                <span class="font-bold">{{
                                    currency(total + pendingtotal)
                                }}</span>
                            </p>
                            <p
                                class="flex justify-between mb-2 text-sm text-slate-400"
                            >
                                <span> Pending offers</span>
                                <span class="font-bold text-yellow-500"
                                    >-{{ currency(pendingtotal) }}</span
                                >
                            </p>
                            <!-- <p class="flex justify-between mb-4">
                                <span class="text-sm">Total impressions</span>
                                <span class="font-bold">{{
                                    totalimpressions.toLocaleString("en-US")
                                }}</span>
                            </p> -->
                            <p class="flex justify-between mb-2">
                                <span class="text-sm">Discount</span>
                                <span class="font-bold">{{ currency(0) }}</span>
                            </p>
                            <p class="flex justify-between mb-3">
                                <span class="text-sm">Coupon applied</span>
                                <span class="font-bold">{{ currency(0) }}</span>
                            </p>
                        </div>
                        <hr />
                        <div class="p-5">
                            <p class="flex justify-between mb-1">
                                <span> Total</span>
                                <span
                                    class="font-bold text-xl text-orange-500"
                                    >{{ currency(total) }}</span
                                >
                            </p>

                            <input
                                placeholder="Enter coupon code"
                                class="px-4 py-2 rounded border w-full"
                            />
                        </div>
                        <div class="text-center mt-3 px-5" v-if="pendingtotal">
                            <p
                                class="text-white text-sm flex items-center bg-red-600 p-2 rounded-sm"
                            >
                                You still have pending offers, wait till
                                confirmation or remove them to proceed
                            </p>
                        </div>
                        <!-- <div class="p-5">
                            <Paybtn
                                :disabled="pendingtotal"
                                :amount="total"
                                :email="$page.props.auth.user.email"
                            />
                        </div> -->
                        <div v-if="!pendingtotal" class="p-5 border-t">
                          <h5>Bank Transfer</h5>
                          <p>Bank name : Providus Bank</p>
                            <p>Account name : Adspots Digital Solutions</p>
                              <p>Account number : 5400987429</p>
                              <p class="text-xs text-blue-800 p-2 rounded  bg-blue-50  mt-3">After making payment, send your proof of payment to our email address with your full details</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="/images/orb.png" class="absolute top-10 left-0" />
        <img
            src="/images/orb.png"
            class="absolute bottom-0 right-0 rotate-45"
        />
    </div>
    <TransitionRoot as="template" :show="open">
        <Dialog
            as="div"
            class="fixed z-10 inset-0 overflow-y-auto"
            @close="open = false"
        >
            <div
                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
            >
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay
                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span
                    class="hidden sm:inline-block sm:align-middle sm:h-screen"
                    aria-hidden="true"
                    >&#8203;</span
                >
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-[80%] sm:w-full"
                    >
                        <div class="">
                            <Product
                                @toggleModal="toggleModal"
                                :product="details"
                                :cart="carts"
                            />
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
<script>
import { TrashIcon, InformationCircleIcon } from "@heroicons/vue/outline";
import moment from "moment";
import axios from "axios";
import Product from "./product";
import Paybtn from "@/Components/Paystack";
import { ref } from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";

export default {
  components: {
    TrashIcon,
    Paybtn,
    InformationCircleIcon,
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    Product,
  },
  inject: ["emitter", "currency"],
  data() {
    return {
      carts: [],
      details: {},
    };
  },
  setup() {
    const open = ref(false);

    return {
      moment,
      open,
    };
  },
  mounted() {
    this.getcart();
    this.emitter.on("addtocart", () => {
      this.getcart();
    });
    //  this.emitter.on("clearcart", () => {
    //   this.carts=[];
    // });
  },
  computed: {
    total() {
      if (!this.carts.length) return 0;
      return this.carts
        .filter((item) => item.offer.result == "success")
        .map((item) => parseInt(item.price))
        .reduce((a, b) => {
          return a + b;
        }, 0);
    },
    pendingtotal() {
      if (!this.carts.length) return 0;
      return this.carts
        .filter(
          (item) =>
            item.offer &&
            item.offer.result !== "success" &&
            item.type == "negotiable"
        )
        .map((item) => parseInt(item.price))
        .reduce((a, b) => {
          return a + b;
        }, 0);
    },
    totaldays() {
      if (!this.carts.length) return 0;
      return this.carts
        .map((item) => parseInt(item.duration))
        .reduce((a, b) => {
          return a + b;
        }, 0);
    },
    totalimpressions() {
      if (!this.carts.length) return 0;
      return this.carts
        .map((item) => parseInt(item.product.impressions))
        .reduce((a, b) => a + b);
    },
  },
  methods: {
    resetcart() {
      this.carts = [];
    },
    reapply(item) {
      this.details = item.product;
      this.details.offer = item.offer;
      this.open = !this.open;
    },
    toggleModal() {
      this.open = !this.open;
    },
    getcart() {
      //  this.cartItems = JSON.parse(localStorage.getItem("cartItems"));
      axios.get("/getfullcart").then((res) => {
        this.carts = res.data;
      });
    },
    removefromcart(id) {
      let confirm = window.confirm("Are you sure?");
      if (confirm) {
        axios.delete(`/remove/cart/${id}`).then((res) => {
          if (res.status === 200) {
            this.emitter.emit("addtocart");
            this.carts = this.carts.slice().filter((item) => item.id != id);
          }
        });
      }
    },
  },
};
</script>
<style lang=""></style>

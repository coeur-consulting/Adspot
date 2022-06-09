<template lang="">
    <section
        id="Popular"
        class="relative bg-gray-50 z-[1] px-3 xl:px-0"
        v-if="products.length"
    >
        <div class="container mx-auto py-40 md:py-44">
            <div class="mb-5 flex justify-between">
                <h6 class="font-bolder">Most Popular Adspot</h6>
                <span
                    class="w-[140px] md:w-[200px] flex justify-end items-center"
                >
                    <span class="text-xs text-orange-500 mr-4 cursor-pointer"
                        >View all</span
                    >
                    <span class="flex">
                        <span
                            class="bg-white p-1 mr-2 rounded-full cursor-pointer"
                            @click="goto('prev')"
                            ><ChevronLeftIcon class="w-4 h-4 cursor-pointer"
                        /></span>
                        <span
                            class="bg-white p-1 rounded-full cursor-pointer"
                            @click="goto('next')"
                            ><ChevronRightIcon class="w-4 h-4" /></span
                    ></span>
                </span>
            </div>
            <carousel
                :breakpoints="breakpoints"
                :wrap-around="true"
                :pauseAutoplayOnHover="true"
                :items-to-show="1.2"
                :autoplay="5000"
                :loop="true"
                ref="slider"
                class="h-full w-full z-10"
            >
                <slide
                    v-for="(item, index) in products"
                    :key="index"
                    class="p-4"
                >
                    <div
                        class="bg-white rounded-lg shadow w-full overflow-hidden z-10"
                    >
                        <div>
                            <img
                                class="w-full h-full object-center object-cover h-[200px]"
                                :src="
                                    item.media
                                        ? item.media[0]
                                        : '/images/banner.png'
                                "
                            />
                        </div>
                        <div class="p-4 text-left">
                            <p class="text-base">
                                {{ item.name }}
                            </p>
                            <p class="font-bold text-xl">
                                {{ currency(item.price) }}
                                <span class="text-xs"
                                    >/ {{ item.duration }} days</span
                                >
                            </p>
                            <!--
//  <p  class="text-sm truncate text-ellipsis overflow-hidden ...">
//             <span>Duration</span> : <span class="text-slate-400 capitalize">{{item.duration_type}}</span>
//           </p> -->
                            <p
                                class="text-sm truncate text-ellipsis overflow-hidden ..."
                            >
                                <span>Ad type</span> :
                                <span class="text-slate-400 capitalize">{{
                                    item.category.name
                                }}</span>
                            </p>
                            <p
                                class="text-sm truncate text-ellipsis overflow-hidden ..."
                            >
                                <span>Location</span> :
                                <span class="text-slate-400">
                                    {{ item.location }}</span
                                >
                            </p>
                            <p
                                class="text-sm truncate text-ellipsis overflow-hidden ..."
                            >
                                <span>Specification</span> :
                                <span class="text-slate-400">{{
                                    item.dimension
                                }}</span>
                            </p>
                            <p
                                class="text-sm truncate text-ellipsis overflow-hidden ..."
                            >
                                <span>Type</span> :
                                <span class="text-slate-400 capitalize">{{
                                    item.type
                                }}</span>
                            </p>
                            <div
                                class="flex flex-col md:flex-row mt-5 justify-between"
                            >
                                <button
                                    @click="toggleModal(item)"
                                    class="inline whitespace-nowrap inline-flex items-center justify-center px-3 py-2 border border-orange-500 rounded-full shadow-sm text-xs text-orange-500 font-bold text-white bg-white hover:bg-orange-500 hover:text-white mb-4 md:mb-0"
                                >
                                    More details
                                </button>
                                <AddToCart :product="item" :cart="cart" />
                            </div>
                        </div>
                    </div>
                </slide>

                <template #addons="{ currentSlide }">
                    <span class="hidden">{{ (index = currentSlide) }}</span>
                </template>
            </carousel>
        </div>
        <span class="absolute top-[2%] left-[-4%] z-[1] rotate-45"
            ><img src="/images/spiral.png" class="w-[100%]"
        /></span>
    </section>
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
                                :product="product"
                                :cart="cart"
                            />
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
<script>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/solid";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide } from "vue3-carousel";
import axios from "axios";
import AddToCart from "@/Components/AddToCart";
import Product from "@/MarketPlace/Components/product";
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
export default {
    components: {
        Carousel,
        Slide,
        ChevronLeftIcon,
        ChevronRightIcon,
        AddToCart,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        Product,
    },
    data() {
        return {
            products: [],
            product: {},
            cart: [],
            open: false,
            index: 0,
            breakpoints: {
                // 700px and up
                700: {
                    itemsToShow: 2.3,
                    snapAlign: "center",
                },
                // 1024 and up
                1024: {
                    itemsToShow: 3.3,
                    snapAlign: "start",
                },
            },
        };
    },
    inject: ["emitter", "currency"],
    mounted() {
        this.getproducts();
        this.emitter.on("getcart", (data) => {
            this.cart = data;
        });
    },
    methods: {
        goto(n) {
            n === "next" ? this.$refs.slider.next() : this.$refs.slider.prev();
        },
        getproducts() {
            axios.get("/featured-products").then((res) => {
                if (res.status === 200) {
                    this.products = res.data;
                }
            });
        },
        toggleModal(data) {
            this.product = data;
            this.open = !this.open;
        },
    },
};
</script>
<style lang=""></style>

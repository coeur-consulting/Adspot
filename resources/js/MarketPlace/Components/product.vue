<template>
    <div
        class="bg-white h-full relative px-3 py-4 md:px-0 md:py-0"
        v-if="product"
    >
        <div
            class="h-[200px] md:h-[450px] product_image"
            :style="`background-image:url(${
                product.media.length ? product.media[0] : '/images/banner.png'
            })`"
        ></div>
        <div class="w-full md:w-4/6 mr-auto px-5 py-10">
            <div class="mr-5 flex flex-col md:flex-row justify-between">
                <div class="mb-4 w-full md:w-[73%]">
                    <div class="flex mr-5 mb-5 items-center">
                        <h4 class="mr-5 font-extrabold text-xl">
                            {{ product.name }}
                        </h4>
                    </div>
                    <p>
                        {{ product.description }}
                    </p>
                </div>
                <!-- <div class="map bg-blue-100 p-10 rounded-lg w-full md:w-[25%] mb-12">
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
        </div> -->
            </div>
            <hr />
            <div class="py-5 mt-6">
                <div class="flex items-center mb-5">
                    <span class="text-base" :class="dateType=='custom' ? 'text-gray-400' : 'text-gray-800'">Date Range</span>
                    <Switch
                        v-model="enabled"
                        class="bg-orange-700 relative inline-flex h-6 w-11 items-center rounded-full mx-4"
                    >
                        <span
                            :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                            class="inline-block h-4 w-4 transform rounded-full bg-white"
                        />
                    </Switch>
                    <span class="text-base"  :class="dateType=='range' ? 'text-gray-400' : 'text-gray-800'">Custom Date</span>
                </div>
                <v-date-picker
                    v-if="dateType == 'range'"
                    color="orange"
                    mode="date"
                    v-model="range"
                    :columns="$screens({ default: 1, lg: 2 })"
                    is-range
                    is-expanded
                    :modelConfig="modelConfig"
                    :min-date="new Date()"
                />
                <v-calendar
                    v-if="dateType == 'custom'"
                    color="orange"
                    :columns="$screens({ default: 1, lg: 2 })"
                    :min-date="new Date()"
                    mode="date"
                    :attributes="attributes"
                    @dayclick="onDayClick"
                    is-expanded
                />
            </div>
        </div>

        <div
            class="w-[100%] mx-auto md:w-[350px] md:fixed md:right-8 md:top-[25%] z-40"
        >
            <div
                class="bg-white md:shadow-lg px-5 py-8 text-left rounded-lg mb-8"
            >
                <p class="mb-1 font-bold text-3xl text-black">
                    {{ currency(product.price) }}
                    <span class="text-xs">/ days</span>
                </p>
                <!-- <p class="mb-1 text-base">
                    <span class="text-black">Duration </span> :
                    <span class="text-slate-600 capitalize">{{
                        product.duration_type
                    }}</span>
                </p> -->
                <p class="mb-1 text-base">
                    <span class="text-black">Category</span> :
                    <span
                        class="text-slate-600 capitalize"
                        v-if="product.category"
                        >{{ product.category.name }}</span
                    >
                </p>
                <p class="mb-1 text-base">
                    <span class="text-black">Ad type</span> :
                    <span
                        class="text-slate-600 capitalize"
                        v-if="product.subcategory"
                        >{{ product.subcategory.name }}</span
                    >
                </p>
                <p class="mb-1 text-base leading-snug">
                    <span class="text-black">Location</span> :
                    <span class="text-slate-600">
                        {{ product.location ? product.location : "N/A" }}</span
                    >
                </p>
                <p class="mb-2 text-base">
                    <span class="text-black">Specification</span> :
                    <span class="text-slate-600">{{
                        product.dimension ? product.dimension : "N/A"
                    }}</span>
                </p>
                <p class="mb-1 text-base">
                    <span class="text-black">Type</span> :
                    <span class="text-slate-600 capitalize">{{
                        product.type
                    }}</span>
                </p>

                <div v-if="dateType == 'range'">
                    <div
                        v-if="range.start && range.end"
                        class="my-6 border bg-gray-50 rounded-lg grid grid-cols-2 gap-6 p-4"
                    >
                        <div>
                            <p class="text-xs text-slate-600">Start Date</p>
                            <p class="font-bold text-sm">
                                {{ moment(range.start).format("MMM DD, yyyy") }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-slate-600">End Date</p>
                            <p class="font-bold text-sm">
                                {{ moment(range.end).format("MMM DD, yyyy") }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="my-6 border bg-gray-50 rounded-lg p-6 text-center"
                        v-else
                    >
                        <span>Select a date</span>
                    </div>
                </div>
                <div class="my-3">
                    <div
                        class="flex shadow-sm rounded overflow-hidden border border-gray-300"
                    >
                        <div
                            class="bg-slate-100 px-3 py-1 flex-none text-xs flex items-center"
                        >
                            NGN
                        </div>
                        <div class="grow">
                            <input
                                class="w-full h-full px-3 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="negotiation"
                                type="number"
                                placeholder="Negotiate price"
                            />
                        </div>
                    </div>
                </div>
                <div class="my-3 text-center">
                    <span class="text-base font-bold mx-auto text-orange-500">
                        <span class="text-orange-500">{{
                            currency(negotiation)
                        }}</span>
                        x
                        <span class="text-orange-500"
                            >{{ adDuration }} days</span
                        ></span
                    >
                </div>
                <div class="mt-4 text-center">
                    <AddToCart
                        class="w-full text-base mb-4"
                        :days="dates"
                        :product="product"
                        :negotiation="parseInt(negotiation)"
                        :duration="parseInt(adDuration)"
                        :cart="cart"
                        :start="range.start"
                        :end="range.end"
                        :cartId="product.offer ? product.offer.cart_id : null"
                        :dateType="dateType"
                    />
                     <p class=" text-gray-700 font-semibold text-lg hover:text-orange-700"
                        ><a target="_blank" href="https://wa.me/+2348050692036"
                            >Negotiate</a
                        ></p
                    >
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-5">
                <h5 class="font-bold mb-2 text-black">For Enquiries</h5>
                <p class="text-sm">
                    <span class="">Email</span> :
                    <span class=""
                        ><a target="_blank" href="mailto:hello@adspots.ng"
                            >hello@adspots.ng</a
                        ></span
                    >
                </p>
                <p class="text-sm">
                    <span class="">Call Phone</span> :
                    <span class=""
                        ><a href="tel:2348050692036">+2348050692036</a></span
                    >
                </p>
                <p class="text-sm">
                    <span class="">Whatsapp</span> :
                    <span class=""
                        ><a target="_blank" href="https://wa.me/+2348050692036"
                            >+2348050692036</a
                        ></span
                    >
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
import { ref, computed, reactive, toRefs, watch } from "vue";
import { XCircleIcon } from "@heroicons/vue/solid";
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { ShoppingCartIcon } from "@heroicons/vue/solid";
import moment from "moment";
import "v-calendar/dist/style.css";
import AddToCart from "@/Components/AddToCart";
import { Switch } from "@headlessui/vue";

export default {
    inject: ["currency", "emitter"],
    props: ["product", "cart"],
    components: {
        Switch,
        RadioGroup,
        RadioGroupLabel,
        RadioGroupOption,
        XCircleIcon,
        ShoppingCartIcon,
        AddToCart,
    },
    setup(props, context) {
        const { product } = toRefs(props);
        const negotiation = ref(product.price);
        const enabled = ref(null);
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
        const dateType = ref("range");
        const toggleModal = (data) => {
            context.emit("toggleModal", data);
        };
        watch(enabled, () => {
            !enabled.value
                ? (dateType.value = "range")
                : (dateType.value = "custom");
        });
        return {
            modelConfig,
            center,
            markers,
            toggleModal,
            product,
            moment,
            negotiation,
            enabled,
            dateType,
        };
    },
    data() {
        return {
            date: new Date(),

            range: {
                start: null,
                end: null,
            },
            days: [],
        };
    },
    mounted() {
        this.setnegotiation();
        // this.range.start = this.product.start_time;
        // this.range.end = this.product.end_time;
    },
    watch: {
        flexiblePrice: "setnegotiation",
    },
    computed: {
        dates() {
            return this.days.map((day) => day.date);
        },
        attributes() {
            return this.dates.map((date) => ({
                highlight: true,
                dates: date,
                color: "orange",
            }));
        },
        flexiblePrice() {
            // if (this.product.duration_type == "fixed")
            //     return this.product.price;
            // if (!this.range.start && !this.range.end) return this.product.price;
            // let days = moment(this.range.end).diff(
            //     moment(this.range.start),
            //     "days"
            // );
            // let perDayPrice =
            //     parseInt(this.product.price) / parseInt(this.product.duration);
            // return parseInt(perDayPrice) * parseInt(days);
            return this.product.price * this.adDuration;
        },
        adDuration() {
            if (this.dateType == "range") {
                if (!this.range.start && !this.range.end) return 1;
                return Number(
                    moment(this.range.end).diff(
                        moment(this.range.start),
                        "days"
                    )
                );
            } else {
                return this.days.length;
            }
        },
    },

    methods: {
        onDayClick(day) {
            const idx = this.days.findIndex((d) => d.id === day.id);
            if (idx >= 0) {
                this.days.splice(idx, 1);
            } else {
                this.days.push({
                    id: day.id,
                    date: day.date,
                });
            }
        },
        setnegotiation() {
            this.negotiation = this.flexiblePrice;
            if (this.product.duration_type == "fixed") {
                this.range.start = this.product.start_time;
                this.range.end = this.product.end_time;
            }
        },
        addtocart(product) {
            product.days = this.days;
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

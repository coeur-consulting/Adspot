<template>
    <div
        v-if="!isLoading"
        class="bg-gray-100 p-1 w-2/4 mx-auto mt-20 text-center rounded-sm"
    >
        Loading products..
    </div>
    <div class="bg-transparent container mx-auto" v-if="isLoading">
        <div
            v-if="products.length"
            class="grid gap-8 p-5"
            :class="
                viewType == 'grid'
                    ? 'grid-cols-1 sm:grid-cols-3 md:grid-cols-4'
                    : 'grid-cols-1'
            "
        >
            <div
                class="bg-white rounded-lg shadow w-full overflow-hidden z-10"
                :class="viewType == 'grid' ? '' : 'md:flex'"
                v-for="(item, index) in products"
                :key="index"
            >
                <div :class="viewType == 'grid' ? 'w-full' : 'md:w-[40%]'">
                    <img
                        class="w-full h-full object-center object-cover h-[200px]"
                        :src="
                            item.media.length
                                ? item.media[0]
                                : '/images/banner.png'
                        "
                    />
                </div>
                <div
                    :class="
                        viewType == 'grid'
                            ? 'flex justify-between flex-col'
                            : 'md:w-[60%]'
                    "
                >
                    <div class="p-4 text-left">
                        <p
                            class="text-base"
                            :class="viewType == 'grid' ? '' : 'line-clamp-2'"
                        >
                            {{ item.name }}
                        </p>
                        <p class="font-bold text-xl">
                            {{ currency(item.price) }}
                            <span class="text-xs">/ day</span>
                        </p>
                        <p
                            v-if="item.category"
                            :class="
                                viewType == 'grid'
                                    ? 'text-sm truncate text-ellipsis overflow-hidden ...'
                                    : ''
                            "
                        >
                            <span class="">Category</span> :
                            <span class="text-slate-600 capitalize">{{
                                item.category.name
                            }}</span>
                        </p>
                        <p
                            :class="
                                viewType == 'grid'
                                    ? 'text-sm truncate text-ellipsis overflow-hidden ...'
                                    : ''
                            "
                        >
                            <span>Ad type</span> :
                            <span
                                v-if="item.subcategory"
                                class="text-slate-600 capitalize"
                                >{{ item.subcategory.name }}</span
                            >
                            <span v-else class="text-slate-600 capitalize"
                                >N/a</span
                            >
                        </p>
                        <p
                            :class="
                                viewType == 'grid'
                                    ? 'text-sm truncate text-ellipsis overflow-hidden ...'
                                    : ''
                            "
                        >
                            <span>Location</span> :
                            <span class="text-slate-600">
                                {{
                                    item.location ? item.location : "N/A"
                                }}</span
                            >
                        </p>
                        <!-- <p
                        :class="
                            viewType == 'grid'
                                ? 'text-sm truncate text-ellipsis overflow-hidden ...'
                                : ''
                        "
                    >
                        <span>Specification</span> :
                        <span class="text-slate-600">{{
                            item.dimension ? item.dimension : "N/A"
                        }}</span>
                    </p> -->
                        <!-- <p
                        :class="
                            viewType == 'grid'
                                ? 'text-sm truncate text-ellipsis overflow-hidden ...'
                                : ''
                        "
                    >
                        <span>Type</span> :
                        <span class="text-slate-600 capitalize">{{
                            item.type
                        }}</span>
                    </p> -->
                    </div>
                    <div
                        class="flex flex-col md:flex-row px-4 pb-4 mt-4"
                        :class="
                            viewType == 'grid'
                                ? ' justify-between'
                                : ' justify-end'
                        "
                    >
                        <button
                            @click="toggleModal(item)"
                            class="whitespace-nowrap inline-flex items-center justify-center px-3 py-2 border border-orange-500 rounded-full shadow-sm text-xs text-orange-500 font-bold bg-white hover:bg-orange-500 hover:text-white mb-4 md:mb-0"
                            :class="
                                viewType == 'grid' ? ' w-full mr-4' : 'mr-3'
                            "
                        >
                            More details
                        </button>
                        <a
                            target="_blank"
                            :class="viewType == 'grid' ? 'w-full' : ''"
                            :href="`https://wa.me/+2348050692036?text=${item.name}`"
                        >
                            <button
                                class="whitespace-nowrap inline-flex items-center justify-center px-3 py-2 border border-orange-300 rounded-full shadow-sm text-xs text-white font-bold bg-orange-500 hover:bg-orange-500 mb-4 md:mb-0"
                                :class="viewType == 'grid' ? ' w-full ' : ''"
                            >
                                Negotiate
                            </button>
                        </a>

                        <!-- <button
                            v-if="
                                item.type == 'negotiable' ||
                                item.duration_type == 'flexible'
                            "
                            @click="toggleModal(item)"
                            class=" whitespace-nowrap inline-flex items-center justify-center px-3 py-2 border rounded-full shadow-base text-white font-bold text-white hover:bg-orange-300 text-xs"
                            :class="
                                incart(item.id)
                                    ? 'bg-gray-300 border-gray-100'
                                    : 'bg-orange-500 border-orange-500'
                            "
                            :disabled="incart(item.id)"
                        >
                            {{
                                incart(item.id) ? "Added to cart" : "Negotiate"
                            }}
                        </button> -->
                    </div>
                </div>
            </div>
        </div>

        <div
            class="pagination flex justify-between text-center mt-8 px-3"
            v-if="products.length"
        >
            <div>
                <p class="text-sm text-gray-500 mb-0">
                    Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }}
                </p>
            </div>
            <span class="flex justify-center items-center">
                <span
                    ><ArrowCircleLeftIcon
                        :class="
                            links.prev
                                ? 'text-orange-700'
                                : 'opacity-55 text-slate-300'
                        "
                        @click="prev"
                        class="cursor-pointer w-8 h-8 mr-2"
                /></span>
                <input
                    class="form-input w-8 h-8 text-sm text-center border rounded-full border-orange-700"
                    :disabled="!links.next"
                    v-model="current_page" />
                <span class="font-bold ml-2 text-sm"
                    >of {{ meta.last_page }}</span
                >
                <span
                    ><ArrowCircleRightIcon
                        :class="
                            links.next
                                ? 'text-orange-700'
                                : 'opacity-55 text-slate-300'
                        "
                        @click="next"
                        class="w-8 h-8 ml-2 cursor-pointer" /></span
            ></span>
        </div>

        <div
            v-if="!products.length"
            class="bg-gray-100 p-2 text-center mt-10 md:w-2/4 mx-auto"
        >
            OOPS!, No data available
        </div>
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
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { Link } from "@inertiajs/inertia-vue3";
import {
    ShoppingCartIcon,
    ArrowCircleLeftIcon,
    ArrowCircleRightIcon,
} from "@heroicons/vue/solid";
import {
    SortAscendingIcon,
    SortDescendingIcon,
    SearchIcon,
} from "@heroicons/vue/solid";
import axios from "axios";
import _ from "lodash";
import { ref, onMounted, computed, watch, inject, reactive } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import Product from "./product";
import AddToCart from "@/Components/AddToCart";
import moment from "moment";
export default {
    components: {
        ShoppingCartIcon,
        ArrowCircleLeftIcon,
        ArrowCircleRightIcon,
        SortAscendingIcon,
        SortDescendingIcon,
        SearchIcon,
        Link,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        Product,
        AddToCart,
    },
    data() {
        return {
            search: "",
            rate: null,
        };
    },

    setup() {
        const open = ref(false);
        const emitter = inject("emitter");
        const currency = inject("currency");
        const products = ref([]);
        const current_page = ref(1);
        const last_page = ref(1);
        const query = ref("");
        const filterData = ref({});
        const viewType = ref("grid");
        const category_id = ref(0);
        const product = ref(null);
        const cart = ref([]);
        const meta = ref({});
        const links = ref({});
        const isLoading = ref(false);
        onMounted(() => {
            const urlParams = new URLSearchParams(window.location.search);
            let subcategory = urlParams.get("subcategory");
            let location = urlParams.get("location");
            let start = urlParams.get("start");
            let end = urlParams.get("end");

            if (urlParams.has("category") && !subcategory) {
                if (urlParams.get("category") == 0) {
                    loadProducts();
                } else {
                    loadProductsByCategory(urlParams.get("category"));
                }
            } else {
                if (subcategory || location || (start && end)) {
                    loadSearchResult(subcategory, location, start, end);
                } else {
                    loadProducts();
                }
            }

            emitter.on("reset", () => {
                loadProducts();
            });
            emitter.on("getCategory", (data) => {
                if (data == 0) {
                    loadProducts();
                } else {
                    loadProductsByCategory(data);
                }
            });
        });
        function loadProducts() {
            isLoading.value = false;
            axios.get(`get-products?page=${current_page}`).then((res) => {
                if (res.status === 200) {
                    products.value = res.data.data;
                    last_page.value = res.data.last_page;
                    meta.value = res.data.meta;
                    links.value = res.data.links;
                    isLoading.value = true;
                }
            });
        }
        function loadProductsByCategory(id) {
            isLoading.value = false;
            axios.get(`get-products-category/${id}`).then((res) => {
                if (res.status === 200) {
                    products.value = res.data.data;
                    last_page.value = res.data.last_page;
                    meta.value = res.data.meta;
                    links.value = res.data.links;
                    isLoading.value = true;
                }
            });
        }
        function loadSearchResult(subcategory, location, start, end) {
            filterData.subcategory_id = subcategory;
            filterData.location = location;
            filterData.datevalue = [
                moment(new Date(start)),
                moment(new Date(end)),
            ];
            filterData.typeFilter = ["negotiable", "non-negotiable"];
            filterData.durationFilter = ["fixed", "flexible"];

            searchInventory();
        }

        emitter.on("getCategory", (data) => {
            category_id.value = data;
        });
        emitter.on("getcart", (data) => {
            cart.value = data;
        });
        emitter.on("filterData", (data) => {
            filterData.category_id = data.category_id;
            filterData.subcategory_id = data.subcategory_id;
            filterData.location = data.location;
            filterData.datevalue = data.datevalue;
            filterData.typeFilter = data.typeFilter;
            filterData.durationFilter = data.durationFilter;
            searchInventory();
        });
        emitter.on("toggleView", (data) => {
            viewType.value = data;
        });
        function searchInventory() {
            isLoading.value = false;
            axios
                .post("/search-inventory", filterData)
                .then((res) => {
                    if (res.status === 200) {
                        products.value = res.data.data;
                        last_page.value = res.data.last_page;
                        meta.value = res.data.meta;
                        links.value = res.data.links;
                        isLoading.value = true;
                    }
                })
                .catch(() => {
                    isLoading.value = false;
                });
        }
        const incart = (id) => {
            if (!cart.value.length) return false;
            let result = cart.value.some(
                (item) =>
                    item.product_id == id &&
                    ((item.status == "pending" && item.type == "negotiable") ||
                        (item.status == "success" &&
                            item.type == "non-negotiable"))
            );

            return result;
        };

        function next() {
            if (!links.value.next) return;

            current_page.value++;
        }
        function prev() {
            if (!links.value.prev) return;
            current_page.value--;
        }

        function searchproducts() {
            isLoading.value = false;
            axios
                .get(`searchproducts?query=${query.value}`)
                .then((res) => {
                    if (res.status === 200) {
                        products.value = res.data.data;
                        last_page.value = res.data.last_page;
                        meta.value = res.data.meta;
                        links.value = res.data.links;
                        isLoading.value = true;
                    }
                })
                .catch(() => {
                    isLoading.value = false;
                });
        }
        function getproducts(page) {
            isLoading.value = false;
            axios
                .get(`get-products?page=${page}`)
                .then((res) => {
                    if (res.status === 200) {
                        products.value = res.data.data;
                        last_page.value = res.data.last_page;
                        meta.value = res.data.meta;
                        links.value = res.data.links;
                        isLoading.value = true;
                    }
                })
                .catch(() => {
                    isLoading.value = false;
                });
        }

        const subcategories = computed(() => {
            let subcat = usePage().props.value.subcategories;
            return !category_id.value
                ? subcat
                : subcat.filter(
                      (item) => item.category_id == category_id.value
                  );
        });

        function toggleModal(data) {
            if (data) {
                product.value = data;
            }

            open.value = !open.value;
        }

        watch(current_page, (current_page, prevCurrent_page) => {
            getproducts(current_page);
        });
        watch(query, (query, prevQuery) => {
            if (query === "") {
                getproducts(1);
            }
        });

        return {
            cart,
            products,
            last_page,
            next,
            prev,
            query,
            current_page,
            searchproducts,
            category_id,
            subcategories,
            filterData,
            viewType,
            toggleModal,
            product,
            open,
            currency,
            incart,
            meta,
            links,
            isLoading,
        };
    },
    methods: {
        addtocart(product) {
            this.emitter.emit("addtocart", product);
            this.cartItems = JSON.parse(localStorage.getItem("cartItems"));
        },
        inCart(id) {
            let result = this.cart.some(
                (item) =>
                    item.id == id &&
                    ((item.status == "pending" && item.type == "negotiable") ||
                        (item.status == "success" &&
                            item.type == "non-negotiable"))
            );

            return result;
        },
    },
};
</script>

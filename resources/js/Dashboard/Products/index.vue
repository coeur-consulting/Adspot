<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="mb-5">
        <ul class="breadcrumb text-xs">
            <li><a href="/dashboard">Dashboard</a></li>
            <li>Products</li>
        </ul>
    </div>
    <div class="flex justify-end mb-6">
        <div class="flex justify-between mb-3 w-full">
            <div class="flex items-center">
                <input
                    placeholder="Search name"
                    v-model="query"
                    type="search"
                    class="py-2 px-4 border border-gray-50 rounded-lg md:w-[250px] mr-4 shadow-sm"
                />
                <div class="mr-5 flex items-center">
                    <input
                        id="all"
                        class="mr-2"
                        v-model="showing"
                        value=""
                        type="radio"
                    />
                    <BreezeLabel for="all" value="All" />
                </div>
                <div class="mr-5 flex items-center">
                    <input
                        id="active"
                        class="mr-2"
                        v-model="showing"
                        value="active"
                        type="radio"
                    />
                    <BreezeLabel for="active" value="Active" />
                </div>
                <div class="flex items-center">
                    <input
                        id="inactive"
                        class="mr-2"
                        v-model="showing"
                        value="inactive"
                        type="radio"
                    />
                    <BreezeLabel for="inactive" value="Inactive" />
                </div>
            </div>
            <div>
                <button
                    @click="toggleModal('create')"
                    type="button"
                    class="font-bold px-4 py-2 text-sm whitespace-nowrap relative cursor-pointer border border-transparent rounded-md shadow-sm bg-orange-500 hover:bg-orange-500 flex justify-between"
                >
                    <PlusCircleIcon class="w-4 h-4 mr-1 text-white" />
                    <span class="text-white">Add product</span>
                </button>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                class="py-2 align-middle inline-block min-w-full sm:px-3 lg:px-8"
            >
                <div
                    class="shadow border-b border-gray-200 sm:rounded-lg bg-white pb-8"
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    S/N
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Name
                                </th>

                                <!-- <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Type
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Duration
                                </th> -->
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Price
                                </th>

                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Status
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Toggle
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Offers
                                </th>

                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    <span class="">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="(product, index) in filteredProducts"
                                :key="product.id"
                            >
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ index + 1 }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-6 w-6"
                                            v-if="product.media"
                                        >
                                            <img
                                                class="h-6 w-6 rounded-full"
                                                :src="
                                                    product.media.length
                                                        ? product.media[0]
                                                        : '/images/banner.png'
                                                "
                                                alt=""
                                            />
                                        </div>
                                        <div class="ml-2">
                                            <div
                                                class="text-sm font-medium text-gray-900 truncate overflow-hidden ..."
                                            >
                                                {{ product.name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- <td class="px-3 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-500 capitalize"
                                    >
                                        {{ product.type }}
                                    </span>
                                </td>
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    <span
                                        class="flex p-1 border justify-between text-xs rounded"
                                    >
                                        <span>{{
                                            moment(product.start_time).format(
                                                "MMM DD, yyyy"
                                            )
                                        }}</span>
                                        <span class="mx-1">-</span>
                                        <span>{{
                                            moment(product.end_time).format(
                                                "MMM DD, yyyy"
                                            )
                                        }}</span>
                                    </span>
                                </td> -->
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ currency(product.price) }}
                                </td>

                                <td
                                    class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    <span
                                        class="py-1 px-2 text-xs rounded-full"
                                        :class="
                                            !product.status
                                                ? 'bg-red-100 text-red-500'
                                                : 'bg-green-100 text-green-500'
                                        "
                                    >
                                        {{
                                            !product.status
                                                ? "Inactive"
                                                : "Active"
                                        }}</span
                                    >
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex justify-center ml-4">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm"
                                                @change="
                                                    updatestatus(
                                                        product.id,
                                                        !product.status
                                                    )
                                                "
                                                :checked="product.status"
                                                type="checkbox"
                                                role="switch"
                                                id="flexSwitchCheckDefault"
                                            />
                                            <!-- <label
                        class="form-check-label inline-block text-gray-800"
                        for="flexSwitchCheckDefault"
                        >Default switch checkbox input</label
                      > -->
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div
                                        class="text-sm text-gray-900 text-ellipsis overflow-hidden ..."
                                    >
                                        {{ product.offers }}
                                    </div>
                                </td>

                                <td
                                    class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium flex"
                                >
                                    <div
                                        class="text-sm mr-8 cursor-pointer"
                                        :class="
                                            product.status
                                                ? 'text-gray-900'
                                                : 'text-gray-300'
                                        "
                                    >
                                        <span
                                            @click="viewoffers(product.id)"
                                            class="hover:text-orange-900"
                                            >View offers</span
                                        >
                                    </div>

                                    <Popover class="relative">
                                        <PopoverButton>
                                            <span class="sr-only">
                                                Actions</span
                                            >
                                            <span class="relative">
                                                <DotsVerticalIcon
                                                    class="h-4 w-4"
                                                    aria-hidden="true"
                                                />
                                            </span>
                                        </PopoverButton>

                                        <transition
                                            enter-active-class="transition duration-200 ease-out"
                                            enter-from-class="translate-y-1 opacity-0"
                                            enter-to-class="translate-y-0 opacity-100"
                                            leave-active-class="transition duration-150 ease-in"
                                            leave-from-class="translate-y-0 opacity-100"
                                            leave-to-class="translate-y-1 opacity-0"
                                        >
                                            <PopoverPanel
                                                class="absolute z-40 p-4 mt-3 right-0 sm:px-0 lg:max-w-sm bg-white rounded-lg shadow-lg py-4"
                                            >
                                                <div class="px-3 py-2 flex">
                                                    <span
                                                        @click="
                                                            toggleModal(
                                                                'view',
                                                                product
                                                            )
                                                        "
                                                        class="mr-3 flex"
                                                    >
                                                        <span
                                                            class="text-xs mr-1"
                                                            >View</span
                                                        >
                                                        <EyeIcon
                                                            class="w-4 h-4"
                                                        />
                                                    </span>
                                                    <span
                                                        @click="
                                                            toggleModal(
                                                                'edit',
                                                                product
                                                            )
                                                        "
                                                        class="mr-3 flex cursor-pointer"
                                                    >
                                                        <span
                                                            class="text-xs mr-1 cursor-pointer"
                                                            >Edit</span
                                                        >
                                                        <PencilAltIcon
                                                            class="w-4 h-4"
                                                        />
                                                    </span>
                                                    <span
                                                        @click="
                                                            dropProduct(
                                                                product.id
                                                            )
                                                        "
                                                        class="flex cursor-pointer"
                                                    >
                                                        <span
                                                            class="text-xs mr-1"
                                                            >Delete</span
                                                        >
                                                        <TrashIcon
                                                            class="w-4 h-4"
                                                        />
                                                    </span>
                                                </div>
                                            </PopoverPanel>
                                        </transition>
                                    </Popover>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="pagination flex justify-between text-center mt-10" v-if="filteredProducts.length">
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
                v-model="current_page" :max="meta.last_page" type="number" min="1" />
            <span class="font-bold ml-2 text-sm">of {{ meta.last_page }}</span>
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

    <!-- This example requires Tailwind CSS v2.0+ -->

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
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all"
                        :class="
                            type == 'view'
                                ? 'sm:my-8 sm:align-middle sm:max-w-[80%] sm:w-full'
                                : ' sm:my-8 sm:align-middle sm:max-w-lg sm:w-full'
                        "
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <CreateProduct
                                @updatepage="updatepage"
                                v-if="type == 'create'"
                            />
                            <EditProduct
                                :product="product"
                                @updatepage="updatepage"
                                v-if="type == 'edit'"
                            />
                            <ViewProduct
                                :product="product"
                                v-if="type == 'view'"
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
import {
    ExclamationIcon,
    ArrowCircleLeftIcon,
    ArrowCircleRightIcon,
    EyeIcon,
    TrashIcon,
    PencilAltIcon,
} from "@heroicons/vue/outline";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import CreateProduct from "./CreateProduct";
import EditProduct from "./EditProduct";
import ViewProduct from "./ViewProduct";
import { PlusCircleIcon, DotsVerticalIcon } from "@heroicons/vue/solid";
import { usePage } from "@inertiajs/inertia-vue3";
import { ref, onMounted, computed, watch, inject, reactive } from "vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeLabel from "@/Components/Label.vue";
import moment from "moment";
export default {
    inject: ["emitter", "currency"],
    components: {
        PlusCircleIcon,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationIcon,
        CreateProduct,
        EditProduct,
        ArrowCircleLeftIcon,
        ArrowCircleRightIcon,
        BreezeCheckbox,
        BreezeLabel,
        ViewProduct,
        EyeIcon,
        TrashIcon,
        PencilAltIcon,
        Popover,
        PopoverButton,
        PopoverPanel,
        DotsVerticalIcon,
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
        const showing = ref("");
        const last_page = ref(1);
        const meta = ref({});
        const links = ref({});
        products.value = usePage().props.value.products.data;
        last_page.value = usePage().props.value.products.last_page;
        meta.value = usePage().props.value.products.meta;
        links.value = usePage().props.value.products.links;

        onMounted(()=>{
              const urlParams = new URLSearchParams(window.location.search);

             showing.value =  urlParams.get("showing")
        })
        const filteredProducts = computed(() => {
            let product = products.value;

            if (showing.value) {
                product = product.filter((item) => item.featured);
            }

            return product;
        });
        const searchProducts = () => {
            if (!query.value) {
                products.value = usePage().props.value.products.data;
                last_page.value = usePage().props.value.products.last_page;
                meta.value = usePage().props.value.products.meta;
                links.value = usePage().props.value.products.links;
                return;
            }
            axios
                .get(`/searchproducts?query=${query.value}`)
                .then((res) => {
                    products.value = res.data.data;
                    current_page.value = 1;
                    meta.value = res.data.meta;
                    links.value = res.data.links;
                });
        };
         const fetchActive = () => {

            axios
                .get(`/fetch-active`)
                .then((res) => {
                    products.value = res.data.data;
                    current_page.value = 1;
                    meta.value = res.data.meta;
                    links.value = res.data.links;
                });
        };
         const fetchInactive = () => {

            axios
                .get(`/fetch-inactive`)
                .then((res) => {
                    products.value = res.data.data;
                    current_page.value = 1;
                    meta.value = res.data.meta;
                    links.value = res.data.links;
                });
        };

        function next() {
            if (!links.value.next) return;
            current_page.value++;
        }
        function prev() {
            if (!links.value.prev) return;
            current_page.value--;
        }
        function getproducts(page) {
            axios.get(`get-products?page=${page}`).then((res) => {
                if (res.status === 200) {
                    products.value = res.data.data;
                    last_page.value = res.data.last_page;
                    meta.value = res.data.meta;
                    links.value = res.data.links;
                }
            });
        }

        watch(current_page, (current_page, prevCurrent_page) => {
            getproducts(current_page);
        });

        watch(
            query,
            _.debounce(() => {
                searchProducts();
            }, 2000)
        );
        watch(showing, () => {
            switch (showing.value) {
                case "active":
                    fetchActive();
                    break;
                case "inactive":
                    fetchInactive();
                    break;
                default:
                    getproducts(current_page);
            }
        });

        function viewoffers(id, status) {
            window.location.href = `/offers/${id}`;
        }
        return {
            viewoffers,
            products,
            last_page,
            next,
            prev,
            query,
            current_page,
            filteredProducts,

            showing,

            moment,
            meta,
            links,
        };
    },
    methods: {
        toggleModal(val, product) {
            this.open = !this.open;
            this.type = val;
            this.product = product;
        },
        updatestatus(id, value) {
            axios
                .put(this.route("products.update", id), { status: value })
                .then((res) => {
                    if (res.status === 200) {
                        this.products = this.products.slice().map((item) => {
                            if (item.id == id) {
                                item.status = value;
                            }
                            return item;
                        });
                    }
                });
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
                        this.products = this.products.filter(
                            (item) => item.id != id
                        );
                    }
                });
            }
        },
    },
};
</script>

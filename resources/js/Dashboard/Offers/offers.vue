<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="mb-5">
        <ul class="breadcrumb text-xs">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/products">Products</a></li>
            <li class="capitalize">{{ product.name }} offers</li>
        </ul>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                class="py-2 align-middle inline-block min-w-full sm:px-3 lg:px-8"
            >
                <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg p-4 bg-white"
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Ref
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Name
                                </th>

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
                                    Duration
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Verdict
                                </th>

                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    <span class="">Action</span>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    <span class="">View</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="offer in offers" :key="offer.id">
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ offer.reference }}
                                </td>

                                <td class="px-3 py-4 whitespace-nowrap">
                                    <span class="text-sm leading-5 capitalize">
                                        {{ offer.user.name }}
                                    </span>
                                </td>

                                <td class="px-3 py-4 whitespace-nowrap">
                                    <span
                                        v-if="offer.result == 'success'"
                                        class="text-sm rounded-full text-green-800 font-semibold bg-green-100 px-4 py-1"
                                    >
                                        {{ currency(offer.bid_price) }}
                                    </span>
                                    <span
                                        v-if="offer.result == 'pending'"
                                        class="text-sm rounded-full text-yellow-800 font-semibold bg-yellow-100 px-4 py-1"
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

                                <td class="px-3 py-4 whitespace-nowrap">
                                    <span
                                        class="flex text-xs border rounded p-1 justify-between items-center"
                                    >
                                        <span
                                            class="flex items-center"
                                            v-if="offer.dateType == 'range'"
                                        >
                                            <span class="text-xs">{{
                                                moment(offer.start).format(
                                                    "MMM DD, yyyy"
                                                )
                                            }}</span>
                                            <span class="mx-2">-</span>
                                            <span class="mr-4 text-xs">{{
                                                moment(offer.end).format(
                                                    "MMM DD, yyyy"
                                                )
                                            }}</span>
                                        </span>
                                        <span class="text-xs"
                                            >({{ offer.duration }} days)</span
                                        >
                                    </span>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <span class="text-sm leading-5 capitalize">
                                        {{ offer.result }}
                                    </span>
                                </td>
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-right text-base font-medium flex items-center justify-start"
                                >
                                    <span v-if="!offer.status" class="text-sm"
                                        >Done</span
                                    >
                                    <div
                                        class="flex items-center justify-end"
                                        v-if="
                                            offer.status &&
                                            product.type.toLowerCase() ==
                                                'negotiable'
                                        "
                                    >
                                        <span
                                            class="mr-3 text-green-600 hover:text-green-900 flex cursor-pointer text-sm items-center"
                                            @click="
                                                handleOffer('accept', offer.id)
                                            "
                                            ><span class="mr-1">Approve</span>
                                            <CheckIcon class="w-4 h-4" />
                                        </span>

                                        <span
                                            @click="
                                                handleOffer('reject', offer.id)
                                            "
                                            class="text-red-600 hover:text-red-900 flex cursor-pointer text-sm items-center"
                                            ><span class="mr-1">Decline</span>
                                            <XIcon class="w-4 h-4"
                                        /></span>
                                    </div>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span
                                        class="text-sm leading-5"
                                        @click="
                                            viewDays(
                                                offer.custom_days,
                                                offer.dateType,
                                                {
                                                    start: offer.start,
                                                    end: offer.end
                                                }
                                            )
                                        "
                                    >
                                        Show dates
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-8" v-if="!offers.length">
                        <span
                            class="px-3 py-2 bg-blue-50 rounded text-blue-500 text-sm"
                            >No offer available</span
                        >
                    </div>
                </div>
            </div>
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
                        class="inline-block align-bottom bg-white rounded-lg text-left sm:my-8 sm:align-middle sm:max-w-[40%] sm:w-full overflow-hidden shadow-xl transform transition-all"
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div v-if="days.length && dateType == 'custom'">
                                <div
                                    v-for="item in days"
                                    :key="item"
                                    class="px-3 py-1 border"
                                >
                                    {{ moment(item).format("MMMM DD, yyyy") }}
                                </div>
                            </div>

                            <span
                                class="flex items-center"
                                v-if="dateType == 'range'"
                            >
                                <span class="text-xs">{{
                                    moment(offer.start).format("MMM DD, yyyy")
                                }}</span>
                                <span class="mx-2">-</span>
                                <span class="mr-4 text-xs">{{
                                    moment(offer.end).format("MMM DD, yyyy")
                                }}</span>
                            </span>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { ref } from "vue";
import { ExclamationIcon, CheckIcon, XIcon } from "@heroicons/vue/outline";
import { PlusCircleIcon } from "@heroicons/vue/solid";
import moment from "moment";
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
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

            days: [],
            dateType: "custom",
            offer: {},
        };
    },
    mounted() {
        this.offers = this.$page.props.product.offers;
        this.product = this.$page.props.product;
    },
    methods: {
        viewDays(val, dateType, offer) {
         
            this.dateType = dateType;
            this.days = val;
            this.open = true;
            this.offer = offer;
        },
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
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
    },
};
</script>

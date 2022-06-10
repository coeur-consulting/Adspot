<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                class="py-2 align-middle inline-block min-w-full sm:px-3 lg:px-8"
            >
                <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg pb-4 bg-white"
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
                                    Space
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
                                    class="px-3 py-4 whitespace-nowrap text-xs text-gray-500"
                                >
                                    {{ offer.reference }}
                                </td>

                                <td class="text-xs px-3 py-4 whitespace-nowrap">
                                    <span class="text-xs leading-5 capitalize">
                                        {{ offer.user.name }}
                                    </span>
                                </td>
                                <td class="text-xs px-3 py-4">
                                    <span class="text-xs leading-5 capitalize">
                                        {{ offer.product.name }}
                                    </span>
                                </td>

                                <td class="text-xs px-3 py-4 whitespace-nowrap">
                                    <span
                                        v-if="offer.result == 'success'"
                                        class="text-xs rounded-full text-green-800 font-semibold bg-green-100 px-4 py-1"
                                    >
                                        {{ currency(offer.bid_price) }}
                                    </span>
                                    <span
                                        v-if="offer.result == 'pending'"
                                        class="text-xs rounded-full text-yellow-800 font-semibold bg-yellow-100 px-4 py-1"
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

                                <td class="text-xs px-3 py-4 whitespace-nowrap">
                                    <span
                                        class="flex text-xs rounded justify-start items-center"
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
                                        <br />
                                        <span class="text-xs"
                                            >({{ offer.duration }} days)</span
                                        >
                                    </span>
                                </td>
                                <td class="text-xs px-3 py-4 whitespace-nowrap">
                                    <span class="text-xs leading-5 capitalize">
                                        {{
                                            offer.result == "pending"
                                                ? offer.result
                                                : "Approved"
                                        }}
                                    </span>
                                </td>
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-right text-base font-medium flex items-center justify-start"
                                >
                                    <span v-if="!offer.status" class="text-xs"
                                        >Done</span
                                    >
                                    <div
                                        class="flex items-center justify-end"
                                        v-if="offer.status"
                                    >
                                        <span
                                            class="mr-3 text-green-600 hover:text-green-900 flex cursor-pointer text-xs items-center"
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
                                            class="text-red-600 hover:text-red-900 flex cursor-pointer text-xs items-center"
                                            ><span class="mr-1">Decline</span>
                                            <XIcon class="w-4 h-4"
                                        /></span>
                                    </div>
                                </td>
                                <td class="text-xs px-3 py-3 whitespace-nowrap">
                                    <span
                                        class="text-xs leading-5"
                                        @click="
                                            viewDays(
                                                offer.custom_days,
                                                offer.dateType,
                                                {
                                                    start: offer.start,
                                                    end: offer.end,
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
                            class="px-3 py-2 bg-blue-50 rounded text-blue-500 text-xs"
                            >No offer available</span
                        >
                    </div>
                </div>
            </div>
        </div>
        <div
            class="pagination flex justify-between text-center mt-8 px-3"

        >
            <div>
                <p class="text-sm text-gray-500 mb-0">
                    Showing {{ meta.from || 0 }} to {{ meta.to || 0 }} of {{ meta.total || 0 }}
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
import {
    ArrowCircleLeftIcon,
    ArrowCircleRightIcon,
} from "@heroicons/vue/solid";
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
            days: [],
            dateType: "custom",
            offer: {},
            meta: {},
            links: {},
            isLoading: false,
            current_page: 1,
        };
    },
    mounted() {
        this.offers = this.$page.props.offers.data;
        this.meta = this.$page.props.offers.meta;
        this.links = this.$page.props.offers.links;
    },
    watch: {
        current_page: "getOffers",
    },
    methods: {
        getOffers() {
            this.isLoading = true;
            axios
                .get(`/all-pending-offers?page=${this.current_page}`)
                .then((res) => {
                    this.offers = res.data.data;

                    this.meta = res.data.meta;
                    this.links = res.data.links;
                    this.isLoading = true;
                })
                .catch(() => {
                    this.isLoading = false;
                });
        },
        next() {
            if (!this.links.next) return;

            this.current_page++;
        },
        prev() {
            if (!this.links.prev) return;
            this.current_page--;
        },
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
        ArrowCircleLeftIcon,
        ArrowCircleRightIcon,
    },
};
</script>

<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="mb-5">
        <ul class="breadcrumb text-xs">
            <li><a href="/dashboard">Dashboard</a></li>
            <li>Orders</li>
        </ul>
    </div>
    <div class="flex items-center mb-4">
        <input
            placeholder="Search order no"
            v-model="query"
            type="search"
            class="py-2 px-4 border border-gray-50 rounded-lg md:w-[250px] mr-4 shadow-sm"
        />
        <div class="mr-3 flex">
            <BreezeCheckbox
                id="pending"
                value="pending"
                class="mr-2"
                v-model="showStatus"
            />
            <BreezeLabel for="pending" value="Pending " />
        </div>
        <div class="mr-3 flex">
            <BreezeCheckbox
                id="failed"
                class="mr-2"
                value="failed"
                v-model="showStatus"
            />
            <BreezeLabel for="failed" value="Failed" />
        </div>
        <div class="flex">
            <BreezeCheckbox
                id="success"
                class="mr-2"
                v-model="showStatus"
                value="success"
            />
            <BreezeLabel for="success" value="Success" />
        </div>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
            >
                <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Date
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Order no
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Customer name
                                </th>

                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Status
                                </th>

                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Total
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    <span class="">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="order in filteredOrders"
                                :key="order.order_no"
                            >
                                <td
                                    class="px-6 py-4 whitespace-nowrap capitalize"
                                >
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div
                                                class="text-sm font-medium text-gray-900"
                                            >
                                                {{
                                                    moment(
                                                        order.created_at
                                                    ).format("MMM DD, yyyy")
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap capitalize"
                                >
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div
                                                class="text-sm font-medium text-gray-900"
                                            >
                                                {{ order.order_no }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                >
                                    {{ order.user.name }}
                                </td>

                                <td
                                    class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                >
                                    {{ order.status }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                >
                                    {{ currency(order.total) }}
                                </td>

                                <td
                                    class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500 cursor-pointer"
                                >
                                    <span @click="getorder(order.id)" class=""
                                        >View order</span
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pagination text-center mt-8" v-show="last_page > 1">
        <span class="flex justify-center items-center">
            <span
                ><ArrowCircleLeftIcon
                    :class="current_page > 1 ? '' : 'opacity-70 text-slate-300'"
                    @click="prev"
                    class="cursor-pointe w-8 h-8 text-orange-700 mr-2"
            /></span>
            <input
                class="form-input w-12 py-1 px-3 text-center border border-orange-700 rounded"
                :disabled="current_page == last_page"
                v-model="current_page" />
            <span class="font-bold ml-2 text-sm">of {{ last_page }}</span>
            <span
                ><ArrowCircleRightIcon
                    :class="
                        current_page < last_page
                            ? ''
                            : 'opacity-70 text-slate-300'
                    "
                    @click="next"
                    class="w-8 h-8 text-orange-700 ml-2 cursor-pointer" /></span
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
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle md:max-w-xl md:w-full p-5"
                    >
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        Order No
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        {{ order.order_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        Customer Name
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        {{ order.user.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        Customer Email
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                    >
                                        {{ order.user.email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        Customer Phone
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        {{
                                            order.user.phone
                                                ? order.user.phone
                                                : "N/a"
                                        }}
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        Status
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        {{ order.status }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        Amount paid
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        {{ currency(order.total) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500 flex"
                                    >
                                        Items
                                    </td>
                                    <td
                                        v-for="item in order.orderhistories"
                                        :key="item.id"
                                        class="border-bottom px-6 py-4 whitespace-nowrap capitalize text-sm text-gray-500"
                                    >
                                        <tr>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap capitalize text-sm text-gray-500"
                                            >
                                                Product name
                                            </td>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap capitalize text-sm text-gray-500"
                                            >
                                                {{ item.product.name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap capitalize text-sm text-gray-500"
                                            >
                                                Duration
                                            </td>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap capitalize text-sm text-gray-500"
                                            >
                                                <span
                                                    class="flex p-1 border justify-between"
                                                >
                                                    <span>{{
                                                        moment(
                                                            item.product
                                                                .start_time
                                                        ).format("MMM DD, yyyy")
                                                    }}</span>
                                                    <span class="mx-1">-</span>
                                                    <span>{{
                                                        moment(
                                                            item.product
                                                                .end_time
                                                        ).format("MMM DD, yyyy")
                                                    }}</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap capitalize text-sm text-gray-500"
                                            >
                                                Location
                                            </td>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap capitalize text-sm text-gray-500"
                                            >
                                                {{ item.product.location }}
                                            </td>
                                        </tr>
                                        <!-- <tr>
                      <td
                        class="
                          px-6
                          py-4
                          whitespace-nowrap
                          capitalize
                          text-sm text-gray-500
                        "
                      >
                        Impressions
                      </td>
                      <td
                        class="
                          px-6
                          py-4
                          whitespace-nowrap
                          capitalize
                          text-sm text-gray-500
                        "
                      >
                        {{ item.product.impressions }}
                      </td>
                    </tr> -->
                                        <tr>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap capitalize text-sm text-gray-500"
                                            >
                                                Specification
                                            </td>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap capitalize text-sm text-gray-500"
                                            >
                                                {{ item.product.dimension }}
                                            </td>
                                        </tr>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { ref, onMounted, watch, computed } from "vue";
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationIcon } from "@heroicons/vue/outline";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeLabel from "@/Components/Label.vue";
import {
    PlusCircleIcon,
    ArrowCircleRightIcon,
    ArrowCircleLeftIcon,
} from "@heroicons/vue/solid";
import moment from "moment";
export default {
    inject: ["currency"],
    setup() {
        const open = ref(false);

        const orders = ref([]);
        const current_page = ref(1);
        const last_page = ref(1);
        const query = ref("");

        const order = ref(null);
        const showPending = ref(false);
        const showFailed = ref(false);
        const showSuccess = ref(false);
        const showStatus = ref([]);

        onMounted(() => {
            loadorders();
        });
        function loadorders() {
            axios.get(`/get-orders?page=${current_page}`).then((res) => {
                if (res.status === 200) {
                    orders.value = res.data.data;
                    last_page.value = res.data.last_page;
                }
            });
        }
        function getorder(id) {
            axios.get(`/get-orders/${id}`).then((res) => {
                if (res.status === 200) {
                    order.value = res.data;
                    open.value = true;
                }
            });
        }
        const filteredOrders = computed(() => {
            let order = orders.value;

            if (showStatus.value.length) {
                order = order.filter((item) =>
                    showStatus.includes(item.status.toLowerCase())
                );
            }

            return order;
        });

        function next() {
            if (current_page.value == last_page.value) return;
            current_page.value++;
        }
        function prev() {
            if (current_page.value == 1) return;
            current_page.value--;
        }

        function searchorders() {
            axios.get(`searchorders?query=${query.value}`).then((res) => {
                if (res.status === 200) {
                    orders.value = res.data.data;
                    last_page.value = res.data.last_page;
                }
            });
        }
        function getorders(page) {
            axios.get(`/get-orders?page=${page}`).then((res) => {
                if (res.status === 200) {
                    orders.value = res.data.data;
                    last_page.value = res.data.last_page;
                }
            });
        }

        function toggleModal(data) {
            if (data) {
                order.value = data;
            }

            open.value = !open.value;
        }

        watch(current_page, (current_page, prevCurrent_page) => {
            getorders(current_page);
        });
        watch(query, (query, prevQuery) => {
            if (query === "") {
                getorders(1);
            }
        });

        return {
            orders,
            getorder,
            last_page,
            next,
            prev,
            query,
            current_page,
            searchorders,
            filteredOrders,
            toggleModal,
            order,
            open,
            showPending,
            showFailed,
            showSuccess,
            showStatus,
            moment,
        };
    },

    components: {
        PlusCircleIcon,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationIcon,
        ArrowCircleRightIcon,
        ArrowCircleLeftIcon,
        BreezeCheckbox,
        BreezeLabel,
    },
};
</script>

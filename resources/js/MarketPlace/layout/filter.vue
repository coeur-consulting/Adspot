<template>
    <div
        class="container p-6 flex flex-col md:flex-row justify-between mx-auto"
    >
        <form
            @submit.prevent="sendFilter"
            class="bottombox bg-white py-2 md:px-3 flex flex-col md:flex-row justify-between items-center w-full md:w-[89%] border rounded"
        >
            <div
                class="px-3 py-2 md:py-0 border-b md:border-b-0 w-full md:w-auto"
            >
                <h6 class="font-bold text-xs">Subcategories</h6>
                <select

                    v-model="form.subcategory_id"
                    class="border-0 text-[.7rem] focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 capitalize"
                >
                    <option value="" disabled>Select a subcategory</option>
                    <option
                        :value="item.id"
                        v-for="item in subcategories"
                        :key="item.id"
                    >
                        {{ item.name }}
                    </option>
                </select>
            </div>
            <div
                class="px-3 py-2 md:py-0 text-white border-b md:border-b-0 md:border-l w-full md:w-auto"
            >
                <h6 class="font-bold text-xs">Date</h6>
                <div class="flex">
                    <Datepicker
                        :enableTimePicker="false"
                        class="text-[.7rem] w-[250px]"
                        
                        :format="formatter.date"
                        v-model="form.datevalue"
                        range
                        placeholder="When will the Ad run?"
                    ></Datepicker>
                </div>
            </div>
            <div
                class="px-3 py-2 md:py-0 border-b md:border-b-0 md:border-l w-full md:w-auto"
            >
                <h6 class="font-bold text-xs">Location</h6>
                <input
                    type="text"
                    v-model="form.location"
                    placeholder="Where will  this Ad run?"
                    class="border-0 text-[.7rem] focus:border-orange-400 focus:ring focus:ring-orange-300 focus:ring-opacity-50 rounded-md py-2 px-2"
                />
            </div>
            <div class="px-3 py-2 md:py-0 text-white">
                <button
                    type="submit"
                    class="search px-4 py-2 border border-transparent rounded-full shadow-lg text-xs text-white bg-orange-500 focus:ring-2 focus:ring-inset focus:ring-orange-500 flex items-center relative"
                    :disabled="disabled"
                >
                    <span class="mr-2 text-white font-bold relative"
                        >Search inventory</span
                    >
                    <SearchIcon v-if="!disabled" class="w-3 h-3" />
                    <span class="flex h-3 w-3 relative" v-if="disabled">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-50 opacity-75"
                        ></span>
                        <span
                            class="relative inline-flex rounded-full h-3 w-3 bg-slate-100"
                        ></span>
                    </span>
                </button>
            </div>
        </form>

        <div
            class="border rounded px-4 py-5 grid-cols-4 gap-2 justify-between hidden md:grid"
        >
            <div class="text-center">
                <ViewGridIcon
                    @click="switchView('grid')"
                    :class="viewType == 'grid' ? 'text-orange-500' : ''"
                    class="w-8 h-8 mx-auto"
                />
            </div>
            <div class="text-center">
                <ViewListIcon
                    @click="switchView('list')"
                    :class="viewType == 'list' ? 'text-orange-500' : ''"
                    class="w-8 h-8 mx-auto"
                />
            </div>
            <div class="text-center">
                <Popover v-slot="{ filter }" class="relative">
                    <PopoverButton
                        :class="filter ? '' : 'text-opacity-90'"
                        class=""
                    >
                        <AdjustmentsIcon
                            @click="toggleFilter"
                            :class="filter ? '' : 'text-opacity-70'"
                            class="w-8 h-8 mx-auto"
                        />
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
                            class="absolute z-40 w-[180px] px-4 mt-3 transform -translate-x-1/2 left-1/2 sm:px-0"
                        >
                            <div
                                class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                            >
                                <div class="relative grid gap-4 bg-white p-4">
                                    <label
                                        v-for="item in typeFilters"
                                        class="capitalize flex items-center"
                                        :key="item"
                                    >
                                        <input
                                            type="checkbox"
                                            :value="item"
                                            v-model="form.typeFilter"
                                            class="hover:bg-gray-50 focus:outline-none focus-visible:ring focus-visible:ring-orange-500 focus-visible:ring-opacity-50 mr-2"
                                        />{{ item }}
                                    </label>
                                </div>
                                <div class="relative grid gap-4 bg-white p-4">
                                    <label
                                        v-for="item in durationFilters"
                                        class="capitalize flex items-center"
                                        :key="item"
                                    >
                                        <input
                                            type="checkbox"
                                            :value="item"
                                            v-model="form.durationFilter"
                                            class="hover:bg-gray-50 focus:outline-none focus-visible:ring focus-visible:ring-orange-500 focus-visible:ring-opacity-50 mr-2"
                                        />{{ item }}
                                    </label>
                                </div>
                            </div>
                        </PopoverPanel>
                    </transition>
                </Popover>
            </div>
            <div class="text-center">
                <ReplyIcon
                    @click="reset"
                    class="w-8 h-8 mx-auto cursor-pointer"
                />
            </div>
        </div>
    </div>
</template>
<script>
import { ref, onMounted, computed, watch, inject, reactive } from "vue";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import { usePage } from "@inertiajs/inertia-vue3";
import Datepicker from "vue3-date-time-picker";
import "vue3-date-time-picker/dist/main.css";
import {
    SearchIcon,
    ViewGridIcon,
    ViewListIcon,
    AdjustmentsIcon,
    ReplyIcon,
} from "@heroicons/vue/solid";
import axios from "axios";
const typeFilters = ["negotiable", "non-negotiable"];
const durationFilters = ["fixed", "flexible"];
export default {
    components: {
        Datepicker,
        SearchIcon,
        ViewGridIcon,
        ViewListIcon,
        AdjustmentsIcon,
        ReplyIcon,
        Popover,
        PopoverButton,
        PopoverPanel,
    },

    data() {
        return {
            disabled: false,
            categories: [],
            subcategories: [],
        };
    },
    setup() {
        const form = reactive({
            category_id: 1,
            subcategory_id: "",
            location: "",
            datevalue: null,
            durationFilter: ["fixed", "flexible"],
            typeFilter: ["negotiable", "non-negotiable"],
        });
        const selectedFilters = ref([]);
        const filter = ref(false);
        const emitter = inject("emitter");
        const category_id = ref(0);
        const viewType = ref("grid");
        const myRef = ref(null);

        onMounted(() => {
            const urlParams = new URLSearchParams(window.location.search);
            let subcategory = urlParams.get("subcategory");
            let location = urlParams.get("location");
            let start = urlParams.get("start");
            let end = urlParams.get("end");
            if (subcategory && location && start && end) {
                form.subcategory_id = subcategory;
                form.location = location;
                form.datevalue = [start, end];
            }
        });
        emitter.on("getCategory", (data) => {
            category_id.value = data;
            form.category_id = data;
        });
        function reset() {
            emitter.emit("reset");
        }

        function sendFilter() {
            emitter.emit("filterData", form);
        }
        function switchView(data) {
            viewType.value = data;
            emitter.emit("toggleView", data);
        }
        function toggleFilter() {
            filter.value = !filter.value;
        }

        const subcategories = computed(() => {
            let subcat = usePage().props.value.subcategories;
            return !category_id.value
                ? subcat
                : subcat.filter(
                      (item) => item.category_id == category_id.value
                  );
        });
        const formatter = ref({
            date: "dd MMM yyyy",
            month: "MMM",
        });
        return {
            subcategories,
            viewType,
            myRef,
            formatter,
            form,
            sendFilter,
            switchView,
            reset,
            typeFilters,
            durationFilters,
            toggleFilter,
        };
    },
    methods: {
        postdata() {
            this.disabled = true;
            axios.post("/findspace", this.form).catch(() => {
                this.disabled = false;
            });
        },
    },
};
</script>
<style lang="scss" scoped></style>

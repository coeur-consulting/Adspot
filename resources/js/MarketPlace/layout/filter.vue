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
                    <option value="" >Select subcategory</option>
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
                <h6 class="font-bold text-xs">Search keywords</h6>
                <input
                    type="text"
                    v-model="form.location"
                    placeholder="Location, Title e.t.c."
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
            class="border rounded px-4 py-5 grid-cols-3 gap-2 justify-between hidden md:grid"
        >
            <div class="text-center">
                <ViewGridIcon
                    @click="switchView('grid')"
                    :class="viewType == 'grid' ? 'text-orange-500' : ''"
                    class="w-8 h-8 mx-auto cursor-pointer"
                />
            </div>
            <div class="text-center">
                <ViewListIcon
                    @click="switchView('list')"
                    :class="viewType == 'list' ? 'text-orange-500' : ''"
                    class="w-8 h-8 mx-auto cursor-pointer"
                />
            </div>

            <div class="text-center group">
                <RefreshIcon
                    @click="reset"
                    class="w-8 h-8 mx-auto cursor-pointer peer"
                />
<span class="absolute px-2 py-1 text-xs bg-gray-100 rounded -top-4 hidden peer-hover:inline">Reset</span>
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
    RefreshIcon,
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
        RefreshIcon,
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
            let category = urlParams.get("category");
            let location = urlParams.get("location");
            let start = urlParams.get("start");
            let end = urlParams.get("end");
            if (subcategory || location || start || end || category) {
                form.subcategory_id = subcategory;
                form.location = location;
                form.datevalue = [start, end];
                category_id.value = category;
            }
        });
        emitter.on("getCategory", (data) => {
            category_id.value = data;
            form.category_id = data;
             form.subcategory_id = "";

        });
        function reset() {
            form.subcategory_id = "";
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

<template >
  <div class=" container p-6 flex
        flex-col
        md:flex-row justify-between mx-auto">
    <form
      @submit.prevent="sendFilter"
      class="
        bottombox
        bg-white
        py-2
        md:px-3
        flex
        flex-col
        md:flex-row
        justify-between
        items-center
       w-full md:w-[89%]
        border
        rounded
      "
    >
      <div class="px-3 py-2 md:py-0 border-b md:border-b-0 w-full md:w-auto">
        <h6 class="font-bold text-xs">Subcategories</h6>
        <select
          required
          v-model="form.subcategory_id"
          class="
            border-0
            text-[.7rem]
            focus:border-orange-300
            focus:ring
            focus:ring-orange-200
            focus:ring-opacity-50
            capitalize
          "
        >
          <option :value="null" disabled>Select a subcategory</option>
          <option :value="item.id" v-for="item in subcategories" :key="item.id">
            {{ item.name }}
          </option>
        </select>
      </div>
      <div class="px-3  py-2 md:py-0 text-white border-b md:border-b-0 md:border-l w-full md:w-auto">
        <h6 class="font-bold text-xs">Date</h6>
        <div class="flex">
          <Datepicker
            class="text-[.7rem] w-[300px]"
            required
            v-model="form.datevalue"
            range
            placeholder="When will the Ad run?"
          ></Datepicker>
        </div>
      </div>
      <div class="px-3  py-2 md:py-0 border-b md:border-b-0 md:border-l w-full md:w-auto">
        <h6 class="font-bold text-xs">Location</h6>
        <input
          required
          type="text"
          v-model="form.location"
          placeholder="Where will  this Ad run?"
          class="
            border-0
            text-[.7rem]
            focus:border-orange-400
            focus:ring
            focus:ring-orange-300
            focus:ring-opacity-50
            rounded-md
            py-2
            px-2
          "
        />
      </div>
      <div class="px-3  py-2 md:py-0 text-white">
        <button
          type="submit"
          class="
            search
            px-4
            py-2
            border border-transparent
            rounded-full
            shadow-lg
            text-xs text-white
            bg-orange-500
            focus:ring-2 focus:ring-inset focus:ring-orange-500
            flex
            items-center
            relative
          "
          :disabled="disabled"
        >
          <span class="mr-2 text-white font-bold relative"
            >Search inventory</span
          >
          <SearchIcon v-if="!disabled" class="w-3 h-3" />
          <span class="flex h-3 w-3 relative" v-if="disabled">
            <span
              class="
                animate-ping
                absolute
                inline-flex
                h-full
                w-full
                rounded-full
                bg-slate-50
                opacity-75
              "
            ></span>
            <span
              class="relative inline-flex rounded-full h-3 w-3 bg-slate-100"
            ></span>
          </span>
        </button>
      </div>
    </form>

    <div class="border rounded p-5 w-[10%]  grid-cols-2 justify-between hidden md:grid">
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
    </div>
  </div>
</template>
<script>
import { ref, onMounted, computed, watch, inject, reactive } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import Datepicker from "vue3-date-time-picker";
import "vue3-date-time-picker/dist/main.css";
import { SearchIcon, ViewGridIcon, ViewListIcon } from "@heroicons/vue/solid";
import axios from "axios";

export default {
  components: {
    Datepicker,
    SearchIcon,
    ViewGridIcon,
    ViewListIcon,
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
      subcategory_id: null,
      location: "",
      datevalue: null,
    });
    const emitter = inject("emitter");
    const category_id = ref(0);
    const viewType = ref("grid");
    const myRef = ref(null);
    emitter.on("getCategory", (data) => {
      category_id.value = data;
      form.category_id = data;
    });

    function sendFilter() {
      emitter.emit("filterData", form);
    }
    function switchView(data) {
      viewType.value = data
      emitter.emit("toggleView", data);
    }

    const subcategories = computed(() => {
      let subcat = usePage().props.value.subcategories;
      return !category_id.value
        ? subcat
        : subcat.filter((item) => item.category_id == category_id.value);
    });
    const formatter = ref({
      date: "DD MMM YYYY",
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
<style lang="scss" scoped>
</style>
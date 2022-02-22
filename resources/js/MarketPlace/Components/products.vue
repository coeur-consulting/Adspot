<template>
  <div class="bg-transparent">
    <div class="pagination text-center mt-8" v-show="last_page > 1">
      <span class="flex justify-center items-center">
        <span
          ><ArrowCircleLeftIcon
            :class="current_page > 1 ? '' : 'opacity-70 text-slate-300'"
            @click="prev"
            class="cursor-pointe w-8 h-8 text-purple-700 mr-2"
        /></span>
        <input
          class="
            form-input
            w-12
            py-1
            px-3
            text-center
            border border-purple-700
            rounded
          "
          :disabled="current_page == last_page"
          v-model="current_page" />
        <span class="font-bold ml-2 text-sm">of {{ last_page }}</span>
        <span
          ><ArrowCircleRightIcon
            :class="current_page < last_page ? '' : 'opacity-70 text-slate-300'"
            @click="next"
            class="w-8 h-8 text-purple-700 ml-2 cursor-pointer" /></span
      ></span>
    </div>
   
  </div>
</template>

<script>
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
export default {
  computed: {
    filteredproducts() {
      var products = this.products;

      if (this.filterData) {
        if (
          this.filterData.storeIds.length ||
          this.filterData.categoryIds.length
        ) {
          return products.filter(
            (item) =>
              this.filterData.storeIds.includes(item.user_id) ||
              this.filterData.categoryIds.includes(item.category_id)
          );
        }

        if (this.filterData.priceType == "lth") {
          return products.sort((a, b) => {
            if (a.price < b.price) {
              return -1;
            }
            if (a.price > b.price) {
              return 1;
            }
            return 0;
          });
        }
        if (this.filterData.priceType == "htl") {
          return products.sort((a, b) => {
            if (a.price > b.price) {
              return -1;
            }
            if (a.price < b.price) {
              return 1;
            }
            return 0;
          });
        }
      }
      return products;
    },
  },

  components: {
    ShoppingCartIcon,
    ArrowCircleLeftIcon,
    ArrowCircleRightIcon,
    SortAscendingIcon,
    SortDescendingIcon,
    SearchIcon,
    Link,
  },
  data() {
    return {
      search: "",
      rate: null,
    };
  },

  setup() {
    const emitter = inject("emitter");
    const products = reactive([]);
    const current_page = ref(1);
    const last_page = ref(1);
    const query = ref("");
    const filterData = reactive({});
    const viewType = ref("grid");
    const category_id = ref(0);
    onMounted(() => {
      axios.get(`get-products?page=${current_page}`).then((res) => {
        if (res.status === 200) {
          products.value = res.data.data;
          last_page.value = res.data.last_page;
        }
      });
    });

    emitter.on("getCategory", (data) => {
      category_id.value = data;
    });
    emitter.on("filterData", (data) => {
      filterData.category_id = data.category_id;
      filterData.subcategory_id = data.subcategory_id;
      filterData.location = data.location;
      filterData.datevalue = data.datevalue;
    });
    emitter.on("toggleView", (data) => {
      viewType.value = data;
    });

    function next() {
      if (current_page == last_page) return;
      current_page.value++;
    }
    function prev() {
      if (current_page == 1) return;
      current_page.value--;
    }

    function searchproducts() {
      axios.get(`searchproducts?query=${query.value}`).then((res) => {
        if (res.status === 200) {
          products.value = res.data.data;
          last_page.value = res.data.last_page;
        }
      });
    }
    function getproducts(page) {
      axios.get(`get-products?page=${page}`).then((res) => {
        if (res.status === 200) {
          products.value = res.data.data;
          last_page.value = res.data.last_page;
        }
      });
    }

    const subcategories = computed(() => {
      let subcat = usePage().props.value.subcategories;
      return !category_id.value
        ? subcat
        : subcat.filter((item) => item.category_id == category_id.value);
    });

    watch(current_page, (current_page, prevCurrent_page) => {
      getproducts(current_page);
    });
    watch(query, (query, prevQuery) => {
      if (query === "") {
        getproducts(1);
      }
    });

    return {
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
    };
  },
  methods: {
    addtocart(product) {
      this.emitter.emit("addtocart", product);
      this.cartItems = JSON.parse(localStorage.getItem("cartItems"));
    },
    inCart(id) {
      return this.cartItems.some((item) => item.id == id);
    },
  },
};
</script>

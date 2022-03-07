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
          class="
            py-2
            px-4
            border border-gray-50
            rounded-lg
            md:w-[250px]
            mr-4
            shadow-sm
          "
        />
        <div class="mr-3 flex">
          <BreezeCheckbox id="featured" class="mr-2" v-model="showFeatured" />
          <BreezeLabel for="featured" value="Featured " />
        </div>
        <div class="mr-3 flex">
          <BreezeCheckbox
            id="negotiable"
            class="mr-2"
            v-model="showNegotiable"
          />
          <BreezeLabel for="negotiable" value="Negotiable" />
        </div>
        <div class="flex">
          <BreezeCheckbox
            id="nonnegotiable"
            class="mr-2"
            v-model="showNonnegotiable"
          />
          <BreezeLabel for="nonnegotiable" value="Non-Negotiable" />
        </div>
      </div>
      <div>
        <button
          @click="toggleModal('create')"
          type="button"
          class="
            font-bold
            px-4
            py-2
            text-sm
            whitespace-nowrap
            relative
            cursor-pointer
            border border-transparent
            rounded-md
            shadow-sm
            bg-orange-500
            hover:bg-orange-500
            flex
            justify-between
          "
        >
          <PlusCircleIcon class="w-4 h-4 mr-1 text-white" />
          <span class="text-white">Add products</span>
        </button>
      </div>
    </div>
  </div>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div
          class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
        >
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="
                    px-3
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  S/N
                </th>
                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Name
                </th>

                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Type
                </th>
                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Featured
                </th>
                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Price
                </th>

                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Status
                </th>
                <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >
                  Offers
                </th>
                 <th
                  scope="col"
                  class="
                    px-6
                    py-3
                    text-left text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider
                  "
                >

                </th>
                <th scope="col" class=" px-6
                    py-3
                    text-center text-xs
                    font-medium
                    text-gray-500
                    uppercase
                    tracking-wider">
                  <span class="">Action</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="(product, index) in filteredProducts"
                :key="product.id"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ index + 1 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-6 w-6" v-if="product.media">
                      <img
                        class="h-6 w-6 rounded-full"
                        :src="product.media[0]"
                        alt=""
                      />
                    </div>
                    <div class="ml-2">
                      <div
                        class="
                          text-sm
                          font-medium
                          text-gray-900
                          truncate
                          overflow-hidden
                          ...
                        "
                      >
                        {{ product.name }}
                      </div>
                    </div>
                  </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="
                      px-2
                      inline-flex
                      text-xs
                      leading-5
                      font-semibold
                      rounded-full
                      bg-green-100
                      text-green-800
                      capitalize
                    "
                  >
                    {{ product.type }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ product.featured ? "Yes" : "No" }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ currency(product.price) }}
                </td>


                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ !product.status ? "Unavailable" : "Available" }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                  <div
                    class="
                      text-sm text-gray-900 text-ellipsis
                      overflow-hidden
                      ...
                    "
                  >
                    {{ product.offers }}
                  </div>
                </td>
                 <td class="px-6 py-4 whitespace-nowrap">
                  <div
                    class="
                      text-sm text-gray-900
                    "
                  >
                    <span
                  v-if="product.status"
                     @click="viewoffers(product.id)"
                    class="mr-3 text-green-600 hover:text-green-900"
                    >Check offers</span
                  >
                  </div>
                </td>
                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-center text-sm
                    font-medium
                    flex
                    justify-end
                  "
                >

                   <span
                     @click="toggleModal('view',product)"
                    class="mr-3 text-blue-600 hover:text-blue-900"
                    >
                    <span class="sr-only mr-1">View</span>
                    <EyeIcon class="w-4 h-4" />
                     </span>
                  <span
                    @click="toggleModal('edit', product)"
                    class="mr-3 text-yellow-600 hover:text-yellow-900"
                    >
                     <span class="sr-only mr-1">Edit</span>
                    <PencilAltIcon class="w-4 h-4" />


                    </span>
                  <span
                    @click="dropProduct(product.id)"
                    class="text-red-600 hover:text-red-900"
                    >
                     <span class="sr-only mr-1">Delete</span>
                    <TrashIcon class="w-4 h-4" />

                    </span>
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
          class="cursor-pointe w-8 h-8 text-orange-500 mr-2"
      /></span>
      <input
        class="
          form-input
          w-12
          py-1
          px-3
          text-center
          border border-orange-500
          rounded
        "
        :disabled="current_page == last_page"
        v-model="current_page" />
      <span class="font-bold ml-2 text-sm">of {{ last_page }}</span>
      <span
        ><ArrowCircleRightIcon
          :class="current_page < last_page ? '' : 'opacity-70 text-slate-300'"
          @click="next"
          class="w-8 h-8 text-orange-500 ml-2 cursor-pointer" /></span
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
        class="
          flex
          items-end
          justify-center
          min-h-screen
          pt-4
          px-4
          pb-20
          text-center
          sm:block sm:p-0
        "
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
            class="
              inline-block
              align-bottom
              bg-white
              rounded-lg
              text-left
              overflow-hidden
              shadow-xl
              transform
              transition-all

            "
            :class="type=='view'?'sm:my-8 sm:align-middle sm:max-w-[80%] sm:w-full':' sm:my-8 sm:align-middle sm:max-w-lg sm:w-full'"
          >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <CreateProduct @updatepage="updatepage" v-if="type == 'create'" />
              <EditProduct
                :product="product"
                @updatepage="updatepage"
                v-if="type == 'edit'"
              />
              <ViewProduct  :product="product" v-if="type == 'view'"/>
            </div>
            <div
              class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
            >
              <button
                type="button"
                class="
                  mt-3
                  w-full
                  inline-flex
                  justify-center
                  rounded-md
                  border border-gray-300
                  shadow-sm
                  px-4
                  py-2
                  bg-white
                  text-base
                  font-medium
                  text-gray-500
                  hover:bg-gray-50
                  focus:outline-none
                  focus:ring-2
                  focus:ring-offset-2
                  focus:ring-indigo-500
                  sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                "
                @click="open = false"
                ref="cancelButtonRef"
              >
                Cancel
              </button>
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
  EyeIcon, TrashIcon,PencilAltIcon
} from "@heroicons/vue/outline";
import CreateProduct from "./CreateProduct";
import EditProduct from "./EditProduct";
import ViewProduct from "./ViewProduct";
import { PlusCircleIcon } from "@heroicons/vue/solid";
import { usePage } from "@inertiajs/inertia-vue3";
import { ref, onMounted, computed, watch, inject, reactive } from "vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeLabel from "@/Components/Label.vue";
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
     EyeIcon, TrashIcon,PencilAltIcon
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
    const showFeatured = ref(false);
    const showNegotiable = ref(false);
    const showNonnegotiable = ref(false);
    const last_page = ref(1);
    products.value = usePage().props.value.products.data;
    last_page.value = usePage().props.value.products.last_page;
    const filteredProducts = computed(() => {
      let product = products.value;

      if (showFeatured.value) {
        product = product.filter((item) => item.featured);
      }
      if (showNegotiable.value) {
        product = product.filter((item) => item.type == "negotiable");
      }
      if (showNonnegotiable.value) {
        product = product.filter((item) => item.type == "non-negotiable");
      }
      return product;
    });
    const searchProducts = () => {
      if (!query.value) {
        products.value = usePage().props.value.products.data;
        last_page.value = usePage().props.value.products.last_page;
        return;
      }
      axios.get(`/searchproducts?query=${query.value}`).then((res) => {
        products.value = res.data.data;
        current_page.value = 1;
      });
    };
   function next() {
      if (current_page.value == last_page.value) return;
      current_page.value++;
    }
    function prev() {
      if (current_page.value == 1) return;
      current_page.value--;
    }
    function getproducts(page) {
      axios.get(`get-products?page=${page}`).then((res) => {
        if (res.status === 200) {
          products.value = res.data.data;
          last_page.value = res.data.last_page;
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

    function viewoffers(id) {
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
      showNegotiable,
      showFeatured,
      showNonnegotiable,
    };
  },
  methods: {
    toggleModal(val, product) {
      this.open = !this.open;
      this.type = val;
      this.product = product;
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
            this.products = this.products.filter((item) => item.id != id);
          }
        });
      }
    },
  },
};
</script>
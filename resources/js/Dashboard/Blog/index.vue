<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="flex justify-end mb-6">
    <div class="flex justify-between mb-3 w-full">
      <div class="flex items-center">
        <input
          placeholder="Search title"
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
          <BreezeCheckbox id="active" class="mr-2" v-model="showStatus" />
          <BreezeLabel for="active" value="Inactive" />
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
          <span class="text-white">Add blog</span>
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
                  title
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
                  Description
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
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(item, index) in blogs" :key="item.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ index + 1 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-6 w-6" v-if="item.cover">
                      <img
                        class="h-6 w-6 rounded-full"
                        :src="item.cover"
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
                        {{ item.title }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div
                    class="
                      text-sm text-gray-900 text-ellipsis
                      overflow-hidden
                      ...
                      w-[160px]
                    "
                  >
                    {{ item.content }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div
                    class="
                      text-sm text-gray-900 text-ellipsis
                      overflow-hidden
                      ...
                    "
                  >
                    {{ item.status }}
                  </div>
                </td>

                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-right text-sm
                    font-medium
                  "
                >
                  <span
                    @click="toggleModal('edit', item)"
                    class="mr-3 text-indigo-600 hover:text-indigo-900"
                    >Edit</span
                  >
                  <span
                    @click="dropBlog(item.id)"
                    class="text-red-600 hover:text-red-900"
                    >Delete</span
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
              sm:my-8 sm:align-middle sm:max-w-lg sm:w-full
            "
          >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <CreateBlog @updatepage="updatepage" v-if="type == 'create'" />
              <EditBlog
                :blog="blog"
                @updatepage="updatepage"
                v-if="type == 'edit'"
              />
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
} from "@heroicons/vue/outline";
import CreateBlog from "./CreateBlog";
import EditBlog from "./EditBlog";
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
    CreateBlog,
    EditBlog,
    ArrowCircleLeftIcon,
    ArrowCircleRightIcon,
    BreezeCheckbox,
    BreezeLabel,
  },
  data() {
    return {
      open: false,
      type: "",
    };
  },
  setup() {
    const blogs = ref([]);
    const query = ref("");
    const current_page = ref(1);
    const showFeatured = ref(false);
    const showStatus = ref(false);
    const showNonnegotiable = ref(false);
    const last_page = ref(1);
    blogs.value = usePage().props.value.blogs.data;
    last_page.value = usePage().props.value.blogs.last_page;
    // const filteredBlogs = computed(()=>{
    //   let blogs =  blogs.value

    //  return blogs
    // })
    const searchBlogs = () => {
      if (!query.value) {
        blogs.value = usePage().props.value.blogs.data;
        last_page.value = usePage().props.value.blogs.last_page;
        return;
      }
      axios.get(`/searchblogs?query=${query.value}`).then((res) => {
        blogs.value = res.data.data;
        current_page.value = 1;
      });
    };
    function next() {
      if (current_page == last_page) return;
      current_page.value++;
    }
    function prev() {
      if (current_page == 1) return;
      current_page.value--;
    }
    function getblogs(page) {
      axios.get(`get-blogs?page=${page}`).then((res) => {
        if (res.status === 200) {
          blogs.value = res.data.data;
          last_page.value = res.data.last_page;
        }
      });
    }

    watch(current_page, (current_page, prevCurrent_page) => {
      getblogs(current_page);
    });

    watch(
      query,
      _.debounce(() => {
        searchBlogs();
      }, 2000)
    );
    return {
      blogs,
      last_page,
      next,
      prev,
      query,
      current_page,
      //filteredBlogs,
      showStatus,
      showFeatured,
    };
  },
  methods: {
    toggleModal(val, blog) {
      this.open = !this.open;
      this.type = val;
      this.blog = blog;
    },
    updatepage(data) {
      if (this.type == "edit") {
        this.blogs.map((item) => {
          if (item.id == this.blog.id) {
            item = data;
          }
          return item;
        });
      } else {
        this.blogs.unshift(data);
      }
      this.open = false;
    },
    dropBlog(id) {
      var res = confirm("Are you sure");
      if (res) {
        this.$inertia.delete(`/blogs/${id}`);
      }
    },
  },
};
</script>
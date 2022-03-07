<template>
  <Head title="Edit product" />

  <BreezeValidationErrors class="mb-4" />

  <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
    {{ status }}
  </div>

  <form @submit.prevent="update">
    <legend class="text-center font-bold mb-4">Update Product</legend>

    <div class="mt-4">
      <BreezeLabel for="name" value="Name" />
      <BreezeInput
        id="name"
        type="text"
        class="mt-1 block w-full"
        v-model="form.name"
        required
        autocomplete="name"
      />
    </div>
    <div class="mt-4 grid grid-cols-2 gap-4 justify-between">
      <div class="">
        <label for="category_id" class="block text-sm font-medium text-gray-500"
          >Category</label
        >
        <select
          id="category_id"
          v-model="form.category_id"
          name="category"
          autocomplete="category"
          class="
            mt-1
            block
            w-full
            py-2
            px-3
            border border-gray-300
            bg-white
            rounded-md
            shadow-sm
            focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
            sm:text-sm
            capitalize
          "
        >
          <option value="" disabled>Select category</option>
          <option
            :value="category.id"
            v-for="(category, id) in categories"
            :key="id"
          >
            {{ category.name }}
          </option>
        </select>
      </div>
      <div class="">
        <label
          for="subcategory_id"
          class="block text-sm font-medium text-gray-500"
          >Subcategory</label
        >
        <select
          id="subcategory_id"
          v-model="form.subcategory_id"
          name="subcategory"
          autocomplete="subcategory_id"
          class="
            mt-1
            block
            w-full
            py-2
            px-3
            border border-gray-300
            bg-white
            rounded-md
            shadow-sm
            focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
            sm:text-sm
            capitalize
          "
        >
          <option value="" disabled>Select subcategory</option>
          <option
            :value="subcategory.id"
            v-for="(subcategory, id) in subcategories"
            :key="id"
          >
            {{ subcategory.name }}
          </option>
        </select>
      </div>
    </div>
    <div class="grid grid-cols-2 gap-5">
      <div class="mt-4">
        <BreezeLabel for="price" value="Price" />
        <BreezeInput
          id="price"
          type="number"
          class="mt-1 block w-full"
          v-model="form.price"
          required
          autocomplete="price"
        />
      </div>
      <div class="mt-4">
        <div class="">
          <label for="type" class="block text-sm font-medium text-gray-500"
            >Type</label
          >
          <select
            id="category_id"
            v-model="form.type"
            name="category"
            class="
              mt-1
              block
              w-full
              py-2
              px-3
              border border-gray-300
              bg-white
              rounded-md
              shadow-sm
              focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
              sm:text-sm
              capitalize
            "
          >
            <option value="" disabled>Select type</option>
            <option value="negotiable">Negotiable</option>
            <option value="non-negotiable">Non-Negotiable</option>
          </select>
        </div>
      </div>
    </div>
    <div class="mt-4">
      <BreezeLabel for="location" value="Location" />
      <BreezeInput
        id="location"
        type="text"
        class="mt-1 block w-full"
        v-model="form.location"
        required
        autocomplete="location"
      />
    </div>
    <div class="grid grid-cols-3 gap-5">
      <div class="mt-4">
        <BreezeLabel for="impressions" value="Impressions" />
        <BreezeInput
          id="impressions"
          type="number"
          class="mt-1 block w-full"
          v-model="form.impressions"
          required
          autocomplete="impressions"
        />
      </div>
      <div class="mt-4">
        <BreezeLabel for="dimension" value="Dimension" />
        <BreezeInput
          id="dimension"
          type="text"
          class="mt-1 block w-full"
          v-model="form.dimension"
          required
          placeholder="e.g 2000 x 400"
          autocomplete="dimension"
        />
      </div>
      <div class="mt-4">
        <BreezeLabel for="duration" value="Duration(in days)" />
        <BreezeInput
          id="duration"
          type="number"
          class="mt-1 block w-full"
          v-model="form.duration"
          required
          placeholder="e.g 30"
          autocomplete="duration"
        />
      </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 items-center">
      <div class="mt-4">
        <BreezeLabel for="duration_type" class="mb-2" value="Duration type" />
        <div class="flex items-center">
          <label class="mr-5 flex items-center text-sm">
            <input
              type="radio"
              v-model="form.duration_type"
              value="fixed"
              class="mr-2"
            />
            <span>Fixed</span>
          </label>
          <label class="flex items-center text-sm">
            <input
              type="radio"
              v-model="form.duration_type"
              value="flexible"
              class="mr-2"
            />
            <span>Flexible</span>
          </label>
        </div>
      </div>
      <div class="mt-4">
        <BreezeLabel for="featured" class="mb-2" value="Featured" />
        <div class="flex">
          <BreezeCheckbox id="featured" class="mr-2" v-model="form.featured" />
          <BreezeLabel for="featured" value="Feature in popular" />
        </div>
      </div>
    </div>
    <div class="mt-4">
      <span class="block text-gray-600 text-sm text-left font-bold mb-2"
        >Select Availabilty Range</span
      >
      <v-date-picker
        mode="date"
        v-model="range"
        :modelConfig="modelConfig"
        is-range
      >
        <template v-slot="{ inputValue, inputEvents, isDragging }">
          <div class="flex flex-col sm:flex-row justify-start items-center">
            <div class="relative flex-grow">
              <svg
                class="
                  text-gray-600
                  w-4
                  h-full
                  mx-2
                  absolute
                  pointer-events-none
                "
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                ></path>
              </svg>
              <input
                class="
                  flex-grow
                  pl-8
                  pr-2
                  py-1
                  bg-gray-100
                  border
                  rounded
                  w-full
                "
                :class="isDragging ? 'text-gray-600' : 'text-gray-900'"
                :value="inputValue.start"
                v-on="inputEvents.start"
              />
            </div>
            <span class="flex-shrink-0 m-2">
              <svg
                class="w-4 h-4 stroke-current text-gray-600"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"
                />
              </svg>
            </span>
            <div class="relative flex-grow">
              <svg
                class="
                  text-gray-600
                  w-4
                  h-full
                  mx-2
                  absolute
                  pointer-events-none
                "
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                ></path>
              </svg>
              <input
                class="
                  flex-grow
                  pl-8
                  pr-2
                  py-1
                  bg-gray-100
                  border
                  rounded
                  w-full
                "
                :class="isDragging ? 'text-gray-600' : 'text-gray-900'"
                :value="inputValue.end"
                v-on="inputEvents.end"
              />
            </div>
          </div>
        </template>
      </v-date-picker>
    </div>

    <div class="mt-4">
      <BreezeLabel for="description" value="Description" />
      <BreezeTextarea
        id="description"
        type="text"
        class="mt-1 block w-full"
        v-model="form.description"
        required
        autocomplete="description"
      />
    </div>

    <div class="mt-4">
      <div
        class="
          mt-1
          flex
          justify-center
          px-4
          pt-3
          pb-4
          border-2 border-gray-300 border-dashed
          rounded-md
        "
      >
        <div class="space-y-1 text-center">
          <label
            for="file-upload"
            class="
              relative
              cursor-pointer
              bg-white
              rounded-md
              font-medium
              text-indigo-600
              hover:text-indigo-500
              focus-within:outline-none
              focus-within:ring-2
              focus-within:ring-offset-2
              focus-within:ring-indigo-500
            "
          >
            <svg
              class="mx-auto h-10 w-10 text-gray-400"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 48 48"
              aria-hidden="true"
            >
              <path
                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </label>
          <div class="flex text-sm text-gray-600 text-center">
            <div>
              <input
                id="file-upload"
                @change="handleFileUpload($event)"
                name="file-upload"
                type="file"
                multiple
                class="sr-only"
              />
            </div>
          </div>
          <span class="text-sm">Upload media</span>
        </div>
      </div>
    </div>
    <div class="bg-orange-300 p-2 transition ease-in-out" v-if="start">
      <svg
        class="animate-spin mx-auto h-6 w-6 text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
    </div>
    <div v-if="form.media.length" class="grid grid-cols-4 span-2 my-6">
      <img
        v-for="item in form.media"
        :key="item"
        :src="item"
        class="h-16 w-16"
        alt="image"
      />
    </div>
    <div class="mt-4">
      <button
        type="submit"
        class="
          mt-3
          w-full
          inline-flex
          justify-center
          rounded-md
          border border-orange-300
          shadow-sm
          px-4
          py-2
          bg-orange-600
          text-base
          font-medium
          text-slate-200
          hover:bg-orange-300
          focus:outline-none
          focus:ring-2
          focus:ring-offset-2
          focus:ring-orange-500
          sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
        "
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Submit
      </button>
    </div>
  </form>
</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeTextarea from "@/Components/Textarea.vue";
import BreezeLabel from "@/Components/Label.vue";

import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
import moment from "moment";
import "v-calendar/dist/style.css";
import { ref, computed, reactive, toRefs } from "vue";
export default {
  layout: BreezeGuestLayout,
  components: {
    BreezeButton,
    BreezeCheckbox,
    BreezeInput,
    BreezeTextarea,
    BreezeLabel,
    BreezeValidationErrors,
    Head,
    Link,
  },

  props: {
    canResetPassword: Boolean,
    status: String,
    product: Object,
  },
  emits: ["updatepage"],
  data() {
    return {
      form: this.$inertia.form({
        name: "",
        category_id: "",
        subcategory_id: "",
        description: "",
        media: [],
        location: null,
        impressions: null,
        price: null,
        dimension: null,
        type: "",
        featured: "",
        duration: null,
        start_time: "",
        end_time: "",
        duration_type: "fixed",
      }),
      cloudinary: {
        uploadPreset: "arudovwen_preset",
        cloudName: "dv6hfpky1",
      },
      start: false,
      files: [],

    };
  },
  mounted() {
    this.form = this.$props.product;
  },

  setup() {
    const modelConfig = reactive({
      type: "string",
      mask: "YYYY-MM-DD", // Uses 'iso' if missing
    });
    return {
      modelConfig,
      moment
    };
  },
  watch: {
    range: {
      deep: true,
      handler() {
        this.setDuration();
      },
    },
    'range.start':'setDuration'
  },
  methods: {
    setDuration() {

      this.form.duration = this.adDuration;
    },
    handleFileUpload(e) {
      this.start = true;
      var cloudName = this.cloudinary.cloudName;
      var upload_preset = this.cloudinary.uploadPreset;
      var url = "https://api.cloudinary.com/v1_1/" + cloudName + "/upload";

      var files = e.target.files;
      const uploads = Array.from(Array(e.target.files.length).keys()).map(
        (i) => {
          const formData = new FormData();
          formData.append("file", files[i]);
          formData.append("upload_preset", upload_preset); // Replace the preset name with your own
          formData.append("api_key", "843343413274745"); // Replace API key with your own Cloudinary API key
          formData.append("timestamp", (Date.now() / 1000) | 0);

          return axios
            .post(`${url}`, formData, {
              headers: { "X-Requested-With": "XMLHttpRequest" },
            })
            .then((response) => this.form.images.push(response.data.secure_url))
            .catch((err) => {
              this.start = false;
            });
        }
      );

      axios.all(uploads).then(() => {
        this.start = false;
      });
    },
    update() {
      this.form.processing = true;
      this.form.start_time = this.range.start;
      this.form.end_time = this.range.end;
      axios
        .put(this.route("products.update", this.$props.product.id), this.form)
        .then((res) => {
          if (res.status === 200) {
            this.form.processing = false;
            this.$emit("updatepage", res.data);
          }
        })
        .catch(() => {
          this.form.processing = false;
        });
    },
  },
  computed: {
    range: {
      get: function () {
        let range = {};
        range.start = this.$props.product.start_time;
        range.end = this.$props.product.end_time;
        return range;
      },
      set: function (newrange) {
        this.form.duration =  moment(newrange.end).diff(moment(newrange.start), "days");
        this.range.start = newrange.start;
        this.range.end = newrange.end;

      },
    },
    adDuration(){
 
      return moment(this.range.end).diff(moment(this.range.start), "days");
    },
    categories() {
      return this.$page.props.categories;
    },
    subcategories() {
      return this.$page.props.subcategories.filter(
        (item) => item.category_id == this.form.category_id
      );
    },
  },
};
</script>

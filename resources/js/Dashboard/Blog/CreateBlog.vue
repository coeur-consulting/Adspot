<template>
  <Head title="Create blog" />

  <BreezeValidationErrors class="mb-4" />

  <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
    {{ status }}
  </div>

  <form @submit.prevent="submit">
    <legend class="text-center font-bold mb-4">Add Blog</legend>

    <div class="mt-4">
      <BreezeLabel for="title" value="Title" />
      <BreezeInput
        id="title"
        type="text"
        class="mt-1 block w-full"
        v-model="form.title"
        required
        autocomplete="title"
      />
    </div>

    <div class="mt-4 flex">
      <BreezeCheckbox id="status" class="mr-2" v-model="form.status" />
      <BreezeLabel for="status" value="Status" />
    </div>

    <div class="mt-4">
      <BreezeLabel for="content" value="Content" />

       <editor
        v-model="form.content"
        required
       api-key="bt2829jw30mae7f9lzl6ut9rxr59ahdsi1n4rbbukwrcjxla"
       :init="{
         height: 500,
         menubar: false,
         plugins: [
           'advlist autolink lists link image charmap print preview anchor',
           'searchreplace visualblocks code fullscreen',
           'insertdatetime media table paste code help wordcount'
         ],
         toolbar:
           'undo redo | formatselect | bold italic backcolor | \
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | removeformat | help'
       }"
     />
    </div>

    <div class="mt-4">
      <div
        class="
          mt-1
          flex
          justify-center
          px-3
          pt-5
          pb-6
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
              class="mx-auto h-12 w-12 text-gray-400"
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
                class="sr-only"
              />
            </div>
          </div>
          <span>Upload cover</span>
        </div>
      </div>
    </div>
    <div class="text-center">
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
    </div>
    <div v-if="form.cover" class="grid grid-cols-4 span-2 my-6">
      <img :src="form.cover" class="h-16 w-16" alt="image" />
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
 import Editor from '@tinymce/tinymce-vue'

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
    Editor
  },

  props: {
    canResetPassword: Boolean,
    status: String,
  },
  emits: ["updatepage"],
  data() {
    return {
      form: this.$inertia.form({
        title: "",
        cover: "",
        content: "",
        status: false,
      }),
      cloudinary: {
        uploadPreset: "adspots-preset",
        cloudName: "adspots-cloud",
      },
      start: false,
      files: [],
    };
  },

  methods: {
    handleFileUpload(e) {
      this.start = true;
      var cloudName = this.cloudinary.cloudName;
      var upload_preset = this.cloudinary.uploadPreset;
      var url = "https://api.cloudinary.com/v1_1/" + cloudName + "/upload";

      var file = e.target.files[0];

      const formData = new FormData();
      formData.append("file", file);
      formData.append("upload_preset", upload_preset); // Replace the preset name with your own
      formData.append("api_key", "427967223253216"); // Replace API key with your own Cloudinary API key
      formData.append("timestamp", (Date.now() / 1000) | 0);

      return axios
        .post(`${url}`, formData, {
                  transformRequest: [function (data, headers) {
                      delete headers['X-Socket-Id'];
                      return data;
                  }]
              }, {
          headers: { "X-Requested-With": "XMLHttpRequest" },
        })
        .then((response) => {
          this.start = false;
          this.form.cover = response.data.secure_url;
        })
        .catch((err) => {
          this.start = false;
        });
    },
    submit() {
      axios.post(this.route("blogs.store"), this.form).then((res) => {
        if (res.status === 201) {
          this.files = [];
          this.$emit("updatepage", res.data);
          return this.form.reset("title", "content", "cover");
        }
      });
    },
  },
  computed: {
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

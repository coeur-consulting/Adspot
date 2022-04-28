<template>
    <Head title="Log in" />

    <BreezeValidationErrors class="mb-4" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="update">
        <legend class="text-center font-bold mb-4">Update subcategory</legend>

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
        <div class="mt-4">
            <BreezeLabel for="category" value="Category" />
            <select
                class="border-gray-200 rounded capitalize"
                v-model="form.category_id"
            >
                <option disabled value="">Select category</option>
                <option
                    :value="item.id"
                    v-for="item in categories"
                    :key="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
        </div>

        <div class="mt-4">
            <button
                type="submit"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-orange-300 shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-slate-200 hover:bg-orange-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
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
        subcategory: Object,
        categories: Object,
    },
    emits: ["updatepage"],
    data() {
        return {
            form: this.$inertia.form({
                name: "",
                category_id: "",
                images: "",
            }),
            cloudinary: {
                uploadPreset: "nzukoor_preset",
                cloudName: "nzukoor",
            },
            start: false,
            files: [],
        };
    },
    mounted() {
        this.form = this.$props.subcategory;
    },

    methods: {
        handleFileUpload(e) {
            this.start = true;
            var cloudName = this.cloudinary.cloudName;
            var upload_preset = this.cloudinary.uploadPreset;
            var url =
                "https://api.cloudinary.com/v1_1/" + cloudName + "/upload";

            var files = e.target.files;
            const uploads = Array.from(Array(e.target.files.length).keys()).map(
                (i) => {
                    const formData = new FormData();
                    formData.append("file", files[i]);
                    formData.append("upload_preset", upload_preset); // Replace the preset name with your own
                    formData.append("api_key", ""); // Replace API key with your own Cloudinary API key
                    formData.append("timestamp", (Date.now() / 1000) | 0);

                    return axios
                        .post(
                            `${url}`,
                            formData,
                            {
                                transformRequest: [
                                    function (data, headers) {
                                        delete headers["X-Socket-Id"];
                                        return data;
                                    },
                                ],
                            },
                            {
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest",
                                },
                            }
                        )
                        .then((response) =>
                            this.form.images.push(response.data.secure_url)
                        )
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
            this.$inertia.put(
                `/update-subcat/${this.$props.subcategory.id}`,
                this.form,
                {
                    onSuccess: () => {
                        this.$emit("updatepage");
                    },
                }
            );
        },
    },
};
</script>

<template>
    <Head title="Register" />

    <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
        <legend class="text-center mb-4">Vendor Registration</legend>
        <div>
            <BreezeLabel for="name" value="Store Name" />
            <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="email" value="Email" />
            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
        </div>
       <div class="mt-4">
            <BreezeLabel for="address" value="Address" />
            <BreezeInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required autofocus autocomplete="address" />
        </div>
<div class="mt-4">
            <BreezeLabel for="phone" value="Phone number" />
            <BreezeInput id="phone" type="number" class="mt-1 block w-full" v-model="form.phone_no" required autofocus autocomplete="phone" />
        </div>
        <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="password_confirmation" value="Confirm Password" />
            <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
        </div>
         <div class="mt-4">
            <BreezeLabel for="store_image" value="Store Image" />
            <input id="store_image" type="file" class="mt-1 block w-full" @change="handleUpload($event)" />
        </div>

         <div class="flex items-center justify-end mt-4">
            <Link :href="route('vendorlogin')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Already registered?
            </Link>

            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </BreezeButton>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                address:'',
                terms: false,
                 is_admin:true,
                image:'',
                phone_no:''
            }),
            cloudinary: {
        uploadPreset: "adspots-preset",
        cloudName: "adspots-cloud",
      },
        }
    },

    methods: {
        handleUpload(e){
             var cloudName = this.cloudinary.cloudName;
      var upload_preset = this.cloudinary.uploadPreset;
      var url = "https://api.cloudinary.com/v1_1/" + cloudName + "/upload";

           let file = e.target.files[0]
             const formData = new FormData();
          formData.append("file", file);
          formData.append("upload_preset", upload_preset); // Replace the preset name with your own
          formData.append("api_key", "427967223253216"); // Replace API key with your own Cloudinary API key
          formData.append("timestamp", (Date.now() / 1000) | 0);

           axios
            .post(`${url}`, formData, {
              headers: { "X-Requested-With": "XMLHttpRequest" },
            })
            .then((response) => this.form.image=response.data.secure_url)
            .catch((err) => {
            console.log("🚀 ~ file: Register.vue ~ line 106 ~ handleUpload ~ err", err)

            });
        },
        submit() {
            this.form.post(this.route('vendorregister'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>

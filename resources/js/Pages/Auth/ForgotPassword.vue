<template>
    <Head title="Forgot Password" />


      <div>
       <div class="mb-4 text-sm text-gray-600">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit" class="max-w-[450px] mx-auto">
        <div>
            <BreezeLabel for="email" value="Email" />
            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
        </div>

        <div class="flex items-center justify-center mt-5 ">
            <BreezeButton class="text-white bg-orange-500  capitalize rounded-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Email Password Reset Link
            </BreezeButton>
        </div>
    </form>
      </div>

      <div class="mt-4 text-center">

        <Link
          :href="route('login')"
          class="underline text-sm text-orange-500 hover:text-slate-900"
        >
          Sign in here
        </Link>
      </div>



</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head,Link } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.email'))
        }
    }
}
</script>

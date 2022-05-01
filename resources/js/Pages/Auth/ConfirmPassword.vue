<template>
    <Head title="Confirm Password" />



      <div>
       <div class="mb-4 text-sm text-gray-600">
        This is a secure area of the application. Please confirm your password before continuing.
    </div>

    <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit" class="max-w-[450px] mx-auto">
        <div>
            <BreezeLabel for="password" value="Password" />
            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" autofocus />
        </div>

        <div class="flex justify-center  mt-5">
            <BreezeButton class=" capitalize rounded-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Confirm
            </BreezeButton>
        </div>
    </form>
      </div>

      <div>

        <Link
          :href="route('login')"
          class="underline text-sm text-orange-500 hover:text-orange-900"
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

    data() {
        return {
            form: this.$inertia.form({
                password: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.confirm'), {
                onFinish: () => this.form.reset(),
            })
        }
    }
}
</script>

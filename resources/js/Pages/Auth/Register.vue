<template>
  <Head title="Register" />



      <div>
        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
          <legend class="text-center mb-4 text-2xl text-black font-extrabold">Create an account</legend>
          <div>
            <BreezeLabel for="name" value="Full Name" />
            <BreezeInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
            />
          </div>

          <div class="mt-4">
            <BreezeLabel for="email" value="Email" />
            <BreezeInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              required
              autocomplete="username"
            />
          </div>

          <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              required
              autocomplete="new-password"
            />
          </div>

          <div class="mt-4">
            <BreezeLabel for="password_confirmation" value="Confirm Password" />
            <BreezeInput
              id="password_confirmation"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
            />
          </div>

          <div class="flex items-center justify-end mt-5">
            <BreezeButton
              class="rounded-full bg-orange-500 text-white w-full capitalize justify-center"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Register
            </BreezeButton>
          </div>
        </form>
      </div>

      <div class="text-black mt-4 text-center">
        Already registered?
        <Link
          :href="route('login')"
          class="underline text-sm text-orange-600 hover:text-orange-900"
        >
          Sign in here
        </Link>
      </div>


</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

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
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        address: "",
        terms: false,
        is_admin: true,
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("register"), {
        onFinish: () => this.form.reset("password", "password_confirmation"),
      });
    },
  },
};
</script>
<style scoped lang="scss">

</style>

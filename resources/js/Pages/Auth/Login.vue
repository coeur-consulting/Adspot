<template>
  <Head title="Log in" />


    <div>
      <BreezeValidationErrors class="mb-4" />

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>

      <form @submit.prevent="submit" class="max-w-[450px] mx-auto">
        <legend class="text-center mb-4 text-2xl text-black font-extrabold">Welcome Back</legend>
        <div>
          <BreezeLabel for="email" value="Email" />
          <BreezeInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
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
            autocomplete="current-password"
          />
        </div>

        <div class="block mt-4">
          <label class="flex items-center">
            <BreezeCheckbox name="remember" v-model:checked="form.remember" />
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
          </label>
        </div>

        <div class="flex items-center justify-end mt-4">
          <BreezeButton
            class="ml-4 bg-orange-500 text-white rounded-full capitalize w-full text-center justify-center"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Log in
          </BreezeButton>
        </div>
      </form>
    </div>

    <div class="flex justify-center mt-4">
      <Link
        v-if="canResetPassword"
        :href="route('password.request')"
        class="underline text-sm text-slate-700 hover:text-slate-900 mr-5"
      >
        Forgot your password?
      </Link>
      <Link
        :href="route('register')"
        class="underline text-sm text-orange-500 hover:text-slate-900"
      >
        Sign up
      </Link>
    </div>

</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
  layout: BreezeGuestLayout,

  components: {
    BreezeButton,
    BreezeCheckbox,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
    Head,
    Link,
  },

  props: {
    canResetPassword: Boolean,
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: "",
        password: "",
        remember: false,
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("login"), {
        onFinish: () => this.form.reset("password"),
      });
    },
  },
};
</script>

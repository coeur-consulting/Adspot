<template>
    <Head title="Log in" />

    <div class="h-screen w-screen">
        <div
            class="max-w-[450px] mx-auto mt-20 md:mt-40 bg-orange-50 p-5 md:p-8 rounded-lg shadow-lg"
        >
            <BreezeValidationErrors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <Link href="/">
                <img
                    src="/images/logo-orange.png"
                    width="100"
                    class="mx-auto mb-4"
                />
            </Link>
            <form @submit.prevent="submit">
                <legend class="text-center mb-4 text-2xl font-bold">
                    Admin Login
                </legend>
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
                        <BreezeCheckbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="ml-2 text-sm text-gray-600"
                            >Remember me</span
                        >
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link
                        :href="route('adminregister')"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Sign up
                    </Link>
                    <span class="px-3">/</span>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Forgot your password?
                    </Link>

                    <BreezeButton
                        class="ml-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Log in
                    </BreezeButton>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
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
            this.form.post(this.route("adminlogin"), {
                onFinish: () => this.form.reset("password"),
            });
        },
    },
};
</script>

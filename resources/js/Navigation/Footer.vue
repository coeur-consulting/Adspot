<template>
    <section class="bg-gray-100 py-12 px-3 xl:px-0">
        <div class="container mx-auto p-3">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-5">
                <div v-for="n in content" :key="n.title">
                    <h6 class="font-bold text-sm mb-4">{{ n.title }}</h6>
                    <p
                        class="text-xs mb-2 text-gray-400"
                        v-for="s in n.subs"
                        :key="s"
                    >
                        <a :href="s.url" class="text-underline-none">
                            {{ s.text }}</a
                        >
                    </p>
                </div>
            </div>

            <hr />

            <div
                class="w-full flex flex-col-reverse md:flex-row justify-between mt-5"
            >
                <div class="text-center py-2 flex justify-between md:items-end">
                    <img src="/images/logo-orange.png" class="mr-3 w-10" />
                    <small class="text-gray-500 text-xs">
                        Copyright &#169;{{ new Date().getFullYear() }} Adspots
                        Digital Solutions. <br class="md:hidden" />
                        All rights reserved.
                    </small>
                </div>
                <div class="flex">
                    <a href="https://facebook.com/adspotsng"
                        ><img
                            src="/images/f.png"
                            class="mr-2 w-4 md:w-8 h-4 md:h-8 transition ease-in-out duration-300 hover:rotate-[360deg]"
                    /></a>
                    <a href="https://instagram.com/adspots.ng">
                        <img
                            src="/images/i.png"
                            class="mr-2 w-4 md:w-8 h-4 md:h-8 transition ease-in-out duration-300 hover:rotate-[360deg]"
                    /></a>
                    <a href="https://twitter.com/adspots.ng">
                        <img
                            src="/images/t.png"
                            class="w-4 md:w-8 h-4 md:h-8 transition ease-in-out duration-300 hover:rotate-[360deg]"
                    /></a>
                </div>
            </div>
        </div>
    </section>
</template>
<style scoped lang="scss"></style>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import BreezeButtonSmall from "@/Components/ButtonSmall.vue";
import BreezeInput from "@/Components/Input.vue";
export default {
    components: {
        Link,
        BreezeButtonSmall,
        BreezeInput,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                terms: false,
            }),
            content: [
                {
                    title: "Company",
                    subs: [
                        {
                            text: "About",
                            url: "/about",
                        },
                        { text: "Affiliate", url: "" },
                        { text: "Careers", url: "" },
                        { text: "Blog", url: "/blog" },

                    ],
                },
                {
                    title: "About Us",
                    subs: [
                        { text: "Support Center", url: "" },
                        { text: "Customer Support", url: "" },
                        { text: "About Us", url: "/about" },
                        { text: "Copyright", url: "" },
                    ],
                },
                {
                    title: "Our Information",
                    subs: [
                        { text: "Social media", url: "/contact" },
                        { text: "Privacy Policy", url: "/policy" },
                        { text: "Terms & Conditions", url: "/terms" },
                        { text: "Site Map", url: "/sitemap" },
                    ],
                },
            ],
        };
    },
};
</script>

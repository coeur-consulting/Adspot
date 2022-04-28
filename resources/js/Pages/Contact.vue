<template lang="">
    <Head title="Contact Us" />
    <Navigation />
    <Banner title="Contact Us" :breadcrumbs="breadcrumbs" />
    <div class="mt-8 relative">
        <div class="relative">
            <div
                class="w-[80%] grid grid-cols-1 md:grid-cols-3 gap-8 mx-auto py-10 bg-white mb-8 z-10 relative"
            >
                <div
                    class="min-h-[100px] shadow bg-white w-full text-center p-8 rounded-lg"
                    v-for="item in contents"
                    :key="item.name"
                >
                    <img :src="item.img" class="w-16 h-16 mx-auto mb-4" />
                    <h5 class="mb-2 font-bold">{{ item.title }}</h5>
                    <p v-for="v in item.text" :key="v.text">
                        <a target="_blank" :href="v.url"> {{ v.text }}</a>
                    </p>
                </div>
            </div>
        </div>

        <span>
            <img
                src="/images/orb.png"
                class="absolute bottom-[50%] right-0 z-4 rotate-45"
            />
        </span>
    </div>

    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <div class="bg-gray-200 h-[500px] hidden md:block"></div>
        <div class="p-8">
            <div class="shadow-sm rounded-lg p-8 w-full border">
                <h5 class="font-black text-xl mb-5">Talk to an Expert</h5>
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <input
                            v-model="form.name"
                            class="w-full px-4 py-3 border border-slate-200 rounded focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            placeholder="Enter full name "
                        />
                    </div>
                    <div class="mb-4">
                        <input
                            v-model="form.email"
                            class="w-full px-4 py-3 border border-slate-200 rounded focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            type="email"
                            placeholder="Enter email address "
                        />
                    </div>
                    <div class="mb-6">
                        <textarea
                            v-model="form.message"
                            class="w-full px-4 py-3 border border-slate-200 rounded focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            placeholder="Enter message"
                            rows="4"
                        >
                        </textarea>
                    </div>

                    <div class="">
                        <button
                            type="submit"
                            class="mx-auto text-white bg-orange-500 rounded-full shadow-lg hover:bg-orange-300 px-5 py-2 text-sm"
                        >
                            Send message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <Footer />
</template>
<script>
import Navigation from "@/Navigation/Header";
import Footer from "@/Navigation/Footer";
import { Head } from "@inertiajs/inertia-vue3";
import Banner from "@/Components/Banner";
import { reactive } from "vue";
import { SearchIcon } from "@heroicons/vue/solid";
import { useToast } from "vue-toast-notification";
const contents = [
    {
        title: "Social Connect",
        img: "/images/vision.png",
        text: [
            { text: "instagram | @adspots.ng", url: "https://instagram.com/adspots.ng" },
            { text: "Facebook | @adspotsng", url: "https://facebook.com/adspotsng" },
            { text: "Linkedin | @adspotsng", url: "https://linkedin.com/in/adspotsng" },
            { text: "Twitter | @adspots.ng", url: "https://twitter.com/adspots.ng" },
        ],
    },
    {
        title: "Phone number",
        img: "/images/mission.png",
        text: [
            { text: "08050692036 ", url: " https://wa.me/+2348050692036" },
            { text: "07018123112 ", url: " https://wa.me/+2348050692036" },
        ],
    },
    {
        title: "Email us",
        img: "/images/impact.png",
        text: [
            { text: "ekpedemeu@adspots.ng ", url: "mailto:ekpedemeu@adspots.ng" },
            { text: "hello@adspots.ng ", url: "mailto:hello@adspots.ng" },
        ],
    },
];
export default {
    components: {
        Navigation,
        Head,
        Banner,
        Footer,
        SearchIcon,
    },
    setup() {
        const toast = useToast();
        const form = reactive({
            name: "",
            email: "",
            message: "",
        });
        const breadcrumbs = reactive([
            { name: "home", url: "/" },
            { name: "contact", url: null },
        ]);
        const submit = () => {
            axios
                .post("/send/contact", form)
                .then((res) => {
                    if (res.status === 200) {
                        form.name = "";
                        form.email = "";
                        form.message = "";
                    }
                    toast.success("Message sent");
                })
                .catch(() => {
                    toast.error("Sending failed");
                });
        };
        return {
            breadcrumbs,
            contents,
            submit,
            form,
        };
    },
};
</script>
<style lang="scss" scoped>
.side_tab {
    background-image: url("/images/about.png");
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
}
</style>

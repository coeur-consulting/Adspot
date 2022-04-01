<template>
  <section class="bg-gray-100 py-12 px-10 md:px-0">
    <div class="container mx-auto">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-5">
        <div v-for="n in content" :key="n.title">
          <h6 class="font-bold text-sm mb-4">{{ n.title }}</h6>
          <p class="text-xs mb-2 text-gray-400" v-for="s in n.subs" :key="s">
            {{ s }}
          </p>
        </div>
      </div>

      <hr />

      <div class="w-full flex flex-col-reverse md:flex-row justify-between mt-5">
        <div class="text-center py-2 flex justify-between  md:items-end">
          <img src="/images/logo-orange.png" class="mr-3 w-10" />
          <small class="text-gray-500 text-xs">
            Copyright &#169;{{ new Date().getFullYear() }} Adspot Nigeria, Inc. <br class="md:hidden">
            All rights reserved.
          </small>
        </div>
        <div class="flex">
          <img src="/images/f.png" class="mr-2 w-4 md:w-8 h-4 md:h-8 transition ease-in-out duration-300 hover:rotate-[360deg]" />
          <img src="/images/i.png" class="mr-2 w-4 md:w-8 h-4 md:h-8 transition ease-in-out duration-300 hover:rotate-[360deg]" />
          <img
            src="/images/t.png"
            class= "w-4 md:w-8 h-4 md:h-8 transition ease-in-out duration-300 hover:rotate-[360deg]" />
          
        </div>
      </div>
    </div>
  </section>
</template>
<style scoped lang="scss">
</style>

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
          subs: ["About", "Affiliate", "Careers & Culture", "Blog", "Press"],
        },
        {
          title: "About Us",
          subs: [
            "Support Center",
            "Customer Support",
            "About Us",
            "Copyright",
            "Popular Campaign",
          ],
        },
        {
          title: "Our Information",
          subs: [
            "Return Policy",
            "Privacy Policy",
            "Terms & Conditions",
            "Site Map",
            "Store Hours",
          ],
        },
        {
          title: "My Account",
          subs: [
            "Press inquiries",
            "Social media",
            "Directories",
            "Images & B-roll",
            "Permissions",
          ],
        },
        {
          title: "Policy",
          subs: [
            "Application security",
            "Software principles",
            "Unwanted software policy",
            "Responsible supply chain",
          ],
        },
      ],
    };
  },
};
</script>
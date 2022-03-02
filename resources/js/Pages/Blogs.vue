<template lang="">
<Head title="News"/>
<Navigation />
<Banner title="Adspot News" :breadcrumbs="breadcrumbs"/>

 <div class="min-h-[60vh]">
   <div class="bg-orange-50 p-5 text-center" v-if="!news.length">
     No news available
   </div>
     <infinite-scroll @infinite-scroll="loadData" v-if="news.length"
:message="message"
      :noResult="noResult"
   >
     <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-10 p-10 ">
     <div class="shadow-lg rounded-lg overflow-hidden" v-for="n in news" :key="n">
    <div class="w-full">
      <img  src="/images/banner.png" class="w-full h-[200px] object-cover"/>
      <div class="p-3">
        <p class="font-black text-xl">Lorem Ipsum</p>
        <p class="text-slate-400">consectetur adipiscing elit. Nullam vel neque interdum purus sagittis congue id ut libero. Pellentesque mollis nisl et libero posuere venenatis. Integer placerat leo sed quam dignissim</p>


      </div >
      <div class="px-3 py-3 flex justify-between border-t">
<span class="flex items-center"><CalendarIcon class="w-4 h-4 mr-2 text-orange-500"/> <span class="text-xs">Feb 20,2022</span></span>
<span class="text-orange-500 text-xs">More Details</span>

      </div>
    </div>

  </div>
  </div>
    </infinite-scroll>
 </div>


  <Footer />
</template>
<script>
import Navigation from "@/Navigation/Header";
import Footer from "@/Navigation/Footer";
import { Head } from "@inertiajs/inertia-vue3";
import Banner from "@/Components/Banner";
import { ref, reactive, onMounted } from "vue";
import { CalendarIcon } from "@heroicons/vue/solid";
import InfiniteScroll from "infinite-loading-vue3";
export default {
  components: {
    Navigation,
    Head,
    Banner,
    Footer,
    CalendarIcon,
    InfiniteScroll,
  },
  setup() {
    const breadcrumbs = reactive([
      { name: "home", url: "/" },
      { name: "news", url: null },
    ]);
    const page = ref(1);
    const news = reactive([]);
    const noResult = ref(false);
    const message = ref("");

    async function loadData() {
      try {
        const result = await axios.get(`/get/news?${page.value}`);
        if (result.data.items.length) {
          news.push(...result.data.items);
          page.value++;
        } else {
          noResult.value = true;
          message.value = "No result found";
        }
      } catch (err) {
        noResult.value = true;
        message.value = "Error loading data";
      }
    }
    onMounted(() => {
      loadData();
    });

    return {
      breadcrumbs,
      noResult,
      message,
      page,
      news,
      loadData,
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
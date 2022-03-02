<template lang="">
<Head title="News"/>
<Navigation />
<Banner title="Adspot News" :breadcrumbs="breadcrumbs"/>
<div class="p-10 grid grid-cols-1 md:grid-cols-3 gap-8 mt-8 relative">
  <div class="md:col-span-2">
    <div class="w-full mb-6">
      <img src="/images/banner.png" class="w-full h-[300px] object-cover" />
    </div>
    <div>
      <h1 class="text-xl font-black mb-4">Lorem one llroe sohouoin</h1>
      <span class="text-xs text-slate-400">Feb 20,2022</span>
      <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel neque interdum purus sagittis congue id ut libero. Pellentesque mollis nisl et libero posuere venenatis. Integer placerat leo sed quam dignissim malesuada quis viverra dui. Donec lacus neque, suscipit sit amet enim at, condimentum viverra urna. Integer vitae imperdiet ante, elementum porttitor nunc. Praesent elementum magna sit amet lectus sagittis, sed posuere arcu molestie. Nulla venenatis placerat elementum. Donec pellentesque pretium mauris, at maximus orci malesuada eu. Cras congue congue velit, vel maximus enim consectetur vel. Cras euismod nisi in blandit placerat. Nullam aliquet dolor sapien, sit amet suscipit diam aliquam in. Donec quis ex in nisl hendrerit euismod. Aenean nibh tortor, semper at condimentum eget, fringilla vitae quam. Aliquam risus sapien, tincidunt quis egestas eget, tincidunt in sapien.Donec pellentesque pretium mauris, at maximus orci malesuada eu. Cras congue congue velit, vel maximus enim consectetur vel. Cras euismod nisi in blandit placerat. Nullam aliquet dolor sapien, sit amet suscipit diam aliquam in. Donec quis ex in nisl hendrerit euismod. Aenean nibh tortor, semper at condimentum eget, fringilla vitae quam. Aliquam risus sapien, tincidunt quis egestas eget, tincidunt in sapien.
Donec pellentesque pretium mauris, at maximus orci malesuada eu. Cras congue congue velit, vel maximus enim consectetur vel. Cras euismod nisi in blandit placerat. Nullam aliquet dolor sapien, sit amet suscipit diam aliquam in. Donec quis ex in nisl hendrerit euismod. Aenean nibh tortor, semper at condimentum eget, fringilla vitae quam. Aliquam risus sapien, tincidunt quis egestas eget, tincidunt in sapien.
Donec pellentesque pretium mauris, at maximus orci malesuada eu. Cras congue congue velit, vel maximus enim consectetur vel. Cras euismod nisi in blandit placerat. Nullam aliquet dolor sapien, sit amet suscipit diam aliquam in. Donec quis ex in nisl hendrerit euismod. Aenean nibh tortor, semper at condimentum eget, fringilla vitae quam. Aliquam risus sapien, tincidunt quis egestas eget, tincidunt in sapien.

</p>

<div class="flex items-center">
  <img src="/images/banner.png" class="w-16 h-16 rounded-full mr-3">
<span class="leading-1">
   <span class="text-slate-400 text-xs">Written by</span> <br>
  <span class="font-bold text-sm">John Doe</span>
</span>

</div>
    </div>
  </div>
 <div>
    <div class="bg-gray-100 rounded-lg p-8 w-full">
      <div class="flex items-center   shadow rounded-lg overflow-hidden mb-8">
          <input
          placeholder="Search name"

          type="search"
          class="py-2 px-4  h-[45px] border-0  flex-grow focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
        />
        <button class="p-2 text-white bg-orange-500 h-[45px]"><SearchIcon class="w-6 h-6"/></button>
      </div>

      <div class="max-h-[60vh] overflow-auto">

        <div class="flex mb-3 items-center " v-for="n in 8" :key="n">
          <div class="w-[35%] h-16 mr-3 ">
            <img src="/images/banner.png" class="w-full h-16  rounded" />
          </div>
          <div class="w-[65%]" >
            <strong class="font-black text-base truncate ...">How to get away with it</strong>
            <p class="text-slate-500 text-sm truncate ...">Lorem robovberu rgubuwrbu weuifbuweb webfoubuefb</p>
            <small class="text-slate-400 text-xs">Feb 20,2022</small>
          </div>
        </div>
      </div>

  </div>
 </div>
 <span>
   <img src="/images/orb.png" class="absolute bottom-[50%] right-0" />
 </span>
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

export default {
  components: {
    Navigation,
    Head,
    Banner,
    Footer,
    SearchIcon
  },
  setup() {
    const breadcrumbs = reactive([
      { name: "home", url: "/" },
      { name: "news", url: "/news" },
      { name: "Title of news", url: null },
    ]);
    return {
      breadcrumbs,
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
<template lang="">
<Head title="About Adspots Digital Solutions"/>
<Navigation />
<Banner title="About Us" :breadcrumbs="breadcrumbs"/>
  <div class="py-10 px-5 md:px-0 md:py-10 bg-white relative ">
    <span class="w-[150px] md:w-[300px] bg-orange-500/10 h-[200px] md:h-[500px] absolute top-0 right-0 z-4"></span>
     <img class="absolute -right-3 bottom-0 z-4 rotate-45" src="/images/orb.png" />
    <div class="py-8 grid grid-cols-1 md:grid-cols-2 gap-5 container mx-auto relative">
        <span class="w-[60%] md:w-[50%] mx-auto bg-gray-50 h-[100px] absolute bottom-2 md:-bottom-3 inset-x-0 z-4"></span>

     <div class="text-left flex items-center z-10">
      <div>
          <h2 class="mb-3 text-2xl font-bold">
        Your number 1 <span class="text-orange-500">Aggregator</span> of advertising spaces and brand solutions
      </h2>
      <p class="mb-5">
        We exist to help advertisers and agencies find, negotiate and pay for advertising spaces easily and transparently.  We also provide data and insight that help our clients make informed decisions and reach their target audience efficiently and effectively.

      </p>

      <button class="text-white bg-orange-500 rounded-full shadow-lg hover:bg-orange-300 px-5 py-2 text-sm"> Get started</button>

      </div>
     </div>

     <div class="w-full h-[400px] md:h-[500px] side_tab z-10">

     </div>
     <div>

     </div>

    </div>

  </div>
  <div class="md:w-[60%] mx-auto relative bg-white px-5 py-8 text-center group">
             <h2 class="text-center mb-4 font-black text-2xl">The Value we live by</h2>
             <p>Relentless pursuit of excellence; we go about our work with passion, integrity and commitment. </p>

<span class="w-12 h-12 bg-orange-500 rounded-full absolute top-0 left-10 md:left-[25%] group-hover:scale-110 transition ease-in-out duration-300">

</span>
<span class="w-6 h-6 bg-orange-100 rounded-full absolute top-10 left-8 md:left-[30%] group-hover:scale-110 transition ease-in-out duration-300">

</span>
  </div>
  <div class="w-[80%] grid grid-cols-1 md:grid-cols-3 gap-8 mx-auto py-10 bg-white mb-8 ">
    <div class=" min-h-[100px] shadow bg-white w-full text-center p-8 rounded-lg border group" v-for="item in contents" :key="item.title">
      <img :src="item.img" class="w-16 h-16 mx-auto mb-4 group-hover:scale-110 transition ease-in-out duration-300" />
      <h5 class="mb-2 font-bold">{{item.title}}</h5>
      <p>
        {{ item.text }}
      </p>
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
const contents = [
  {
    title: "Vision",
    text: "Transform lives and businesses through data, empathy and technology",
    img: "/images/vision.png",
  },
  {
    title: "Mission",
    text: " Make it easy for advertisers to access and pay for ad spots",
    img: "/images/mission.png",
  },
  {
    title: "Purpose",
    text: "To run a profitable business in a law abiding, socially responsible and inclusive manne",
    img: "/images/impact.png",
  },
];
export default {
  components: {
    Navigation,
    Head,
    Banner,
    Footer,
  },
  setup() {
    const breadcrumbs = reactive([
      { name: "home", url: "/" },
      { name: "about us", url: null },
    ]);
    return {
      breadcrumbs,
      contents,
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
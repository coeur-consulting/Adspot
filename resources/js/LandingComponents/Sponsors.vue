<template >
  <section id="sponsors" class=" p-4 md:p-6 bg-gray-100  relative">
    <div class="flex flex-col  md:flex-row items-center z-[3] mx-auto container relative">
        <div class="w-full md:w-1/5">
       <p class="font-bold text-xl">Trusted by over <br> 1000 clients including</p>
      </div>
         <div  class="w-full md:w-4/5 grid grid-cols-3 md:grid-cols-5 gap-3 justify-between items-center">
          <img :src="item"  v-for="item in images" :key="item"/>
         </div>
    </div>
  </section>
</template>
<script>
const images = [
  'images/Access.png',
   'images/clout.png',
    'images/soundcity.png',
     'images/udux.png',
      'images/chipper-cash.png',
]
export default {
  setup(){
  return {
    images
  }
  }
};
</script>
<style lang="scss" scoped>
#sponsors {


}
</style>
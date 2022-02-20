<template >
  <section class="py-16 md:py-0 md:h-80 relative z-[2]">
    <div class="mb-4 px-5">
       <h6 class="text-orange-500">Our Process</h6>
      <h4 class="text-white font-bold text-xl">How it works</h4>
    </div>
    <div class="ml-auto w-full md:w-[85%]  px-5 grid grid-cols-1 md:grid-cols-4 gap-5 md:absolute md:bottom-[-15%] right-0">
      <span class="bg-white rounded ld shadow-lg p-5 text-left" v-for="n in 4" :key="n">
        <div class="flex items-center mb-5">
         <span class="flex justify-center items-center w-8 h-8 rounded-full bg-orange-100 mr-2">
           <span class="text-orange-500 text-sm font-bold">{{n+1}}</span>

         </span>
         <h6 class="font-bold">Find Adspot</h6>
        </div>
        <p class="mb-6">
          lorem2ea fuqdbouq nbuiebfu ieby iebcieb cuibcui buicbe uiecbui ebcuqbc
        </p>



          <a
            v-if="!$page.props.auth.user"
            href="/register"
            class="
              hidden
              md:inline

              whitespace-nowrap
              inline-flex
              items-center
              justify-center
              px-6
              py-1
              border border-orange-500
              rounded-full
              shadow-sm
              text-xs
              text-orange-500
              font-bold
              text-white
              bg-white
              hover:bg-orange-500
              hover:text-white
            "
          >
           Get started
          </a>

      </span>
    </div>

  </section>
</template>
<script>
const content = [
  { text:'',
  },
  { text:'',
  },
  { text:'',
  },
  { text:'',
  }
]
export default {

}
</script>
<style lang="scss" scoped>
section{
background:url('/images/work.png');
background-size: cover;
background-repeat:no-repeat;
}
</style>
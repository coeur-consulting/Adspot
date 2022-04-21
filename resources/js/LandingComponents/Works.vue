<template >
  <section class="py-24 md:py-0 md:h-80 relative z-[2]">
    <div class="mb-4 px-6 md:hidden">
       <h6 class="text-orange-500">Our Process</h6>
      <h4 class="text-white font-bold text-xl">How it works</h4>
    </div>
    <div class="ml-auto w-full md:w-[85%]  px-6 grid grid-cols-1 md:grid-cols-4 gap-5 md:absolute md:bottom-[-15%] right-0">
      <span class="group flex flex-col bg-white rounded ld shadow-lg p-5 text-left" v-for="(n,index) in content" :key="index">
        <div class="grow peer">
          <div class="flex items-center mb-5">
         <span class="flex justify-center items-center w-8 h-8 rounded-full bg-orange-100 mr-2">
           <span class="text-orange-500 text-sm font-bold">{{index+1}}</span>

         </span>
         <h6 class="font-bold">{{n.title}}</h6>
        </div>
        <p class="mb-6 text-sm">
         {{ n.text }}
        </p>
        </div>



         <div>
            <a
            v-if="!$page.props.auth.user"
            href="/register"
            class="
         vibrate-1
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
         </div>

      </span>
    </div>

  </section>
</template>
<script>
const content = [
  { title:'Find spot',
  text:"Search to find suitable ad spaces for your brand. Access over 10000 advertising spaces and brand solutions across Nigeria. You can search based on location, media channel or budget. Our experts are also available to help you here."
  },
  { title:'Bid spot',
  text:'Confirm availability of space(s) and negotiate to get the best deal. You can rest assured that we will work with you every step of the way to ensure you get value for money and ROI for your brand.  '
  },
  { title:'Get spot',
  text:" Pay and start running your campaigns. Campaigns typically start running within 72 hours of payment confirmation and submission of materials by you. Your material must be APCON approved(Our experts can help here as well)"
  },
  { title:'Place ad',
  text:'Monitor and track to ensure plan and execution are in alignment. You will receive monthly compliance reports as evidence that campaign ran as planned. You may also engage an independent monitoring agency.'
  }
]
export default {
setup(){
  return  {
    content
  }
}
}

</script>
<style lang="scss" scoped>
section{
background:url('/images/work.png');
background-size: cover;
background-repeat:no-repeat;
}
</style>
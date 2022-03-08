<template lang="">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
   <div class="p-8 shadow  bg-white rounded-md flex justify-between items-center">
      <div class="h-full w-full  flex  items-center">
        <MapIcon class="w-16 md:w-20 h-16 md:h-20 px-3 py-4 bg-orange-600 text-white rounded-full mr-5" />
        <div class=" text-left">

      <span class="font-bold text-xl md:text-2xl text-slate-600">{{$page.props.total_products}} Ad Spaces</span>

    </div>
      </div>
   </div>
     <div class="p-8 shadow  bg-white rounded-md flex justify-between items-center">
      <div class="h-full w-full  flex  items-center">
         <SpeakerphoneIcon class="w-16 md:w-20 h-16 md:h-20 px-3 py-4 bg-orange-600 text-white rounded-full mr-5" />
        <div class="text-left">
           <span class="font-bold text-xl md:text-2xl text-slate-600">{{$page.props.total_orders}} Active Spaces</span>


    </div>
      </div>
   </div>
      <div class="p-8 shadow  bg-white rounded-md flex justify-between items-center">
      <div class="h-full w-full  flex  items-center">
         <CreditCardIcon class="w-16 md:w-20 h-16 md:h-20 px-3 py-4 bg-orange-600 text-white rounded-full mr-5" />
        <div class="text-left">
           <span class="font-bold text-xl md:text-2xl text-slate-600">8 Total Orders</span>

    </div>
      </div>
   </div>

  </div>
</template>
<script>
import {
  MapIcon,
  SpeakerphoneIcon,
  CreditCardIcon,
} from "@heroicons/vue/solid";
export default {
  components: {
    MapIcon,
    SpeakerphoneIcon,
    CreditCardIcon,
  },
};
</script>
<style lang="">
</style>
<template lang="">
<div class="relative">
  <div class="container mx-auto py-10 z-10 relative">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">

      <div class="md:col-span-2 overflow-auto max-h-[90vh] px-5 md:px-0">
        <h4 class="mb-6 font-bold">My Shopping Cart <span class="text-xs text-slate-400 ml-1">(14 items)</span></h4>
        <div class=" p-5 shadow-sm rounded-lg border mb-5 bg-white " v-for="n in 8" :key="n">
          <div class="p-1 bg-orange-100 text-orange-500 text-xs rounded text-center mb-3" v-if="n==2">
              The price you offered for the adspot “65,000” is in review you will be allowed to checkout if the amount meets the negotiation range
          </div>
           <div class="p-1 bg-green-100 text-green-500 text-xs rounded text-center mb-3" v-else>
             “₦65,000” the negotiated price has been accepted you can now proceed to checkout the price will be updated on your order summary
          </div>
         <div class="flex flex-col md:flex-row">
            <div class="p-4">
            <img   class="w-full md:w-[150px] h-[80px] rounded-lg"/>
          </div>
          <div class="flex flex-col md:flex-row justify-between items-center grow p-3 md:p-0">
          <span>
              <p><span class="font-bold text-xl">₦80,000</span> <span class="text-sm text-slate-400">/4 weeks</span></p>
              <p class="font-bold">90,000 Weekly Impression</p>
              <p class="font-bold text-sm">Negotiated Price: ₦65,000 </p>
              <p class="text-slate-400 text-sm">Billboard @ Marina Express Ibeju Lekki, Lagos</p>
              <p class="text-slate-400 text-xs">4000 x 5890</p>
          </span>
          <div class="text-right w-full md:w-auto">
           <p class="flex mb-1 items-center justify-end">
              <span class="text-xs">View Details </span> <TrashIcon class="w-3 h-3 ml-1 text-red-500" /></p>
           <div class="text-slate-400 p-1 border flex bg-gray-50 text-xs justify-center rounded-sm">
             <span class="mr-1 text-xs">Feb 1, 2022</span> <span class="mx-1">-</span>
               <span class="text-xs">Mar 1, 2022</span>
           </div>
          </div>

          </div>
         </div>

        </div>
      </div>
       <div class="">
         <div class=" bg-gray-50  rounded-lg py-8">
          <div class="p-5">
             <h6 class="font-black">Order Summary</h6>
           <small>4 Ad location reserved for 7weeks</small>


          </div>
           <hr>

           <div class="p-5">
             <p class="flex justify-between mb-4">
               <span class="text-sm">Sub total</span>
               <span class="font-bold">NGN 80,000</span>
             </p>
              <p class="flex justify-between mb-4">
               <span class="text-sm">Total impressions</span>
               <span class="font-bold">80,000</span>
             </p>
              <p class="flex justify-between mb-4">
               <span class="text-sm">Discount</span>
               <span class="font-bold">NGN 80,000</span>
             </p>
              <p class="flex justify-between mb-4">
               <span class="text-sm">Coupon applied</span>
               <span class="font-bold">NGN 80,000</span>
             </p>

           </div>
           <hr>
           <div class="p-5 ">
              <p class="flex justify-between mb-4">
               <span> Total</span>
               <span class="font-bold text-xl text-orange-500">NGN 80,000</span>
             </p>
             <input placeholder="Enter coupon code" class="px-4 py-2 rounded border w-full" />
           </div>
           <div class="mt-5 p-5">
               <button
                        type="button"
                        class="
                          flex
                        justify-center
                        items-center
                        px-6
                        py-2
                        border border-transparent
                        rounded-full
                        shadow-sm
                        text-base
                        font-medium
                        text-white
                        bg-orange-500
                        hover:bg-orange-400
                       mx-auto
                        "

                      >
                        Proceed to checkout
                      </button>
           </div>

         </div>
       </div>
    </div>
  </div>
  <img src="/images/orb.png" class="absolute top-10 left-0" />
   <img src="/images/orb.png" class="absolute bottom-0 right-0 rotate-45" />
  </div>
</template>
<script>
import { TrashIcon } from "@heroicons/vue/outline";
export default {
  components:{
    TrashIcon
  }
};
</script>
<style lang="">
</style>
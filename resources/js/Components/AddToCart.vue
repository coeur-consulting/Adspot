<template lang="">
  <button
  @click="addtocart"
            class="
              inline
              whitespace-nowrap
              inline-flex
              items-center
              justify-center
              px-6
              py-2
              border
              rounded-full
              shadow-base
              text-white
              font-bold
              text-white

              hover:bg-orange-300
              text-xs

            "
            :class="incart?'bg-gray-300 border-gray-100':'bg-orange-500 border-orange-500'"
            :disabled="incart"
          >
            {{ incart?'Added to cart':'Add to cart' }}
          </button>
</template>
<script setup>
import { ref, computed, inject } from "vue";
import axios from "axios";

const props = defineProps({
  product: {
    type: Object,
  },
  duration: {
    type: Number,
  },

  negotiation: {
    type: Number,
  },
  cart: {
    type: Array,
  },
  start:{
    type:String
  },
  end:{
    type:String
  },
  cartId:{
    type:Number
  }
});

const emitter = inject("emitter");
function addtocart() {


  let data = {
    product_id: props.product.id,
    duration: props.duration,
    price: props.negotiation,
    type:props.product.type,
    start:props.start,
    end:props.end,
    cartId:props.cartId
  };


  axios.post("/addtocart", data).then((res) => {
    if (res.status === 200) {
      emitter.emit("addtocart");

    }
  });
}
 
const incart = computed(() => {
  if (!props.cart.length) return false;
  return props.cart.some((item) => item.product_id == props.product.id && ((item.status=="pending" && item.type =='negotiable')|| (item.status=="success" && item.type =='non-negotiable')));
});

</script>
<style lang="">
</style>
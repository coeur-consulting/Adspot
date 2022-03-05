<template>
  <paystack
    buttonClass=" flex
                  justify-center
                  items-center
                  px-8
                  py-2
                  border border-transparent
                  rounded-full
                  shadow-sm
                  text-base
                  font-medium
                  text-white
                  bg-orange-500
                  hover:bg-orange-400
                mx-auto paystack"
    buttonText="Proceed to payment"
    :publicKey="publicKey"
    :email="email"
    :amount="amount * 100"
    :reference="reference"
    :onSuccess="onSuccessfulPayment"
    :onCanel="onCancelledPayment"
  >
  </paystack>
</template>

 <script>
import paystack from "vue3-paystack";
import { ref, computed } from "vue";
import axios from "axios";
export default {
  components: {
    paystack,
  },
  props: ["email", "amount"],
  inject: ["emitter", "currency"],
  setup() {
    const publicKey = ref("pk_test_a3a660faf85f6507301c6cca1147c89166dde1fa");

    function onSuccessfulPayment(response) {
      console.log("🚀 ~ file: Paystack.vue ~ line 42 ~ onSuccessfulPayment ~ response", response)

      axios.post("orders", response).then((res) => {
        if (res.status === 200) {
          //clearcart();
        }
      });
    }
    function onCancelledPayment() {
      console.log("cancelled");
    }
     function clearcart() {
      axios.get(`/clear/cart`).then((res) => {
        if (res.status === 200) {
          this.emitter.emit("addtocart");
          this.cart = [];
        }
      });
    }
    const reference = computed(() => {
      let text = "";
      let possible =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for (let i = 0; i < 10; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
    });


    return {
      onSuccessfulPayment,
      onCancelledPayment,
      reference,
      publicKey,
    };
  },
};
</script>

<style scoped>
.text-white span {
  color: white;
}
</style>
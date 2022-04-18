<template lang="">
 <section class="relative h-full py-16 bg-white" id="contact">
    <div class="container mx-auto h-full w-full text-left p-3 flex flex-col md:flex-row justify-between">
    <div class="w-full md:w-[64%] p-5 text-left z-[1]">
        <h5 class="font-bold mb-5 text-xl">Other Services</h5>
      <div class="grid grid-cols md:grid-cols-2 gap-4 ">
        <div v-for="n in content" :key="n.title" class="bg-white shadow-lg  rounded-lg p-4 group">
          <div class="w-12 h-12 rounded-full shadow-lg bg-orange-500 group-hover:scale-110 transition ease-in-out duration-300"></div>

          <div class="py-4">
            <h6 class="font-bold mb-3">{{n.title}}</h6>
            <p class="text-sm">{{n.text}}</p>
          </div>
          </div>
      </div>
    </div>


    <div class=" relative  mx-auto  w-[90%] md:w-[30%] rounded-lg group  mt-12 md:mt-0">


   <div class="z-10 md:p-8 h-full  bg-white rounded-lg relative w-full   border  shadow-sm p-4 peer">
        <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
      <legend class=" font-bold text-xl mb-4 text-left">Talk to an Expert</legend>
        <div>

            <BreezeInput id="name" type="text" class="mt-1 block w-full" placeholder="Enter full name" v-model="form.name" required  autocomplete="name" />
        </div>

        <div class="mt-8">

            <BreezeInput id="email" type="email" class="mt-1 block w-full" placeholder="Enter email address "  v-model="form.email" required autocomplete="email" />
        </div>



         <div class="mt-8">

            <BreezeTextarea id="complaint" type="text" class="mt-1 block w-full" placeholder="Enter message"  v-model="form.message" required autocomplete="complaints" > </BreezeTextarea>
        </div>


        <div class="flex justify-center mt-10">


            <BreezeButton class="ml-4 rounded-full text-sm bg-orange-500 text-white"  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Send message
            </BreezeButton>
        </div>
    </form>
      </div>
 <span class="bg-orange-500 rounded-lg w-full h-full top-0 absolute translate-x-2 peer-hover:translate-x-8 peer-hover:translate-y-4 transition ease-in-out duration-300 ">

      </span>
    </div>

  </div>

 </section>
</template>
<script>
import BreezeButton from "@/Components/ButtonSmall.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeTextarea from "@/Components/Textarea.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
export default {
  components: {
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
    BreezeTextarea,
    Head,
    Link,
  },
  data() {
    return {
      form: {
        name: "",
        email: "",

        message: "",
      },
      content: [
        {
          title: "Creative Development",
          text: "We have a team of creatives who are passionate about ensuring the words and images you put out evoke engagement and action from your audience",
        },
        {
          title: "Campaign strategy, planning and execution",
          text: "Every brand has a unique offering and target market. Find out how we use data to better understand your target customers and decipher the right combination of media channels to reach and engage them",
        },
        {
          title: "Media Planning and Buying",
          text: "We save you time and money through efficient and effective purchase of media using advanced data, tools and negotiations",
        },
        {
          title: "Market Research/Brand Intelligence",
          text: "Find out more about the Nigerian consumer and media market, the trends, key players, leading platforms. Arm yourself with information before launching your product, service or a campaign.",
        },
      ],
    };
  },
  methods: {
    submit() {
      axios.post("/send/contact", this.form).then((res) => {
        if (res.status === 200) {
          this.form = {
            name: "",
            email: "",
            message: "",
          };
        }
        this.$toast.success('Message sent')
      }).catch(()=>{
        this.$toast.error('Sending failed')
      });
    },
  },
};
</script>
<style lang="scss" scoped>
section {
}
</style>
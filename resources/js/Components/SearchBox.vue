<template >
  <div>
    <div class="topbox bg-gray-400 grid grid-cols-5 w-[45%]">
      <span
        v-for="item in categories"
        :key="item.value"
        class="py-3 px-2 text-center text-white text-xs"
        :class="{ 'bg-white text-orange-500': active === item.value }"
        @click="active = item.value"
        >{{ item.name }}</span
      >
    </div>
    <div class="bottombox bg-white p-3 flex justify-between items-center w-[80%]">
      <div clas="p-3 ">
        <h6 class="font-bold text-xs">Subcategories</h6>
        <select v-model="subcategory" class="border-0 text-[.8rem]  focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
          <option value="" disabled>Select a sub category</option>
        </select>
      </div>
      <div clas="p-3  text-white">
        <h6 class="font-bold text-xs">Date</h6>
       <div class="flex">
    <Datepicker class="text-[.8rem]" v-model="dateValue" range  placeholder="When will the Ad run?"></Datepicker>
  </div>
      </div>
      <div clas="p-3  text-white">
        <h6 class="font-bold text-xs">Location</h6>
        <input
          placeholder="Where will  this Ad run?"
          class="border-0 text-[.8rem] focus:border-orange-400 focus:ring focus:ring-orange-300 focus:ring-opacity-50 rounded-md py-2 px-2 "
        />
      </div>
      <div clas="p-3  text-white">
        <button
          type="button"
          class="
            search
            px-4
            py-2
            border border-transparent
            rounded-full
            shadow-lg
            text-xs text-white
            bg-orange-500
            focus:ring-2 focus:ring-inset focus:ring-orange-500
            flex items-center
          ">

        <span class="mr-2 text-white font-bold">Search inventory</span> <SearchIcon class="w-3 h-3"/></button>
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
 import Datepicker from 'vue3-date-time-picker';
    import 'vue3-date-time-picker/dist/main.css'
    import {
 SearchIcon
} from "@heroicons/vue/solid";
const categories = [
  {
    name: "Out of home",
    value: "home",
  },
  {
    name: "Radio",
    value: "radio",
  },
  {
    name: "Prints",
    value: "prints",
  },
  {
    name: "Television",
    value: "television",
  },
  {
    name: "Online",
    value: "online",
  },
];
export default {
components:{
  Datepicker,
  SearchIcon
},
  setup() {
    const active = ref("home");
    const myRef = ref(null);
    const dateValue = ref(null);
    const formatter = ref({
      date: "DD MMM YYYY",
      month: "MMM",
    });
    return {
      active,
      categories,
      myRef,
      dateValue,
      formatter,
    };
  },
  data() {
    return {
      subcategory: "",
    };
  },
};
</script>
<style lang="scss" >
.search::placeholder {
  color: white;
}


</style>
<template >

  <div v-if="categories.length" class="transition ease-in-out">
    <div class="topbox bg-gray-400 grid grid-cols-4 w-[45%]">
      <span
        v-for="item in categories"
        :key="item.id"
        class="py-3 px-2 text-center text-white text-xs capitalize"
        :class="{ 'bg-white text-orange-500': active === item.id }"
        @click="setCategory(item.id)"
        >{{ item.name }}</span
      >
    </div>
    <form @submit.prevent="postdata" class="bottombox bg-white p-3 flex justify-between items-center w-[80%]">
      <div clas="p-3 ">
        <h6 class="font-bold text-xs">Subcategories</h6>
        <select required v-model="form.subcategory_id" class="border-0 text-[.8rem]  focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 capitalize">
          <option :value="null" disabled>Select a subcategory</option>
          <option :value="item.id" v-for="item in filteredsubcategories"  :key="item.id">{{item.name}}</option>
        </select>
      </div>
      <div clas="p-3  text-white">
        <h6 class="font-bold text-xs">Date</h6>
       <div class="flex">
    <Datepicker class="text-[.8rem]" required v-model="form.datevalue" range  placeholder="When will the Ad run?"></Datepicker>
  </div>
      </div>
      <div clas="p-3  text-white">
        <h6 class="font-bold text-xs">Location</h6>
        <input
        required
        form.location
          placeholder="Where will  this Ad run?"
          class="border-0 text-[.8rem] focus:border-orange-400 focus:ring focus:ring-orange-300 focus:ring-opacity-50 rounded-md py-2 px-2 "
        />
      </div>
      <div clas="p-3  text-white">
        <button
          type="submit"
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
            relative
          " :disabled="disabled">

        <span class="mr-2 text-white font-bold relative">Search inventory</span> <SearchIcon v-if="!disabled" class="w-3 h-3"/>
       <span class="flex h-3 w-3 relative" v-if="disabled">
  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-50 opacity-75"></span>
  <span class="relative inline-flex rounded-full h-3 w-3 bg-slate-100"></span>
</span>
        </button>

      </div>
    </form>
  </div>
</template>
<script>
import { ref} from "vue";
 import Datepicker from 'vue3-date-time-picker';
    import 'vue3-date-time-picker/dist/main.css'
    import {
 SearchIcon
} from "@heroicons/vue/solid";
import axios from 'axios'

export default {
components:{
  Datepicker,
  SearchIcon
},
  setup() {
    const active = ref(1);
    const myRef = ref(null);

    const formatter = ref({
      date: "DD MMM YYYY",
      month: "MMM",
    });

    return {
      active,
      myRef,

      formatter,
    };
  },
  data() {
    return {
      disabled:false,
      categories:[],
      subcategories:[],

      form:{
         category_id:1,
      subcategory_id: null,
        location:'',
        datevalue:null
      }
    };
  },
  mounted(){
 this.getcategories()
  },
  methods:{
    setCategory(id){
    this.form.category_id = id
    this.active = id
    },
    getcategories(){
      axios.get('/categories').then(res=>{
        if(res.status===200){
          this.categories = res.data
        }
      })
       axios.get('/subcategories').then(res=>{
        if(res.status===200){
          this.subcategories = res.data
        }
      })
    },
    postdata(){
    this.disabled=true
    axios.post('/findspace', this.form).catch(()=>{
this.disabled = false
    })
    }
  },
  computed:{
    filteredsubcategories(){
      return this.subcategories.filter(item=>item.category_id===this.form.category_id)
    }
  }
};
</script>
<style lang="scss" >
.search::placeholder {
  color: white;
}


</style>
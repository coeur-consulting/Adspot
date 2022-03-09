<template lang="">

<div class=" relative">
  <div class="md:col-span-2">
    <div class="w-full mb-6">
      <img :src="blog.cover?blog.cover:'/images/banner.png'" class="w-full h-[300px] object-cover" />
    </div>
    <div>
      <h1 class="text-xl font-black mb-4">{{blog.title}}</h1>
      <span class="text-xs text-slate-400">{{moment(blog.created_at).format("MMM DD, yyyy")}}</span>
      <p class="mb-10" v-html="blog.content"></p>

</div>

 </div>

</div>

</template>
<script>
import moment from 'moment'
export default {
  components: {},
  props: ["blog"],
  setup() {

    return{
      moment
    }
  }
};
</script>

<template lang="">
<div class="mb-3">
  <ul class="breadcrumb text-xs">
  <li><a href="/">Home</a></li>
  <li>Notifications</li>


</ul>
</div>
 <div class="py-10 mb-10">
    <div class="container mx-auto lg:max-w-[70%]">
    <!-- <h4 class="font-black mb-5">Notifications</h4> -->
    <!-- <hr> -->
    <div class="px-4 py-2 flex justify-end">
      <span @click="markAsRead">Mark all as read</span>
    </div>
         <div class="bg-white rounded-lg">
             <ul class="max-h-[80vh] overflow-auto">
                      <li
                        v-for="item in notifications"
                        :key="item.name"
                        class="border-b p-4 cursor-pointer flex items-start"
                      >
                      <span>
                        <BellIcon  class="w-4 h-4 text-orange-500 mr-2"/>
                      </span>
                       <div class="grow">
                          <p class="text-sm mb-2" :class="item.read_at?'':'font-extrabold'" @click="readNow(item)">{{ item.data.body }}</p>

                        <div class="text-right">
                          <p class="text-xs">
                            {{ moment(item.created_at).fromNow() }}
                          </p>
                        </div>
                       </div>
                      </li>
                    </ul>
         </div>

  </div>
 </div>
</template>
<script>
import moment from "moment";
import { BellIcon } from "@heroicons/vue/solid";
import {usePage} from "@inertiajs/inertia-vue3"
export default {
  components: {
    BellIcon,
  },
  setup() {
    const notifications = usePage().props.value.notifications
    function readNow(item) {
      axios.get(`/notifications/${item.id}/mark`).then((res) => {
        if (res.status === 200) {
          window.location.href = item.data.url;
        }
      });
    }
    function markAsRead(){
       axios.get(`/mark/notifications`).then((res) => {
        if (res.status === 200) {
         notifications.value = res.data
        }
      });
    }
    return {
      moment,
      readNow,
      markAsRead,
      notifications
    };
  },
};
</script>
<style lang="">
</style>
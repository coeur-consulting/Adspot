<template lang="">
  <div class="h-[300px] w-full flex justify-center items-center banner">
    <div class="z-10 relative text-center">
      <h1 class="capitalize font-bold text-2xl text-white text-center mb-4">{{title}}</h1>
     <span > <a  v-for="item in breadcrumbs" :key="item.name"  :href="item.url" class="breadcrumbs text-sm">
       <span class="text-white capitalize breadcrumb"> {{item.name}}</span>
     </a>
     </span>

    </div>

  </div>
</template>
<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  breadcrumbs: {
    type: Object,
  },
});
</script>
<style lang="scss" scoped>
.banner {
  position: relative;
  background-image: url("/images/banner.png");
  background-size: cover;
  background-position: center;
  &::after {
    content: "";
    background: rgba(0, 0, 0, 0.4);
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: 1;
  }
}
a {
  span {
    text-transform: capitalize;
    color: rgb(249, 115, 22);
    &::after {
      content: ">";
      margin: 0 0.3rem;
      color: white;
    }
  }

  &:last-child span {
    color: white;
    &::after {
      content: "";
    }
  }
}
</style>
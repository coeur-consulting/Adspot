<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="bg-gray-100 p-2 md:p-4">
        <h6 class="font-bold text-xs mb-3 text-center md:hidden">Categories</h6>
        <div class="container mx-auto md:flex items-center text-center">
            <div
                class="px-1 md:px-6 py-1 rounded-full md:mr-5 capitalize text-xs"
                @click="setCategory(0)"
                :class="
                    !active ? 'text-orange-500 bg-gray-200' : 'bg-transparent'
                "
            >
                All
            </div>
            <div
                class="px-1 md:px-6 py-1 text-xs rounded-full md:mr-5 capitalize"
                @click="setCategory(item.id)"
                :class="
                    active === item.id
                        ? 'text-orange-500 bg-gray-200'
                        : 'bg-transparent'
                "
                v-for="item in $page.props.categories"
                :key="item.id"
            >
                {{ item.name }}
            </div>
        </div>
    </div>
</template>

<script>
import { ref, inject, onMounted, onBeforeMount } from "vue";

export default {
    setup() {
        const emitter = inject("emitter");
        const active = ref(0);
        const setCategory = (data) => {
            active.value = data;
            emitter.emit("getCategory", data);
        };

        onBeforeMount(() => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has("category")) {
                setCategory(Number(urlParams.get("category")));
            }
        });
        return {
            active,
            setCategory,
        };
    },
};
</script>
<style scoped lang="scss">
nav {
}
</style>

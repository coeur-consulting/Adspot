<template >
 <Head title="Checkout" />
 <Navigation />
 <div class="bg-white">
    <Checkout />
 </div>
</template>
<script>
import { Head } from '@inertiajs/inertia-vue3';
import Checkout from '@/MarketPlace/Components/Checkout'
import Navigation from "@/Navigation/GeneralHeader";
export default {
components: {
Checkout,
Head,
Navigation
}
}
</script>
<style lang="">

</style>
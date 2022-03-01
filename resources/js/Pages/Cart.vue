<template >
 <Head title="My Cart" />
 <Navigation />
 <div class="bg-white">
    <Cart />
 </div>
 <Footer/>
</template>
<script>
import { Head } from '@inertiajs/inertia-vue3';
import Cart from '@/MarketPlace/Components/MainCart'
import Navigation from "@/Navigation/GeneralHeader";
import Footer from '@/Navigation/Footer'
export default {
components: {
Cart,
Head,
Navigation,
Footer
}
}
</script>
<style lang="">

</style>
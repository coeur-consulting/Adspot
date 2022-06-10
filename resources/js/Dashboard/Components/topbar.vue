<template lang="">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="p-8 shadow bg-white rounded-md flex justify-between items-center"
        >
            <div class="h-full w-full flex items-center">
                <MapIcon
                    class="w-16 md:w-20 h-16 md:h-20 px-3 py-4 bg-orange-600 text-white rounded-full mr-5"
                />
                <div class="text-left">
                    <Link href="/products">
                        <span
                            class="font-bold text-xl md:text-2xl text-slate-600"
                            >{{ $page.props.total_products }} Ad Spaces</span
                        ></Link
                    >
                </div>
            </div>
        </div>
        <div
            class="p-8 shadow bg-white rounded-md flex justify-between items-center"
        >
            <div class="h-full w-full flex items-center">
                <SpeakerphoneIcon
                    class="w-16 md:w-20 h-16 md:h-20 px-3 py-4 bg-orange-600 text-white rounded-full mr-5"
                />
                <div class="text-left">
                    <Link href="/products?showing=active">
                        <span
                            class="font-bold text-xl md:text-2xl text-slate-600"
                            >{{ $page.props.active_spaces }} Active Spaces</span
                        >
                    </Link>
                </div>
            </div>
        </div>
        <div
            class="p-8 shadow bg-white rounded-md flex justify-between items-center"
        >
            <div class="h-full w-full flex items-center">
                <CreditCardIcon
                    class="w-16 md:w-20 h-16 md:h-20 px-3 py-4 bg-orange-600 text-white rounded-full mr-5"
                />
                <div class="text-left">
                    <Link  href="/all-offers">
                        <span
                            class="font-bold text-xl md:text-2xl text-slate-600"
                            >{{ $page.props.total_offers }} Total Offers</span
                        >
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {
    MapIcon,
    SpeakerphoneIcon,
    CreditCardIcon,
} from "@heroicons/vue/solid";
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        MapIcon,
        SpeakerphoneIcon,
        CreditCardIcon,
        Link,
    },
};
</script>
<style lang=""></style>

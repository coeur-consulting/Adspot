<template>
    <section id="categories" class="px-6 xl:px-0 py-24 relative">
        <div class="container mx-auto relative">
            <div class="flex justify-between items-center mb-4">
                <h6 class="font-bolder">Categories</h6>
                <span
                    class="text-xs text-orange-500 font-bold flex items-center"
                    >View all <ArrowNarrowRightIcon class="ml-2 w-4"
                /></span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                <Link href="/inventory?category=4">
                    <div
                        class="... h-32 md:h-60 rounded-lg box bg1 shadow-sm overflow-hidden hover:scale-105 transition ease-in-out duration-300"
                    >
                        <span
                            class="bg-white text-black rounded-full px-5 py-1 text-sm absolute bottom-3 right-3 z-10"
                            >Online</span
                        >
                    </div>
                </Link>
                <Link href="/inventory?category=5">
                    <div
                        class="... h-32 md:h-60 rounded-lg box bg2 shadow-sm hover:scale-105 transition ease-in-out duration-300"
                    >
                        <span
                            class="bg-white text-black rounded-full px-5 py-1 text-sm absolute bottom-3 right-3 z-10"
                            >Radio</span
                        >
                    </div>
                </Link>

                <Link href="/inventory?category=3">
                    <div
                        class="... h-32 md:h-60 rounded-lg box bg3 shadow-sm hover:scale-105 transition ease-in-out duration-300"
                    >
                        <span
                            class="bg-white text-black rounded-full px-5 py-1 text-sm absolute bottom-3 right-3 z-10"
                            >Television</span
                        >
                    </div>
                </Link>

                <Link href="/inventory?category=2">
                    <div
                        class=".. h-32 md:h-60 rounded-lg box bg4 shadow-sm hover:scale-105 transition ease-in-out duration-300"
                    >
                        <span
                            class="bg-white text-black rounded-full px-5 py-1 text-sm absolute bottom-3 right-3 z-10"
                            >Print</span
                        >
                    </div>
                </Link>

                <Link href="/inventory?category=1" class="col-span-2">
                    <div
                        class="... h-32 md:h-60 rounded-lg box bg5 shadow-sm hover:scale-105 transition ease-in-out duration-300"
                    >
                        <span
                            class="bg-white text-black rounded-full px-5 py-1 text-sm absolute bottom-3 right-3 z-10"
                            >Out of home</span
                        >
                    </div>
                </Link>
            </div>

            <div></div>
            <span class="absolute top-[-15%] right-[-14%] z-[1]"
                ><img src="/images/spiral.png"
            /></span>
        </div>
    </section>
</template>
<script>
import { ArrowNarrowRightIcon } from "@heroicons/vue/solid";
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        ArrowNarrowRightIcon,
        Link,
    },
};
</script>
<style lang="scss" scoped>
.box {
    position: relative;
    overflow: hidden;
    z-index: 2;
    &::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }
}
.bg1 {
    background: url("/images/online.png");
    background-size: cover;
    background-position: center;
}
.bg2 {
    background: url("/images/radio.png");
    background-size: cover;
    background-position: center;
}
.bg3 {
    background: url("/images/tv.png");
    background-size: cover;
    background-position: center;
}
.bg4 {
    background: url("/images/print.png");
    background-size: cover;
    background-position: center;
}
.bg5 {
    background: url("/images/outhome.png");
    background-size: cover;
    background-position: center;
}
</style>

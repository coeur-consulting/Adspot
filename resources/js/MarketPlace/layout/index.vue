<template lang="">
    <Head title="Marketplace" />
    <Navigation />
    <div class="hidden md:block">
        <TopBar class="w-full" />
        <Filter class="w-full" />
    </div>
    <div class="bg-gray-50 p-3 md:hidden flex text-xs">
        <span @click="open = true" class="flex text-sm items-center"
            ><span class="font-bold mr-1">Filter</span>
            <FilterIcon class="w-4 h-4"
        /></span>
    </div>
    <div class="pb-10 md:min-h-[40vh]">
        <MainPage />
    </div>
    <Footer />
    <TransitionRoot as="template" :show="open">
        <Dialog
            as="div"
            class="fixed z-10 inset-0 overflow-y-auto"
            @close="open = false"
        >
            <div
                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
            >
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay
                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span
                    class="hidden sm:inline-block sm:align-middle sm:h-screen"
                    aria-hidden="true"
                    >&#8203;</span
                >
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <MobileFilter />
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-3 sm:px-3 sm:flex sm:flex-row-reverse"
                        >
                            <button
                                type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                @click="open = false"
                                ref="cancelButtonRef"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
<script>
import Navigation from "@/Navigation/GeneralHeader.vue";
import Footer from "@/Navigation/Footer.vue";
import TopBar from "./topbar";
import Filter from "./filter";
import MainPage from "./mainpage";
import MobileFilter from "./mobilefilter";
import { FilterIcon } from "@heroicons/vue/outline";
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ref } from "vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        TopBar,
        Filter,
        MainPage,
        Navigation,
        Footer,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        MobileFilter,
        FilterIcon,
        Head,
    },
    setup() {
        const open = ref(false);

        const urlParams = new URLSearchParams(window.location.search);
        if (
            urlParams.has("toggle") &&
            urlParams.get("toggle") === "search" &&
            window.innerWidth < 768
        ) {
            open.value = true;
        }
        function ToggleModal() {
            open.value = true;
        }
        return {
            open,
            ToggleModal,
        };
    },
};
</script>
<style lang="scss" scoped>
.main_body {
    height: auto;
}
</style>

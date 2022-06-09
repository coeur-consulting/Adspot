<template>
    <paystack
        buttonClass=" flex
                  justify-center
                  items-center
                  px-8
                  py-2
                  border border-transparent
                  rounded-full
                  shadow-sm
                  text-base
                  font-medium
                  text-white
                  bg-orange-500
                  hover:bg-orange-400
                mx-auto paystack"
        buttonText="Proceed to payment"
        :publicKey="publicKey"
        :email="email"
        :amount="amount * 100"
        :reference="reference"
        :onSuccess="onSuccessfulPayment"
        :onCanel="onCancelledPayment"
        :disabled="disabled"
        v-if="!disabled"
    >
    </paystack>

    <TransitionRoot as="template" :show="openModal">
        <Dialog
            as="div"
            class="fixed z-10 inset-0 overflow-y-auto"
            @close="openModal = false"
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
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full"
                    >
                        <div class="p-5">
                            <div
                                class="text-center flex flex-col items-center"
                                v-if="isVerified === null"
                            >
                                <p class="mb-3 font-bold">
                                    Confirming your order..
                                </p>
                                <div
                                    class="bg-orange-300 transition ease-in-out rounded-full"
                                >
                                    <svg
                                        class="animate-spin mx-auto h-24 w-24 text-white"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <div
                                class="text-center flex flex-col items-center"
                                v-if="isVerified === true"
                            >
                                <CheckCircleIcon
                                    class="w-24 h-24 text-green-500 mb-5"
                                />
                                <p class="mb-3 font-bold">
                                    Confirmation Successful
                                </p>
                                <div>
                                    <button
                                        class="text-white bg-orange-600 rounded-full px-5 py-1"
                                        @click="gohome"
                                    >
                                        Back to Marketplace
                                    </button>
                                </div>
                            </div>
                            <div
                                class="text-center flex flex-col items-center"
                                v-if="isVerified === false"
                            >
                                <XCircleIcon
                                    class="w-24 h-24 text-red-500 mb-5"
                                />
                                <p class="font-bold">Confirmation Failed</p>
                                <p class="text-xs text-red-500 mb-8">
                                    Please contact Adspot support
                                </p>
                                <div>
                                    <button
                                        class="text-white bg-orange-600 rounded-full px-5 py-1"
                                        @click="gohome"
                                    >
                                        Back to Marketplace
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import paystack from "vue3-paystack";
import { ref, computed, inject } from "vue";
import axios from "axios";
import {
    TrashIcon,
    InformationCircleIcon,
    CheckCircleIcon,
    XCircleIcon,
} from "@heroicons/vue/outline";
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
export default {
    components: {
        paystack,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        TrashIcon,
        InformationCircleIcon,
        CheckCircleIcon,
        XCircleIcon,
    },
    props: ["email", "amount", "disabled"],
    inject: ["emitter", "currency"],
    // pk_live_79e5c35b87ad20b3532d42afbc3fc7bf8918efc9

    setup() {
        const openModal = ref(false);
        const emitter = inject("emitter");
        const publicKey = ref(
            "pk_test_ad2c33c491aa0e4959fb647f8935f93209066b06"
        );
        const isVerified = ref(null);
        function onSuccessfulPayment(response) {
            openModal.value = true;
            axios
                .post("orders", response)
                .then((res) => {
                    if (res.status === 200) {
                        clearcart();
                    }
                })
                .catch(() => {
                    isVerified.value = false;
                });
        }
        function onCancelledPayment() {
            console.log("cancelled");
        }

        function clearcart() {
            axios.get(`/clear/cart`).then((res) => {
                if (res.status === 200) {
                    isVerified.value = true;
                    emitter.emit("addtocart");
                }
            });
        }
        const reference = computed(() => {
            let text = "";
            let possible =
                "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (let i = 0; i < 10; i++)
                text += possible.charAt(
                    Math.floor(Math.random() * possible.length)
                );

            return text;
        });
        function gohome() {
            window.location.href = "/inventory";
        }

        return {
            gohome,
            onSuccessfulPayment,
            onCancelledPayment,
            reference,
            publicKey,
            openModal,

            isVerified,
        };
    },
};
</script>

<style scoped>
.text-white span {
    color: white;
}
</style>

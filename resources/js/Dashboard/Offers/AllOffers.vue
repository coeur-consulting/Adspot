<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="mb-5">
        <ul class="breadcrumb text-xs">
            <li><a href="/dashboard">Dashboard</a></li>

            <li class="capitalize">All offers</li>
        </ul>
    </div>
    <div class="flex items-center mb-5">
        <span
            class="text-sm md:text-base"
            :class="!enabled ? 'text-gray-400' : 'text-gray-800'"
            >Pending offers</span
        >
        <Switch
            v-model="enabled"
            class="bg-orange-700 relative inline-flex h-6 w-11 items-center rounded-full mx-4"
        >
            <span
                :class="!enabled ? 'translate-x-6' : 'translate-x-1'"
                class="inline-block h-4 w-4 transform rounded-full bg-white"
            />
        </Switch>
        <span
            class="text-sm md:text-base"
            :class="enabled ? 'text-gray-400' : 'text-gray-800'"
            >Responded offers</span
        >
    </div>
    <AnsweredOffers v-if="!enabled"  />
    <PendingOffers v-if="enabled" />

</template>

<script>
import { ref } from "vue";
import { ExclamationIcon, CheckIcon, XIcon } from "@heroicons/vue/outline";
import { PlusCircleIcon } from "@heroicons/vue/solid";
import moment from "moment";
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    Switch,
} from "@headlessui/vue";
import AnsweredOffers from "./AnsweredOffers"
import PendingOffers from "./PendingOffers"
export default {
    setup() {
        const open = ref(false);

        return {
            open,
            moment,
        };
    },
    inject: ["emitter", "currency"],
    data() {
        return {
            offers: [],
            days: [],
            dateType: "custom",
            offer: {},
            enabled: true,
        };
    },
    mounted() {
        this.offers = this.$page.props.offers;
    },
    methods: {
        viewDays(val, dateType, offer) {
            this.dateType = dateType;
            this.days = val;
            this.open = true;
            this.offer = offer;
        },
        handleOffer(type, id) {
            let info = { id, type };
            axios.post("/handle/offers", info).then((res) => {
                if (type === "reject") {
                    this.offers = this.offers.slice().map((item) => {
                        if (item.id === id) {
                            item.result = res.data.result;
                            item.status = res.data.status;
                        }
                        return item;
                    });
                } else {
                    this.offers = res.data;
                }
            });
        },
    },
    components: {
        CheckIcon,
        XIcon,
        PlusCircleIcon,
        ExclamationIcon,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        Switch,
        AnsweredOffers,
        PendingOffers
    },
};
</script>

<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="mb-5">
        <ul class="breadcrumb text-xs">
            <li><a href="/dashboard">Dashboard</a></li>
            <li>Categories</li>
        </ul>
    </div>
    <div class="grid grid-cols-2 gap-12">
        <div>
            <div class="flex justify-start mb-6">
                <button
                    @click="toggleModal('create')"
                    type="button"
                    class="font-bold px-4 py-2 text-sm whitespace-nowrap relative cursor-pointer border border-transparent rounded-md shadow-sm bg-orange-700 hover:bg-orange-500 flex justify-between"
                >
                    <PlusCircleIcon class="w-4 h-4 mr-1 text-white" />
                    <span class="text-white">Add category</span>
                </button>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="py-2 align-middle inline-block min-w-full sm:px-3 lg:px-8"
                    >
                        <div
                            class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                        >
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <!-- <th
                                            scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Image
                                        </th> -->
                                        <th
                                            scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Category
                                        </th>

                                        <th
                                            scope="col"
                                            class="relative px-3 py-3"
                                        >
                                            <span class="sr-only">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr
                                        v-for="category in categories"
                                        :key="category.id"
                                        :class="
                                            active.id == category.id
                                                ? 'bg-gray-50'
                                                : ''
                                        "
                                    >
                                        <!-- <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10"
                                                >
                                                    <img
                                                        class="h-10 w-10 rounded-full"
                                                        :src="category.image"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                        </td> -->
                                        <td
                                            class="px-3 py-4 whitespace-nowrap cursor-pointer"
                                            @click="getsubcategories(category)"
                                        >
                                            <div class="flex items-center">
                                                <div class="">
                                                    <div
                                                        class="text-sm font-medium text-gray-900 capitalize"
                                                    >
                                                        {{ category.name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td
                                            class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium"
                                        >
                                            <span
                                                @click="
                                                    toggleModal(
                                                        'edit',
                                                        category
                                                    )
                                                "
                                                class="mr-3 text-indigo-600 hover:text-indigo-900 cursor-pointer"
                                                >Edit</span
                                            >
                                            <span
                                                @click="
                                                    dropCategory(category.id)
                                                "
                                                class="text-red-600 hover:text-red-900 cursor-pointer"
                                                >Delete</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="flex justify-start mb-6">
                <button
                    @click="toggleModal('createsub')"
                    type="button"
                    class="font-bold px-4 py-2 text-sm whitespace-nowrap relative cursor-pointer border border-transparent rounded-md shadow-sm bg-orange-700 hover:bg-orange-500 flex justify-between"
                >
                    <PlusCircleIcon class="w-4 h-4 mr-1 text-white" />
                    <span class="text-white">Add subcategory</span>
                </button>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="py-2 align-middle inline-block min-w-full sm:px-3 lg:px-8"
                    >
                        <div
                            class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                        >
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-3 py-3 text-left text-sm font-bold text-gray-500 tracking-wider"
                                        >
                                            <span class="capitalize">
                                                {{ active.name }}</span
                                            >
                                            subcategories
                                        </th>

                                        <th
                                            scope="col"
                                            class="relative px-3 py-3"
                                        >
                                            <span class="sr-only">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr
                                        v-for="category in subcat"
                                        :key="category.id"
                                    >
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div
                                                        class="text-sm font-medium text-gray-900 capitalize"
                                                    >
                                                        {{ category.name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td
                                            class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium"
                                        >
                                            <span
                                                @click="
                                                    toggleModal(
                                                        'editsub',
                                                        category
                                                    )
                                                "
                                                class="mr-3 text-indigo-600 hover:text-indigo-900 cursor-pointer"
                                                >Edit</span
                                            >
                                            <span
                                                @click="
                                                    dropSubCategory(category.id)
                                                "
                                                class="text-red-600 hover:text-red-900 cursor-pointer"
                                                >Delete</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <CreateCategory
                                @updatepage="updatepage"
                                v-if="type == 'create'"
                            />
                            <CreateSubCategory
                                @updatepage="updatepage"
                                :categories="categories"
                                v-if="type == 'createsub'"
                            />
                            <EditCategory
                                :category="category"
                                @updatepage="updatepage"
                                v-if="type == 'edit'"
                            />

                            <EditSubCategory
                                :categories="categories"
                                :subcategory="subcategory"
                                @updatepage="updatepage"
                                v-if="type == 'editsub'"
                            />
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
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationIcon } from "@heroicons/vue/outline";
import CreateCategory from "./CreateCategory";
import EditCategory from "./EditCategory";
import CreateSubCategory from "./CreateSubCategory";
import EditSubCategory from "./EditSubCategory";
import { PlusCircleIcon } from "@heroicons/vue/solid";

export default {
    props: ["categories", "subcategories"],

    components: {
        PlusCircleIcon,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationIcon,
        CreateSubCategory,
        EditSubCategory,
        CreateCategory,
        EditCategory,
    },
    data() {
        return {
            open: false,
            type: "",
            category: {},
            active: 1,
            subcat: [],
            subcategory: {},
        };
    },
    mounted() {
        this.active = this.$props.categories[0];
        axios.get(`get-subcategories/${1}`).then((res) => {
            this.subcat = res.data;
        });
    },
    methods: {
        toggleModal(val, category) {
            this.open = !this.open;
            this.type = val;
            this.category = category;
            this.subcategory = category;
        },
        getsubcategories(val) {
            axios.get(`get-subcategories/${val.id}`).then((res) => {
                this.subcat = res.data;
                this.active = val;
            });
        },
        updatepage() {
            this.open = false;
            this.getsubcategories(this.active);
        },
        dropCategory(id) {
            var res = confirm("Are you sure");
            if (res) {
                this.$inertia.delete(`/delete-category/${id}`);
            }
        },
        dropSubCategory(id) {
            var res = confirm("Are you sure");
            if (res) {
                axios.delete(`/delete-subcat/${id}`).then(() => {
                    this.getsubcategories(this.active);
                });
            }
        },
    },
};
</script>

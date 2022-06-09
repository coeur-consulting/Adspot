<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="mb-5">
        <ul class="breadcrumb text-xs">
            <li><a href="/dashboard">Dashboard</a></li>
            <li>News</li>
        </ul>
    </div>
    <div class="flex justify-end mb-6">
        <div class="flex justify-between mb-3 w-full">
            <div class="flex items-center">
                <input
                    placeholder="Search title"
                    v-model="query"
                    type="search"
                    class="py-2 px-4 border border-gray-50 rounded-lg md:w-[250px] mr-4 shadow-sm"
                />

                <div class="mr-3 flex">
                    <BreezeCheckbox
                        id="active"
                        class="mr-2"
                        v-model="showStatus"
                    />
                    <BreezeLabel for="active" value="Inactive" />
                </div>
            </div>
            <div>
                <button
                    @click="toggleModal('create')"
                    type="button"
                    class="font-bold px-4 py-2 text-sm whitespace-nowrap relative cursor-pointer border border-transparent rounded-md shadow-sm bg-orange-500 hover:bg-orange-500 flex justify-between"
                >
                    <PlusCircleIcon class="w-4 h-4 mr-1 text-white" />
                    <span class="text-white">Add news</span>
                </button>
            </div>
        </div>
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
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    S/N
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    title
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Description
                                </th>

                                <th
                                    scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Status
                                </th>
                                <th
                                    scope="col"
                                    class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    <span class="">Toggle Status</span>
                                </th>
                                <th
                                    scope="col"
                                    class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    <span class="">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="(item, index) in filteredBlogs"
                                :key="item.id"
                            >
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ index + 1 }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-6 w-6"
                                            v-if="item.cover"
                                        >
                                            <img
                                                class="h-6 w-6 rounded-full"
                                                :src="item.cover"
                                                alt=""
                                            />
                                        </div>
                                        <div class="ml-2">
                                            <div
                                                class="text-sm font-medium text-gray-900 truncate overflow-hidden ..."
                                            >
                                                {{ item.title }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div
                                        class="text-sm text-gray-900 text-ellipsis overflow-hidden ... w-[160px]"
                                    >
                                        {{ item.content }}
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <span
                                        class="text-sm rounded-full py-1 px-3"
                                        :class="
                                            item.status
                                                ? 'text-green-500 bg-green-100'
                                                : 'text-red-500 bg-red-100'
                                        "
                                    >
                                        {{
                                            item.status ? "Active" : "Inactive"
                                        }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex justify-center">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm"
                                                @change="
                                                    updatestatus(
                                                        item.id,
                                                        item.status
                                                    )
                                                "
                                                :checked="
                                                    item.status ? true : false
                                                "
                                                type="checkbox"
                                                role="switch"
                                                id="flexSwitchCheckDefault"
                                            />
                                            <!-- <label
                        class="form-check-label inline-block text-gray-800"
                        for="flexSwitchCheckDefault"
                        >Default switch checkbox input</label
                      > -->
                                        </div>
                                    </div>
                                </td>

                                <td
                                    class="px-3 py-4 whitespace-nowrap text-sm font-medium"
                                >
                                    <Popover class="relative">
                                        <PopoverButton>
                                            <span class="sr-only">
                                                Actions</span
                                            >
                                            <span class="relative">
                                                <DotsVerticalIcon
                                                    class="h-4 w-4"
                                                    aria-hidden="true"
                                                />
                                            </span>
                                        </PopoverButton>

                                        <transition
                                            enter-active-class="transition duration-200 ease-out"
                                            enter-from-class="translate-y-1 opacity-0"
                                            enter-to-class="translate-y-0 opacity-100"
                                            leave-active-class="transition duration-150 ease-in"
                                            leave-from-class="translate-y-0 opacity-100"
                                            leave-to-class="translate-y-1 opacity-0"
                                        >
                                            <PopoverPanel
                                                class="absolute z-40 p-4 mt-3 right-0 sm:px-0 lg:max-w-sm bg-white rounded-lg shadow-lg py-4"
                                            >
                                                <div
                                                    class="overflow-hidden px-3 py-2 flex"
                                                >
                                                    <span
                                                        @click="
                                                            toggleModal(
                                                                'view',
                                                                item
                                                            )
                                                        "
                                                        class="mr-3 flex"
                                                    >
                                                        <span
                                                            class="text-xs mr-1"
                                                            >View</span
                                                        >
                                                        <EyeIcon
                                                            class="w-4 h-4"
                                                        />
                                                    </span>
                                                    <span
                                                        @click="
                                                            toggleModal(
                                                                'edit',
                                                                item
                                                            )
                                                        "
                                                        class="mr-3 flex"
                                                    >
                                                        <span
                                                            class="text-xs mr-1"
                                                            >Edit</span
                                                        >
                                                        <PencilAltIcon
                                                            class="w-4 h-4"
                                                        />
                                                    </span>
                                                    <span
                                                        @click="
                                                            dropBlog(item.id)
                                                        "
                                                        class="flex"
                                                    >
                                                        <span
                                                            class="text-xs mr-1"
                                                            >Delete</span
                                                        >
                                                        <TrashIcon
                                                            class="w-4 h-4"
                                                        />
                                                    </span>
                                                </div>
                                            </PopoverPanel>
                                        </transition>
                                    </Popover>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="pagination flex justify-between text-center mt-8 px-3">
        <div>
            <p class="text-sm text-gray-500 mb-0">
                Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }}
            </p>
        </div>
        <span class="flex justify-center items-center">
            <span
                ><ArrowCircleLeftIcon
                    :class="
                        links.prev
                            ? 'text-orange-700'
                            : 'opacity-55 text-slate-300'
                    "
                    @click="prev"
                    class="cursor-pointer w-8 h-8 mr-2"
            /></span>
            <input
                class="form-input w-12 py-1 px-3 text-center border border-orange-700 rounded"
                :disabled="!links.next"
                v-model="current_page" />
            <span class="font-bold ml-2 text-sm">of {{ meta.last_page }}</span>
            <span
                ><ArrowCircleRightIcon
                    :class="
                        links.next
                            ? 'text-orange-700'
                            : 'opacity-55 text-slate-300'
                    "
                    @click="next"
                    class="w-8 h-8 ml-2 cursor-pointer" /></span
        ></span>
    </div>

    <!-- This example requires Tailwind CSS v2.0+ -->

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
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-[80%] sm:w-full"
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <CreateBlog
                                @updatepage="updatepage"
                                v-if="type == 'create'"
                            />
                            <EditBlog
                                :blog="blog"
                                @updatepage="updatepage"
                                v-if="type == 'edit'"
                            />
                            <ViewBlog
                                @updatepage="updatepage"
                                :blog="blog"
                                v-if="type == 'view'"
                            />
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
import {
    ExclamationIcon,
    ArrowCircleLeftIcon,
    ArrowCircleRightIcon,
} from "@heroicons/vue/outline";
import CreateBlog from "./CreateBlog";
import EditBlog from "./EditBlog";
import { PlusCircleIcon } from "@heroicons/vue/solid";
import {
    EyeIcon,
    TrashIcon,
    PencilAltIcon,
    DotsVerticalIcon,
} from "@heroicons/vue/outline";
import { usePage } from "@inertiajs/inertia-vue3";
import { ref, onMounted, computed, watch, inject, reactive } from "vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeLabel from "@/Components/Label.vue";
import { Switch } from "@headlessui/vue";
import ViewBlog from "./ViewBlog";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
export default {
    inject: ["emitter", "currency"],
    components: {
        PlusCircleIcon,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationIcon,
        DotsVerticalIcon,
        CreateBlog,
        EditBlog,
        ArrowCircleLeftIcon,
        ArrowCircleRightIcon,
        BreezeCheckbox,
        BreezeLabel,
        Switch,
        ViewBlog,
        Popover,
        PopoverButton,
        PopoverPanel,
        EyeIcon,
        TrashIcon,
        PencilAltIcon,
    },
    data() {
        return {
            open: false,
            type: "",
        };
    },
    setup() {
        const blogs = ref([]);
        const query = ref("");
        const current_page = ref(1);
        const showFeatured = ref(false);
        const showStatus = ref(false);
        const last_page = ref(1);
        const enabled = ref(false);
        const meta = ref({});
        const links = ref({});
        blogs.value = usePage().props.value.blogs.data;
        last_page.value = usePage().props.value.blogs.last_page;
        meta.value = usePage().props.value.blogs.meta;
        links.value = usePage().props.value.blogs.links;
        const filteredBlogs = computed(() => {
            return showStatus.value
                ? blogs.value.filter((item) => !item.status)
                : blogs.value;
        });
        const searchBlogs = () => {
            if (!query.value) {
                blogs.value = usePage().props.value.blogs.data;
                last_page.value = usePage().props.value.blogs.last_page;
                meta.value = usePage().props.value.blogs.meta;
                links.value = usePage().props.value.blogs.links;

                return;
            }
            axios.get(`/searchblogs?query=${query.value}`).then((res) => {
                blogs.value = res.data.data;
                current_page.value = 1;
                meta.value = res.data.meta;
                links.value = res.data.links;
            });
        };
        function next() {
            if (!links.value.next) return;
            current_page.value++;
        }
        function prev() {
            if (!links.value.prev) return;
            current_page.value--;
        }
        function getblogs(page) {
            axios.get(`get-blogs?page=${page}`).then((res) => {
                if (res.status === 200) {
                    blogs.value = res.data.data;
                    last_page.value = res.data.last_page;
                    meta.value = res.data.meta;
                    links.value = res.data.links;
                }
            });
        }

        watch(current_page, (current_page, prevCurrent_page) => {
            getblogs(current_page);
        });

        watch(
            query,
            _.debounce(() => {
                searchBlogs();
            }, 2000)
        );
        return {
            blogs,
            last_page,
            next,
            prev,
            query,
            current_page,
            filteredBlogs,
            showStatus,
            showFeatured,
            enabled,
            meta,
            links,
        };
    },
    methods: {
        updatestatus(id, value) {
            axios
                .put(this.route("blogs.update", id), { status: !value })
                .then((res) => {
                    if (res.status === 200) {
                        this.blogs = this.blogs.slice().map((item) => {
                            if (item.id == id) {
                                item.status = res.data.status;
                            }
                            return item;
                        });
                    }
                });
        },

        toggleModal(val, blog) {
            this.open = !this.open;
            this.type = val;
            this.blog = blog;
        },
        updatepage(data) {
            if (this.type == "edit") {
                this.blogs.map((item) => {
                    if (item.id == this.blog.id) {
                        item = data;
                    }
                    return item;
                });
            } else {
                this.blogs.unshift(data);
            }
            this.open = false;
        },
        dropBlog(id) {
            var res = confirm("Are you sure");
            if (res) {
                this.$inertia.delete(`/blogs/${id}`);
            }
        },
    },
};
</script>

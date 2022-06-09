

<template>
  <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
    <div class="max-w-7xl mx-auto px-4 sm:px-3 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <img
              class="h-8 w-auto"
              src="/images/logo-orange.png"
              alt="Workflow"
            />
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <a
                v-for="item in navigation"
                :key="item.name"
                :href="item.href"
                :class="[
                  $page.url === item.href
                    ? 'bg-gray-900 text-white'
                    : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                  'px-3 py-2 rounded-md text-sm font-medium',
                ]"
                :aria-current="item.current ? 'page' : undefined"
                >{{ item.name }}</a
              >
            </div>
          </div>
        </div>
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <!-- Notiifcations dropdown -->
            <Popover v-slot="{ openNotification }" class="relative">
              <PopoverButton
                :class="openNotification ? '' : 'text-opacity-90'"
                class="
                  bg-gray-800
                  p-1
                  rounded-full
                  text-gray-400
                  hover:text-white
                  focus:outline-none
                  focus:ring-2
                  focus:ring-offset-2
                  focus:ring-offset-gray-800
                  focus:ring-white
                  relative
                "
              >
                <span class="sr-only">View notifications</span>
                <span class="relative">
                  <BellIcon class="h-6 w-6" aria-hidden="true" />
                </span>
                <span
                  class="
                    py-[.01rem]
                    px-1
                    text-xs
                    bg-red-500
                    text-white
                    absolute
                    top-[-1px]
                    right-[-1px]
                    rounded-lg
                  "
                  v-if="unreadnotifications"
                  >{{ unreadnotifications }}</span
                >
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
                  class="
                    absolute
                    z-40
                    w-[300px]
                    max-w-sm
                    p-4
                    mt-3
                    right-0
                    sm:px-0
                    lg:max-w-sm
                    bg-white
                    rounded-lg
                    shadow-lg
                    ring-1 ring-black ring-opacity-5
                    py-4
                  "
                >
                  <div class="overflow-hidden">
                    <h6 class="mb-2 font-black px-4">Notifications</h6>
                    <hr />
                    <ul class="px-4 max-h-[450px] overflow-auto">
                      <li
                        v-for="item in notifications"
                        :key="item.name"
                        class="border-b py-2 cursor-pointer"
                      >
                        <p
                          class="text-sm mb-2"
                          :class="item.read_at ? '' : 'font-extrabold'"
                          @click="readNow(item)"
                        >
                          {{ item.data.body }}
                        </p>

                        <div class="text-right">
                          <p class="text-xs">
                            {{ moment(item.created_at).fromNow() }}
                          </p>
                        </div>
                      </li>
                    </ul>
                    <hr />

                    <div class="text-center">
                      <Link href="/admin/notifications">
                        <span class="text-xs mx-auto cursor-pointer">View all</span></Link
                      >
                    </div>
                  </div>
                </PopoverPanel>
              </transition>
            </Popover>

            <!-- Profile dropdown -->
            <Menu as="div" class="ml-3 relative">
              <div>
                <MenuButton
                  class="
                    max-w-xs
                    bg-gray-800
                    rounded-full
                    flex
                    items-center
                    text-sm
                    focus:outline-none
                    focus:ring-2
                    focus:ring-offset-2
                    focus:ring-offset-gray-800
                    focus:ring-white
                  "
                >
                  <span class="sr-only">Open user menu</span>
                  <UserCircleIcon class="w-8 h-8" />
                </MenuButton>
              </div>
              <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems
                  class="
                    origin-top-right
                    absolute
                    right-0
                    mt-2
                    w-48
                    rounded-md
                    shadow-lg
                    py-1
                    bg-white
                    ring-1 ring-black ring-opacity-5
                    focus:outline-none
                  "
                >
                  <MenuItem
                    v-for="item in userNavigation"
                    :key="item.name"
                    v-slot="{ active }"
                  >
                    <Link
                      :href="item.href"
                      :method="item.method"
                      as="button"
                      :class="[
                        active ? 'bg-gray-100' : '',
                        'block px-4 py-2 text-sm text-gray-700',
                      ]"
                      >{{ item.name }}</Link
                    >
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
        <div class="-mr-2 flex md:hidden">
          <!-- Mobile menu button -->
          <DisclosureButton
            class="
              bg-gray-800
              inline-flex
              items-center
              justify-center
              p-2
              rounded-md
              text-gray-400
              hover:text-white hover:bg-gray-700
              focus:outline-none
              focus:ring-2
              focus:ring-offset-2
              focus:ring-offset-gray-800
              focus:ring-white
            "
          >
            <span class="sr-only">Open main menu</span>
            <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
      </div>
    </div>

    <DisclosurePanel class="md:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <DisclosureButton
          v-for="item in navigation"
          :key="item.name"
          as="a"
          :href="item.href"
          :class="[
            $page.url === item.href
              ? 'bg-gray-900 text-white'
              : 'text-gray-300 hover:bg-gray-700 hover:text-white',
            'block px-3 py-2 rounded-md text-base font-medium',
          ]"
          :aria-current="item.current ? 'page' : undefined"
          >{{ item.name }}</DisclosureButton
        >
      </div>
      <div class="pt-4 pb-3 border-t border-gray-700">
        <div class="flex items-center px-5">
          <div class="flex-shrink-0">
            <img
              class="h-10 w-10 rounded-full"
              :src="$page.props.auth.user.image"
              alt=""
            />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium leading-none text-white">
              {{ auth.user.name }}
            </div>
            <div class="text-sm font-medium leading-none text-gray-400">
              {{ auth.user.email }}
            </div>
          </div>
          <button
            type="button"
            class="
              ml-auto
              bg-gray-800
              flex-shrink-0
              p-1
              rounded-full
              text-gray-400
              hover:text-white
              focus:outline-none
              focus:ring-2
              focus:ring-offset-2
              focus:ring-offset-gray-800
              focus:ring-white
            "
          >
            <span class="sr-only">View notifications</span>
            <BellIcon class="h-6 w-6" aria-hidden="true" />
          </button>
        </div>
        <div class="mt-3 px-2 space-y-1">
          <DisclosureButton
            v-for="item in userNavigation"
            :key="item.name"
            class="
              block
              px-3
              py-2
              rounded-md
              text-base
              font-medium
              text-gray-400
              hover:text-white hover:bg-gray-700
            "
          >
            <Link
              :href="item.href"
              :method="item.method"
              as="button"
              class="block text-gray-100"
              >{{ item.name }}</Link
            >
          </DisclosureButton>
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import {
  BellIcon,
  MenuIcon,
  XIcon,
  UserCircleIcon,
} from "@heroicons/vue/outline";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import Index from "@/Dashboard/index";
import Products from "@/Dashboard/Products/index";
import Orders from "@/Dashboard/orders";
import { ref, onMounted } from "vue";
import moment from "moment";
const navigation = [
  { name: "Dashboard", href: "/dashboard", current: true },

  { name: "Products", href: "/products", current: false },
  { name: "Orders", href: "/view/orders", current: false },
  { name: "Categories", href: "/admin-categories", current: false },
  { name: "News", href: "/blogs", current: false },
    // { name: "Reports", href: "/reports", current: false },
];
const userNavigation = [
  // { name: "Your Profile", href: "/profile", method: "get" },

  { name: "Sign out", href: route("logout"), method: "post" },
];

export default {
  props: ["auth", "products"],
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    MenuIcon,
    XIcon,
    Index,
    Products,
    Orders,
    Link,
    Popover,
    PopoverButton,
    PopoverPanel,
    UserCircleIcon,
  },
  setup() {
    const openNotification = ref(false);
    const notifications = ref([]);
    const unreadnotifications = ref(0);
    function getnotifications() {
      axios.get("/notifications").then((res) => {
        if (res.status === 200) {
          notifications.value = res.data;
          unreadnotifications.value = notifications.value.filter(
            (item) => !item.read_at
          ).length;
        }
      });
    }
    function readNow(item) {
      axios.get(`/notifications/${item.id}/mark`).then((res) => {
        if (res.status === 200) {
          window.location.href = item.data.url;
        }
      });
    }
    onMounted(() => {

      if (usePage().props.value.auth.user) {
        getnotifications();


      //Join and listen for events
      Echo.private('App.Models.User.' + usePage().props.value.auth.user.id)
     .notification((notification) => {

        notifications.value.unshift(notification)
        unreadnotifications.value++
    });
      }
    });
    return {
      readNow,
      unreadnotifications,
      openNotification,
      navigation,
      userNavigation,
      notifications,
      moment,
    };
  },
};
</script>
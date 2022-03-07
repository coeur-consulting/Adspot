<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <Popover
    class="
      h-16
      w-full
      top-0
      z-30
      transition
      ease-in-out
      duration-300
      shadow
      bg-black
    "
  >
    <div class="px-4 sm:px-6 max-w-screen-xl mx-auto h-full">
      <div class="flex justify-between items-center h-full">
        <div class="flex justify-start items-center mr-6">
          <div class="mr-7 flex-none">
            <a href="/">
              <span class="sr-only">Adspot</span>
              <img
                class="h-7 w-auto sm:h-9"
                src="/images/logo.png"
                alt="Adspot"
              />
            </a>
          </div>
        </div>

        <div class="md:-mr-2 md:-my-2 lg:hidden flex">
          <span class="px-4 py-2 relative" @click="open = !open"
            ><ShoppingCartIcon class="w-6 h-6 text-white" />
            <span
              class="
                px-1
                absolute
                top-[0px]
                right-[8px]
                rounded-md
                bg-orange-500
                text-white text-xs
              "
              >{{ cart }}</span
            >
          </span>
          <PopoverButton
            class="
              bg-white
              rounded-md
              p-2
              inline-flex
              items-center
              justify-center
              text-gray-400
              hover:text-gray-500 hover:bg-gray-100
              focus:outline-none
              focus:ring-2
              focus:ring-inset
              focus:ring-orange-500
            "
          >
            <span class="sr-only">Open menu</span>
            <MenuAlt3Icon class="h-6 w-6" aria-hidden="true" />
          </PopoverButton>
        </div>
        <PopoverGroup
          as="nav"
          class="hidden lg:flex justiy-between items-center"
        >
          <a
            v-for="(item, id) in resources"
            :key="id"
            :href="item.href"
            class="text-base font-medium text-white hover:text-orange-500"
          >
            <div
              class="text-sm text-white hover:text-orange-500 font-bold"
              :class="{
                'text-orange-500 active': $page.url === item.href,
              }"
            >
              {{ item.name }}
            </div>
          </a>
        </PopoverGroup>
        <div class="hidden lg:flex items-center justify-end">
          <a
            v-if="!$page.props.auth.user"
            href="/login"
            class="
              hidden
              md:inline
              ml-4
              whitespace-nowrap
              inline-flex
              items-center
              justify-center
              px-6
              py-1
              border border-transparent
              rounded-full
              shadow-sm
              text-sm
              font-bold
              text-white
              bg-orange-500
              hover:bg-orange-400
            "
          >
            SIGN IN
          </a>
          <div
            class="hidden sm:flex sm:items-center sm:ml-6"
            v-if="$page.props.auth.user"
          >
            <!-- Settings Dropdown -->
            <div class="ml-3 relative">
              <BreezeDropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button
                      type="button"
                      class="
                        inline-flex
                        items-center
                        px-3
                        py-2
                        border border-transparent
                        text-sm
                        leading-4
                        font-medium
                        rounded-md
                        text-white
                        bg-orange-500
                        hover:text-gray-700
                        focus:outline-none
                        transition
                        ease-in-out
                        duration-150
                      "
                    >
                      {{ $page.props.auth.user.name }}

                      <svg
                        class="ml-2 -mr-0.5 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </span>
                </template>

                <template #content>
                  <BreezeDropdownLink
                    :href="route('logout')"
                    method="post"
                    as="button"
                  >
                    Log Out
                  </BreezeDropdownLink>
                </template>
              </BreezeDropdown>
            </div>
          </div>
          <span class="px-3 py-2 relative" @click="open = !open"
            ><ShoppingCartIcon class="w-6 h-6 text-white" />
            <span
              v-if="cart"
              class="
                px-1
                absolute
                top-[0px]
                right-[8px]
                rounded-md
                bg-orange-500
                text-xs text-white
              "
              >{{ cart }}</span
            >
          </span>
        </div>
      </div>
    </div>

    <transition
      enter-active-class="duration-100 ease-out"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="duration-100 ease-in"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <PopoverPanel
        focus
        class="
          absolute
          top-0
          inset-x-0
          p-2
          transition
          transform
          origin-top-right
          lg:hidden
          z-40
        "
      >
        <div
          class="
            rounded-lg
            shadow-lg
            ring-1 ring-black ring-opacity-5
            bg-white
            divide-y-2 divide-gray-50
          "
        >
          <div class="pt-5 pb-6 px-5">
            <div class="flex items-center justify-between">
              <div>
                <img
                  class="h-8 w-auto"
                  src="/images/logo-orange.png"
                  alt="adspot"
                />
              </div>
              <div class="-mr-2">
                <PopoverButton
                  class="
                    bg-white
                    rounded-md
                    p-2
                    inline-flex
                    items-center
                    justify-center
                    text-gray-400
                    hover:text-gray-500 hover:bg-gray-100
                    focus:outline-none
                    focus:ring-2
                    focus:ring-inset
                    focus:ring-orange-500
                  "
                >
                  <span class="sr-only">Close menu</span>
                  <XIcon class="h-6 w-6" aria-hidden="true" />
                </PopoverButton>
              </div>
            </div>
            <div class="mt-6">
              <nav class="grid gap-y-8">
                <a
                  v-for="item in solutions"
                  :key="item.name"
                  :href="item.href"
                  class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50"
                >
                  <component
                    :is="item.icon"
                    class="flex-shrink-0 h-6 w-6 text-gray-700"
                    aria-hidden="true"
                  />
                  <span class="ml-3 text-base font-medium text-gray-700">
                    {{ item.name }}
                  </span>
                </a>
              </nav>
            </div>
          </div>
          <div class="py-6 px-5 space-y-6">
            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
              <a
                v-for="item in resources"
                :key="item.name"
                :href="item.href"
                class="text-base font-medium text-gray-700 hover:text-gray-700"
              >
                {{ item.name }}
              </a>
            </div>
            <div v-if="!$page.props.auth.user">
              <a
                href="/register"
                class="
                  w-full
                  flex
                  items-center
                  justify-center
                  px-4
                  py-2
                  border border-transparent
                  rounded-md
                  shadow-sm
                  text-base
                  font-medium
                  text-white
                  bg-orange-500
                  hover:bg-orange-400
                "
              >
                Sign up
              </a>
              <p class="mt-6 text-center text-base font-medium text-gray-500">
                Existing customer?
                {{ " " }}
                <a href="/login" class="text-orange-500 hover:text-orange-500">
                  Sign in
                </a>
              </p>
            </div>
            <div
              class="lg:hidden pt-4 pb-1 border-t border-gray-200"
              v-if="$page.props.auth.user"
            >
              <div class="">
                <div class="font-medium text-base text-gray-800">
                  {{ $page.props.auth.user.name }}
                </div>
              </div>

              <div class="mt-3 space-y-1">
                <Link :href="route('logout')" method="post" as="button">
                  Log Out
                </Link>
              </div>
            </div>
          </div>
        </div>
      </PopoverPanel>
    </transition>
  </Popover>
  <Cart :open="open" />
</template>

<script>
import {
  Popover,
  PopoverButton,
  PopoverGroup,
  PopoverPanel,
} from "@headlessui/vue";
import {
  MenuAlt3Icon,
  PhoneIcon,
  PlayIcon,
  ShoppingCartIcon,
  XIcon,
} from "@heroicons/vue/solid";
import { ChevronDownIcon } from "@heroicons/vue/solid";
import Cart from "@/MarketPlace/Components/cart";
import { ref, onMounted, computed, watch, inject, reactive } from "vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
const callsToAction = [
  { name: "Watch Demo", href: "#", icon: PlayIcon },
  { name: "Contact Sales", href: "#", icon: PhoneIcon },
];
const resources = [
  {
    name: "Home",
    href: "/",
  },
  {
    name: "Ad Marketplace",
    href: "/marketplace",
  },
  {
    name: "About Us",
    href: "/about",
  },
  {
    name: "News",
    href: "/news",
  },

  {
    name: "Contact us",
    href: "/contact",
  },
];
const recentPosts = [
  { id: 1, name: "Boost your conversion rate", href: "#" },
  {
    id: 2,
    name: "How to use search engine optimization to drive traffic to your site",
    href: "#",
  },
  { id: 3, name: "Improve your customer experience", href: "#" },
];

export default {
  props: ["auth"],
  components: {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    ChevronDownIcon,
    MenuAlt3Icon,
    ShoppingCartIcon,
    XIcon,
    Cart,
    BreezeDropdown,
    BreezeDropdownLink,
    Link,
  },
  setup() {
    const open = ref(false);
    const cart = ref(null);
    const emitter = inject("emitter");
    const getcart = () => {
      axios.get("/getcart").then((res) => {
        cart.value = res.data.count;
        emitter.emit("getcart", res.data.cart);
      });
    };
    onMounted(() => {
      if (usePage().props.value.auth.user) {

        getcart();
      }

      emitter.on("addtocart", (data) => {
        getcart();
      });
       emitter.on("clearcart", () => {
      cart.value=0;
    });
    });
    return {
      callsToAction,
      resources,
      recentPosts,
      open,
      cart,
    };
  },
  data() {
    return {
      active: false,
      cartItems: [],
    };
  },
  mounted() {
    this.cartItems = JSON.parse(localStorage.getItem("cartItems"));
    window.addEventListener("scroll", () => {
      if (window.scrollY > window.innerHeight * 0.4) {
        this.active = true;
      } else {
        this.active = false;
      }
    });
  },
};
</script>
<style scoped lang="scss">
nav {
  a {
    height: 100%;
    div {
      margin-right: 1.5rem;
      position: relative;
      &::before {
        content: "";
        width: 15px;
        border-bottom: 2px solid transparent;
        position: absolute;
        bottom: 0;
      }
      &:hover {
        &::before {
        }
      }
      &.active::before {
        border-color: orange;
      }
    }
  }
}
</style>
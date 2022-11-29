<template>
  <HeadlessMenu
    as="div"
    :class="
      'px-2 py-2' + (toolbar ? [' w-full max-w-full overflow-x-hidden'] : [''])
    "
  >
    <div v-if="!toolbar" class="text-gray-700 group flex items-center text-sm">
      <HeadlessMenuButton
        :title="title"
        style="line-height: 24px; padding: 0"
        class="
          relative
          md:-left-8
          lg:left-0
          inline-flex
          justify-center
          w-full
          rounded-sm
          border border-gray-300
          text-sm
          font-medium
          text-gray-700
          hover:bg-gray-200
          focus:outline-none
          focus:ring-1 focus:ring-offset-1 focus:ring-offset-gray-200
        "
      >
        <div v-html="menuButtonContent"></div>
        <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
      </HeadlessMenuButton>
    </div>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <HeadlessMenuItems :static="toolbar" :class="menuItemsClasses">
        <div v-for="item in items" class="flex-grow-0">
          <HeadlessMenuItem
            v-if="!item.items"
            v-slot="{ active }"
            :disabled="item.disabled"
          >
            <a
              href="#"
              :title="item.title"
              :class="[
                active ? 'bg-gray-200 text-gray-800' : 'text-gray-700',
                'group flex items-center px-2 py-2 text-sm',
                typeof item.classfn == 'function' ? item.classfn() : item.class,
              ]"
              :prop="
                typeof item.class == 'function' ? item.class() : item.class
              "
              @click="choosen(item.eventData)"
            >
              <div v-html="item.content"></div>
            </a>
          </HeadlessMenuItem>
          <Menu
            :items="item.items"
            :title="item.title"
            :grid="item?.grid"
            :toolbar="false"
            :menuButtonContent="item.content"
            @choosen="choosen"
            v-else
          />
        </div>
      </HeadlessMenuItems>
    </transition>
  </HeadlessMenu>
</template>
<script>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/solid";

export default {
  components: {
    HeadlessMenu: Menu,
    HeadlessMenuButton: MenuButton,
    HeadlessMenuItem: MenuItem,
    HeadlessMenuItems: MenuItems,
    ChevronDownIcon,
  },
  name: "Menu",
  props: {
    title: {
      type: String,
      default: "",
    },
    menuButtonContent: {
      type: String,
      default: "",
    },
    items: {
      type: Object,
    },
    toolbar: {
      type: Boolean,
      default: false,
    },
    editorId: String,
    grid: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["choosen"],
  computed: {
    menuItemsClasses: function () {
      const classes = [];
      if (this.toolbar) {
        classes.push("flex flex-wrap");
      } else {
        classes.push(
          "origin-top-right absolute z-10 mt-2 max-w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
        );
        if (this.grid) {
          classes.push(
            "grid grid-cols-10 sm:grid-cols-12 -ml-24 -mt-10 md:mt-0 xl:-ml-14"
          );
        } else {
          //
        }
      }

      return classes;
    },
  },
  methods: {
    choosen: function (data) {
      this.$emit("choosen", data);
    },
  },
};
</script>
<style>
@tailwind base;
@tailwind components;
@tailwind utilities;

.toolbar .is-active {
  @apply bg-gray-200;
  box-shadow: inset 1px 1px 3px 0 hsla(0, 0%, 100%, 0.6);
}
</style>

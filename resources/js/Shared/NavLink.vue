<template>
  <inertia-link :href="href" :class="classes" :method="method || 'GET'">
    <slot></slot>
  </inertia-link>
</template>

<script>
export default {
  props: ["href", "active", "method"],

  computed: {
    classes() {
      return this.active
        ? "inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 border-opatity-50 text-sm font-medium leading-5 text-gray-50 focus:outline-none focus:border-indigo-700 transition"
        : "inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-50 hover:border-gray-300 hover:border-opacity-25 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition";
    },
  },
};
</script>

<template>
  <svg
    viewBox="0 0 24 24"
    :fill="fill"
    :height="size"
    :width="size"
    class="mdi-icon"
    :style="{ transform: `rotate(${this.rotate}deg)`, display: 'inline-block' }"
  >
    <title v-if="title">{{ title }}</title>
    <path :d="path"></path>
  </svg>
</template>
<script>
export default {
  props: {
    name: String,
    title: String,
    size: {
      type: [String, Number],
      default: 24,
    },
    fill: {
      type: String,
      default: "currentColor",
    },
    rotate: {
      type: Number,
      default: 0,
    },
    path: {
      type: String,
      default: "",
    },
  },
  setup() {},
};
</script>

<template>
  <textarea
    class="
      border-gray-300
      focus:border-indigo-600
      focus:ring focus:ring-indigo-300 focus:ring-opacity-50
      rounded-md
      shadow-sm
      bg-gray-600
    "
    @input="$emit('update:modelValue', $event.target.value)"
    ref="input"
    v-model="modelValue"
  >
  </textarea>
</template>

<script>
export default {
  props: ["modelValue"],

  emits: ["update:modelValue"],

  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>


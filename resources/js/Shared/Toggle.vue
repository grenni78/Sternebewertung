<template>
  <div class="mb-3">
    <span :class="`transition-all ${getColorClass(false)} font-medium mr-2`">
      {{ labels[0] }}
    </span>
    <div class="relative inline-block w-10 mr-2 align-middle select-none">
      <input
        type="checkbox"
        :name="name"
        :id="name"
        class="
          checked:bg-blue-500
          outline-none
          focus:outline-none
          right-4
          checked:right-0
          duration-200
          ease-in
          absolute
          block
          w-6
          h-6
          rounded-full
          bg-white
          border-4
          appearance-none
          cursor-pointer
        "
        :checked="modelValue"
        @input="$emit('update:modelValue', $event.target.checked)"
        @change="log"
      />
      <label
        :for="name"
        class="
          block
          overflow-hidden
          h-6
          rounded-full
          bg-gray-300
          cursor-pointer
        "
      >
      </label>
    </div>
    <span :class="`transition-all ${getColorClass(true)} font-medium ml-2`">
      {{ labels[1] }}
    </span>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: {
    name: String,
    labels: Array,
    modelValue: Boolean,
  },
  emits: ["update:modelValue"],
  computed: {},
  methods: {
    getColorClass: function (on) {
      if (on) {
        return `text-${this.modelValue ? "green-600 underline" : "gray-200"}`;
      }
      return `text-${this.modelValue ? "gray-200" : "green-600 underline"}`;
    },
    log: function () {
      console.log("debug", this.modelValue);
    },
  },
};
</script>

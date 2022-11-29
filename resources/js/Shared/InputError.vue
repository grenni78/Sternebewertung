<template>
  <transition leave-active-class="duration-300">
    <div v-show="message" class="bg-red-600 p-3 rounded">
      <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <p class="text-sm text-red-200">
          {{ message }}
        </p>
      </transition>
    </div>
  </transition>
</template>

<script>
export default {
  props: ["message"],
};
</script>

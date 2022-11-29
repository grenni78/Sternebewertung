<template>
  <app-layout background-image="../img/review-1920.jpg">
    <template #header>
      <h1 class="text-gray-700">Bewertungsportal</h1>
      <h2 class="text-gray-600">Die Anlaufstelle für gerechte Bewertungen</h2>
    </template>

    <template #imageCopyright>
      Bild von
      <a
        href="https://pixabay.com/de/users/tumisu-148124/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5207277"
        >Tumisu</a
      >
      auf
      <a
        href="https://pixabay.com/de/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5207277"
        >Pixabay</a
      >
    </template>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
  components: {
    AppLayout,
  },
};
</script>
<style>
</style>

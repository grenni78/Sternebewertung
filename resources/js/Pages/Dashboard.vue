<template>
  <app-layout background-image="../img/dashboard-1920.jpg">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Mein Konto - Übersicht
      </h2>
    </template>
    <template #imageCopyright>
      Bild von
      <a
        href="https://pixabay.com/de/users/photomix-company-1546875/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1433427"
        >Photo Mix</a
      >
      auf
      <a
        href="https://pixabay.com/de/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1433427"
        >Pixabay</a
      >
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- text hier -->
        </div>
      </div>
    </div>
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

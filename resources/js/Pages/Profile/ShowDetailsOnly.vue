<template>
  <app-layout background-image="../img/details-1920.jpg">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Benutzer-Details
      </h2>
    </template>

    <div>
      <div class="text-gray-600 m-6">
        Bitte vervollständigen Sie ihr Benutzer-Profil, um mit der Verwendung
        der Seite fortfahren zu können.
      </div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div>
          <user-details :userDetails="$page.props.userDetails" />

          <jet-section-border />
        </div>
      </div>
    </div>
    <template #imageCopyright>
      Bild von
      <a
        href="https://pixabay.com/de/users/thedigitalartist-202249/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=3357642"
        >Pete Linforth</a
      >
      auf
      <a
        href="https://pixabay.com/de/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=3357642"
        >Pixabay</a
      >
    </template>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import DeleteUserForm from "./DeleteUserForm";
import JetSectionBorder from "@/Shared/SectionBorder";
import LogoutOtherBrowserSessionsForm from "./LogoutOtherBrowserSessionsForm";
import TwoFactorAuthenticationForm from "./TwoFactorAuthenticationForm";
import UpdatePasswordForm from "./UpdatePasswordForm";
import UpdateProfileInformationForm from "./UpdateProfileInformationForm";
import UserDetails from "./UserDetails";

export default {
  props: ["sessions"],

  components: {
    AppLayout,
    DeleteUserForm,
    JetSectionBorder,
    LogoutOtherBrowserSessionsForm,
    TwoFactorAuthenticationForm,
    UpdatePasswordForm,
    UpdateProfileInformationForm,
    UserDetails,
  },
};
</script>

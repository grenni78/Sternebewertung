<template>
  <jet-authentication-card>
    <template #logo>
      <jet-authentication-card-logo />
    </template>

    <div class="mb-4 text-sm text-gray-200">
      <p>Hallo und vielen Dank, dass Sie sich bei uns angemeldet haben.</p>
      <p>
        Ihre E-Mail Adresse wurde leider nicht nicht bestätigt. Dies ist
        allerdings sehr wichtig für die Funktion dieser Seiten.
      </p>
      <p>
        Um Ihre E-Mail Adress zu verifizieren, klicken Sie bitte auf den Link,
        den wir Ihnen zugesendet haben.
      </p>
      <p>
        Sie haben keine Mail erhalten? Hier unten haben Sie die Möglichkeit sich
        den Verifizierungs-Link erneut zusenden zu lassen.
      </p>
    </div>

    <div
      class="mb-4 font-medium text-sm text-green-600"
      v-if="verificationLinkSent"
    >
      Ein neuer Verifizierungslink wurde Ihnen an die, bei der Registrierung,
      angegebenen E-Mail Adresse geschickt.
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 flex items-center justify-between">
        <jet-button
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Verifikations-Link erneut zusenden
        </jet-button>

        <inertia-link
          :href="route('logout')"
          method="post"
          as="button"
          class="underline text-sm text-gray-200 hover:text-white"
          >abmelden</inertia-link
        >
      </div>
    </form>
  </jet-authentication-card>
</template>

<script>
import JetAuthenticationCard from "@/Shared/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Shared/AuthenticationCardLogo";
import JetButton from "@/Shared/Button";

export default {
  components: {
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
  },

  props: {
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form(),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("verification.send"));
    },
  },

  computed: {
    verificationLinkSent() {
      return this.status === "verification-link-sent";
    },
  },
};
</script>

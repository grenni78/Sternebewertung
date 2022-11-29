<template>
  <jet-authentication-card>
    <template #logo>
      <jet-authentication-card-logo />
    </template>

    <div class="mb-4 text-sm text-white">
      <p>Sie haben Ihr Passwort vergessen? Kein Problem:</p>
      <p>
        Geben Sie einfach die, von Ihnen hier hinterlegte, E-Mail Adresse ein
        und Sie Erhalten eine E-Mail mit einem Link über den Sie Ihr Passwort
        zurücksetzen können an diese Adresse gesendet.
      </p>
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <jet-validation-errors class="mb-4" />

    <form @submit.prevent="submit">
      <div>
        <jet-label class="text-white" for="email" value="E-Mail" />
        <jet-input
          id="email"
          type="email"
          title="Bitte geben Sie eine gültige E-Mail Adresse an."
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autofocus
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <jet-button
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Den Link jetzt zusenden
        </jet-button>
      </div>
    </form>
  </jet-authentication-card>
</template>

<script>
import JetAuthenticationCard from "@/Shared/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Shared/AuthenticationCardLogo";
import JetButton from "@/Shared/Button";
import JetInput from "@/Shared/Input";
import JetLabel from "@/Shared/Label";
import JetValidationErrors from "@/Shared/ValidationErrors";

export default {
  components: {
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetLabel,
    JetValidationErrors,
  },

  props: {
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: "",
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("password.email"));
    },
  },
};
</script>

<template>
  <jet-authentication-card>
    <template #logo>
      <jet-authentication-card-logo />
    </template>

    <div class="mb-4 text-sm text-gray-200">
      <template v-if="!recovery">
        Bitte geben Sie den Zugangscode aus Ihrem Authentifikator ein.
      </template>

      <template v-else>
        Bitte geben Sie Ihre Wiederherstellungsschlüssel ein!
      </template>
    </div>

    <jet-validation-errors class="mb-4" />

    <form @submit.prevent="submit">
      <div v-if="!recovery">
        <jet-label for="code" value="Sicherheitscode" />
        <jet-input
          ref="code"
          id="code"
          type="text"
          inputmode="numeric"
          class="mt-1 block w-full"
          v-model="form.code"
          autofocus
          autocomplete="one-time-code"
        />
      </div>

      <div v-else>
        <jet-label for="recovery_code" value="Wiederhestellungs-Code" />
        <jet-input
          ref="recovery_code"
          id="recovery_code"
          type="text"
          class="mt-1 block w-full"
          v-model="form.recovery_code"
          autocomplete="one-time-code"
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <button
          type="button"
          class="
            text-sm text-gray-400
            hover:text-gray-200
            underline
            cursor-pointer
          "
          @click.prevent="toggleRecovery"
        >
          <template v-if="!recovery">
            Wiederherstellungsschlüssel benutzen
          </template>

          <template v-else> Einen Sicherheits-Code verwenden </template>
        </button>

        <jet-button
          class="ml-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          anmelden
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

  data() {
    return {
      recovery: false,
      form: this.$inertia.form({
        code: "",
        recovery_code: "",
      }),
    };
  },

  methods: {
    toggleRecovery() {
      this.recovery ^= true;

      this.$nextTick(() => {
        if (this.recovery) {
          this.$refs.recovery_code.focus();
          this.form.code = "";
        } else {
          this.$refs.code.focus();
          this.form.recovery_code = "";
        }
      });
    },

    submit() {
      this.form.post(this.route("two-factor.login"));
    },
  },
};
</script>

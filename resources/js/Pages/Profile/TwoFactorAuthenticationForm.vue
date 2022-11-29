<template>
  <jet-action-section>
    <template #title> 2-Faktor Authentifizierung </template>

    <template #description>
      Fügen Sie mittels 2-Faktor Authentifizierung eine weitere
      Sicherheitskomponente zu Ihrem Konto hinzu.
    </template>

    <template #content>
      <h3 class="text-lg font-medium text-gray-900" v-if="twoFactorEnabled">
        Sie haben die 2-Faktor Authentifizierung aktiviert.
      </h3>

      <h3 class="text-lg font-medium text-gray-900" v-else>
        Sie haben die 2-Faktor Authentifizierung <u>nicht</u> aktiviert.
      </h3>

      <div class="mt-3 max-w-xl text-sm text-gray-600">
        <p>
          Wenn die 2-Faktor Authentifizierung aktiviert ist, dann werden Sie bei
          jedem Login zusätzlich um einen dynamisch generierten um einen
          Sicherheits-Schlüssel gebeten.<br />
          Sie erhalten diesen Schlüssel zum Beispiel über die Google
          Authtentifikator-App auf Ihrem Mobiltelefon.
        </p>
      </div>

      <div v-if="twoFactorEnabled">
        <div v-if="qrCode">
          <div class="mt-4 max-w-xl text-sm text-gray-600">
            <p class="font-semibold">
              Die 2-Faktor Authentifizierung ist nun aktiv. Scannen Sie bitte
              folgenden QR-Code mit Ihrer Authentifikator-App auf dem
              Smartphone.
            </p>
          </div>

          <div class="mt-4" v-html="qrCode"></div>
        </div>

        <div v-if="recoveryCodes.length > 0">
          <div class="mt-4 max-w-xl text-sm text-gray-600">
            <p class="font-semibold">
              Speichern Sie bitte diese Wiederherstellungsschlüssel an einem
              sicheren Ort, oder sicherem Passwort-Manager.<br />
              Sie können Ihnen den Zugang zu Ihrem Konto hier ermöglichen,
              sollten Sie den Zugang zur 2-Faktor Authentifizierung verlieren.
            </p>
          </div>

          <div
            class="
              grid
              gap-1
              max-w-xl
              mt-4
              px-4
              py-4
              font-mono
              text-sm
              bg-gray-100
              text-gray-700
              rounded-lg
            "
          >
            <div v-for="code in recoveryCodes" :key="code">
              {{ code }}
            </div>
          </div>
        </div>
      </div>

      <div class="mt-5">
        <div v-if="!twoFactorEnabled">
          <jet-confirms-password @confirmed="enableTwoFactorAuthentication">
            <jet-button
              type="button"
              :class="{ 'opacity-25': enabling }"
              :disabled="enabling"
            >
              aktivieren
            </jet-button>
          </jet-confirms-password>
        </div>

        <div v-else>
          <jet-confirms-password @confirmed="regenerateRecoveryCodes">
            <jet-secondary-button class="mr-3" v-if="recoveryCodes.length > 0">
              Wiederherstellungsschlüssel neu generieren
            </jet-secondary-button>
          </jet-confirms-password>

          <jet-confirms-password @confirmed="showRecoveryCodes">
            <jet-secondary-button
              class="mr-3"
              v-if="recoveryCodes.length === 0"
            >
              Wiederherstellungsschlüssel anzeigen
            </jet-secondary-button>
          </jet-confirms-password>

          <jet-confirms-password @confirmed="disableTwoFactorAuthentication">
            <jet-danger-button
              :class="{ 'opacity-25': disabling }"
              :disabled="disabling"
            >
              deaktivieren
            </jet-danger-button>
          </jet-confirms-password>
        </div>
      </div>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from "@/Shared/ActionSection";
import JetButton from "@/Shared/Button";
import JetConfirmsPassword from "@/Shared/ConfirmsPassword";
import JetDangerButton from "@/Shared/DangerButton";
import JetSecondaryButton from "@/Shared/SecondaryButton";

export default {
  components: {
    JetActionSection,
    JetButton,
    JetConfirmsPassword,
    JetDangerButton,
    JetSecondaryButton,
  },

  data() {
    return {
      enabling: false,
      disabling: false,

      qrCode: null,
      recoveryCodes: [],
    };
  },

  methods: {
    enableTwoFactorAuthentication() {
      this.enabling = true;

      this.$inertia.post(
        "/user/two-factor-authentication",
        {},
        {
          preserveScroll: true,
          onSuccess: () =>
            Promise.all([this.showQrCode(), this.showRecoveryCodes()]),
          onFinish: () => (this.enabling = false),
        }
      );
    },

    showQrCode() {
      return axios.get("/user/two-factor-qr-code").then((response) => {
        this.qrCode = response.data.svg;
      });
    },

    showRecoveryCodes() {
      return axios.get("/user/two-factor-recovery-codes").then((response) => {
        this.recoveryCodes = response.data;
      });
    },

    regenerateRecoveryCodes() {
      axios.post("/user/two-factor-recovery-codes").then((response) => {
        this.showRecoveryCodes();
      });
    },

    disableTwoFactorAuthentication() {
      this.disabling = true;

      this.$inertia.delete("/user/two-factor-authentication", {
        preserveScroll: true,
        onSuccess: () => (this.disabling = false),
      });
    },
  },

  computed: {
    twoFactorEnabled() {
      return !this.enabling && this.$page.props.user.two_factor_enabled;
    },
  },
};
</script>

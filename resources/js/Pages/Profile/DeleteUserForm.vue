<template>
  <jet-action-section>
    <template #title> Konto löschen </template>

    <template #description> Ihr Konto hier permanent löschen. </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        Wenn Sie Ihr Konto hier löschen, dann werden all Ihre Daten hier
        permanent gelöscht.<br />
        Bitte sichern Sie vorher alles, was Sie behalten möchten!
      </div>

      <div class="mt-5">
        <jet-danger-button @click="confirmUserDeletion">
          Konto löschen
        </jet-danger-button>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
        <template #title> Konto löschen </template>

        <template #content>
          Sind Sie sicher, dass Sie Ihr Konto hier löschen möchten?<br />
          Nach dem Löschen sind all Ihre Daten, die auf dieser Plattform
          gespeichert sind, unwiderruflich verlohren!<br />
          Um Ihre Löschabsicht zu bestätigen, geben Sie bitte Ihr aktuelles
          Passwort ein!

          <div class="mt-4">
            <jet-input
              type="password"
              class="mt-1 block w-3/4"
              placeholder="Password"
              ref="password"
              v-model="form.password"
              @keyup.enter="deleteUser"
            />

            <jet-input-error :message="form.errors.password" class="mt-2" />
          </div>
        </template>

        <template #footer>
          <jet-secondary-button @click="closeModal">
            abbrechen
          </jet-secondary-button>

          <jet-danger-button
            class="ml-2"
            @click="deleteUser"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            das Konto jetzt löschen!
          </jet-danger-button>
        </template>
      </jet-dialog-modal>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from "@/Shared/ActionSection";
import JetDialogModal from "@/Shared/DialogModal";
import JetDangerButton from "@/Shared/DangerButton";
import JetInput from "@/Shared/Input";
import JetInputError from "@/Shared/InputError";
import JetSecondaryButton from "@/Shared/SecondaryButton";

export default {
  components: {
    JetActionSection,
    JetDangerButton,
    JetDialogModal,
    JetInput,
    JetInputError,
    JetSecondaryButton,
  },

  data() {
    return {
      confirmingUserDeletion: false,

      form: this.$inertia.form({
        password: "",
      }),
    };
  },

  methods: {
    confirmUserDeletion() {
      this.confirmingUserDeletion = true;

      setTimeout(() => this.$refs.password.focus(), 250);
    },

    deleteUser() {
      this.form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.password.focus(),
        onFinish: () => this.form.reset(),
      });
    },

    closeModal() {
      this.confirmingUserDeletion = false;

      this.form.reset();
    },
  },
};
</script>

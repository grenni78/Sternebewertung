<template>
  <jet-form-section @submitted="updateUserDetails">
    <template #title>Benutzer-Profil</template>

    <template #description>
      Hier hinterlegen Sie Details zu Ihrem Konto
    </template>

    <template #form>
      <div class="col-span-6">
        <jet-label for="is_commercial" value="Konto-Typ" />
        <toggle
          id="is_commercial"
          class="mt-1 block w-full"
          v-model="form.is_commercial"
          :labels="['privat', 'gewerblich']"
        />
        <jet-input-error :message="form.errors.firstname" class="mt-2" />
      </div>

      <transition
        class="duration-400"
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 h-0 overflow-hidden"
        enter-to-class="opacity-100 h-auto overflow-auto"
        leave-active-class="ease-in duration-300"
        leave-from-class="opacity-100 h-auto overflow-auto"
        leave-to-class="opacity-0 h-0 overflow-hidden"
      >
        <div v-show="form.is_commercial" class="col-span-6">
          <div class="col-span-6">
            <jet-label for="company" value="Firma" />
            <jet-input
              id="company"
              class="mt-1 block w-full border p-2"
              v-model="form.company"
              autocomplete="company"
            />
            <jet-input-error :message="form.errors.company" class="mt-2" />
          </div>

          <div class="col-span-6">
            <jet-label for="industry" value="Branche" />
            <jet-input
              id="industry"
              class="mt-1 block w-full border p-2"
              v-model="form.industry"
              autocomplete="false"
            />
            <jet-input-error :message="form.errors.industry" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
            <jet-label for="homepage" value="Webseite" />
            <jet-input
              id="homepage"
              class="mt-1 block w-full border p-2"
              v-model="form.homepage"
              autocomplete="homepage"
            />
            <jet-input-error :message="form.errors.homepage" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
            <jet-label for="tax_id" value="Steuernummer" />
            <jet-input
              id="tax_id"
              class="mt-1 block w-full border p-2"
              v-model="form.tax_id"
              autocomplete="none"
            />
            <jet-input-error :message="form.errors.tax_id" class="mt-2" />
          </div>

          <div class="col-span-6">
            <jet-label for="company_about" value="Über unsere Firma" />
            <text-field
              id="company_about"
              class="mt-1 block w-full border p-2"
              v-model="form.company_about"
            />
            <jet-input-error
              :message="form.errors.company_about"
              class="mt-2"
            />
          </div>

          <div class="col-span-6 sm:col-span-4">
            <jet-label for="tel" value="Telefonnummer." />
            <jet-input
              id="tel"
              class="mt-1 block w-full border p-2"
              v-model="form.tel"
              autocomplete="none"
            />
            <jet-input-error :message="form.errors.tel" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
            <jet-label
              for="searchwords"
              value="Suchworte (durch Kommata getrennt, - (Minus) vorangestellt verbietet das Suchwort)"
            />
            <jet-input
              id="searchwords"
              class="mt-1 block w-full border p-2"
              v-model="form.searchwords"
              autocomplete="none"
            />
            <jet-input-error :message="form.errors.searchwords" class="mt-2" />
          </div>

          <div class="col-span-6 sm:col-span-4">
            <jet-label
              for="gmaps_url"
              value="Link zur google Maps- Bewertungsseite"
            />
            <jet-input
              id="gmaps_url"
              class="mt-1 block w-full border p-2"
              v-model="form.gmaps_url"
              type="text"
              autocomplete="none"
            />
            <jet-input-error :message="form.errors.gmaps_url" class="mt-2" />
          </div>
          <div class="col-span-6 border-t border-gray-100"></div>
        </div>
      </transition>

      <div class="col-span-6 sm:col-span-4">
        <jet-label for="firstname" value="Vorname" />
        <jet-input
          id="firstname"
          type="text"
          class="mt-1 block w-full"
          v-model="form.firstname"
          autocomplete="given-name"
        />
        <jet-input-error :message="form.errors.firstname" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <jet-label for="lastname" value="Nachname" />
        <jet-input
          id="lastname"
          type="text"
          class="mt-1 block w-full"
          v-model="form.lastname"
          autocomplete="family-name"
        />
        <jet-input-error :message="form.errors.lastname" class="mt-2" />
      </div>
      <div class="col-span-6 border-t border-gray-100"></div>
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="street" value="Straße" />
        <jet-input
          id="street"
          type="text"
          class="mt-1 block w-full"
          v-model="form.street"
          autocomplete="off"
        />
        <jet-input-error :message="form.errors.street" class="mt-2" />
      </div>

      <div class="col-span-4 sm:col-span-2">
        <jet-label for="street_number" value="Nr." />
        <jet-input
          id="street_number"
          type="text"
          class="mt-1 block w-full"
          v-model="form.street_number"
          autocomplete="off"
        />
        <jet-input-error :message="form.errors.street_number" class="mt-2" />
      </div>

      <div class="col-span-4 sm:col-span-2">
        <jet-label for="zip" value="PLZ." />
        <jet-input
          id="zip"
          type="text"
          class="mt-1 block w-full"
          v-model="form.zip"
          autocomplete="off"
        />
        <jet-input-error :message="form.errors.zip" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <jet-label for="city" value="Stadt" />
        <jet-input
          id="city"
          type="text"
          class="mt-1 block w-full"
          v-model="form.city"
          autocomplete="off"
        />
        <jet-input-error :message="form.errors.city" class="mt-2" />
      </div>
      <div class="col-span-6 border-t border-gray-100"></div>
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="gmaps_user" value="Benutzername bei google Maps" />
        <jet-input
          id="gmaps_user"
          class="mt-1 block w-full border p-2"
          v-model="form.gmaps_user"
          type="email"
          autocomplete="none"
        />
        <jet-input-error :message="form.errors.gmaps_user" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <jet-label for="paypal_user" value="Konto bei PayPal" />
        <jet-input
          id="paypal_user"
          class="mt-1 block w-full border p-2"
          v-model="form.paypal_user"
          type="email"
          autocomplete="none"
        />
        <jet-input-error :message="form.errors.paypal_user" class="mt-2" />
      </div>
      <input type="hidden" v-model="form.redirect" />
    </template>
    <template #actions>
      <jet-action-message :on="form.recentlySuccessful" class="mr-3">
        gespeichert.
      </jet-action-message>

      <jet-button
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        speichern
      </jet-button>
    </template>
  </jet-form-section>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { usePage } from "@inertiajs/inertia-vue3";
import JetButton from "@/Shared/Button";
import JetFormSection from "@/Shared/FormSection";
import JetInput from "@/Shared/Input";
import JetInputError from "@/Shared/InputError";
import JetLabel from "@/Shared/Label";
import JetActionMessage from "@/Shared/ActionMessage";
import JetSecondaryButton from "@/Shared/SecondaryButton";
import Toggle from "@/Shared/Toggle";
import TextField from "@/Shared/Textfield";

export default {
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    Toggle,
    TextField,
  },

  props: ["userDetails"],

  data() {
    const form = this.$inertia.form({
      _method: "PUT",
      is_commercial: this.userDetails?.is_commercial == "1" ? true : false,
      company: this.userDetails?.company,
      industry: this.userDetails?.industry,
      homepage: this.userDetails?.homepage,
      tax_id: this.userDetails?.tax_id,
      company_about: this.userDetails?.company_about,
      searchwords: this.userDetails?.searchwords,
      tel: this.userDetails?.tel,
      firstname: this.userDetails?.firstname,
      lastname: this.userDetails?.lastname,
      street: this.userDetails?.street,
      street_number: this.userDetails?.street_number,
      zip: this.userDetails?.zip,
      city: this.userDetails?.city,
      gmaps_user: this.userDetails?.gmaps_user,
      gmaps_url: this.userDetails?.gmaps_url,
      paypal_user: this.userDetails?.paypal_user,
      redirect: this.$page.props.redirect,
    });

    return { form };
  },
  methods: {
    updateUserDetails: function () {
      this.form.post(route("profile-details.update"), {
        errorBag: "updateUserDetail",
        preserveScroll: true,
        onSuccess: () => {},
      });
    },
  },
};
</script>

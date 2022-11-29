<template>
  <div
    class="layout-wrapper"
    :style="`background-image:url('${backgroundImage}');`"
  >
    <jet-banner />

    <div class="min-h-screen flex flex-col">
      <nav
        class="
          absolute
          sm:fixed
          top-0
          left:0
          w-screen
          bg-gray-700
          sm:bg-opacity-50
          text-white
          shadow-lg
          z-50
        "
      >
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="flex-shrink-0 flex items-center">
                <inertia-link :href="route('dashboard')">
                  <jet-application-mark class="block h-9 w-auto" />
                </inertia-link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <jet-nav-link
                  v-if="$page.props.user"
                  class="level1"
                  :href="route('dashboard')"
                  :active="route().current('dashboard')"
                >
                  Mein Konto
                </jet-nav-link>
                <jet-nav-link
                  v-if="$page.props.user"
                  class="level1"
                  @click="logout"
                  href="#"
                  :active="route().current('logout')"
                >
                  Abmelden
                </jet-nav-link>
                <jet-nav-link
                  v-else
                  class="level1"
                  :href="route('login')"
                  :active="route().current('login')"
                >
                  anmelden
                </jet-nav-link>
                <jet-nav-link
                  v-if="!$page.props.user"
                  class="level1"
                  :href="route('register')"
                  :active="route().current('register')"
                >
                  registrieren
                </jet-nav-link>
                <jet-nav-link
                  class="level1"
                  :href="route('terms')"
                  :active="route().current('terms')"
                >
                  AGB
                </jet-nav-link>
                <jet-nav-link
                  class="level1"
                  :href="route('policy')"
                  :active="route().current('policy')"
                >
                  Datenschutzerklärung
                </jet-nav-link>
              </div>
            </div>

            <div class="sm:flex sm:items-center sm:ml-6">
              <div class="ml-3 relative">
                <!-- Settings Dropdown -->
                <div
                  v-if="$page.props.user"
                  class="hidden sm:block ml-3 relative"
                >
                  <jet-dropdown align="right" width="48">
                    <template #trigger>
                      <div class="relative">
                        <button
                          v-if="$page.props.jetstream.managesProfilePhotos"
                          class="
                            flex
                            text-sm
                            border-2 border-transparent
                            rounded-full
                            focus:outline-none
                            focus:border-gray-300
                            transition
                          "
                        >
                          <img
                            class="
                              h-8
                              w-8
                              rounded-full
                              object-cover
                              border-gray-200 border-2
                            "
                            :src="$page.props.user?.profile_photo_path"
                            :alt="$page.props.user?.name"
                          />
                        </button>

                        <span v-else class="inline-flex rounded-md">
                          <button
                            type="button"
                            class="
                              inline-flex
                              items-center
                              px-3
                              py-2
                              border border-transparent
                              text-sm
                              leading-4
                              font-medium
                              rounded-md
                              text-gray-200
                              bg-white
                              hover:text-white
                              focus:outline-none
                              transition
                            "
                          >
                            {{ $page.props.user?.name }}

                            <svg
                              class="ml-2 -mr-0.5 h-4 w-4"
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                              />
                            </svg>
                          </button>
                        </span>
                        <MailIcon
                          v-if="unreadMessages"
                          title="ungelesene Nachrichten vorhanden"
                          class="
                            absolute
                            -bottom-0.5
                            -right-1.5
                            w-4
                            h-4
                            text-gray-200
                            animate-ping animate-iterate-2
                            svg-shadow
                          "
                        />
                      </div>
                    </template>

                    <template #content>
                      <!-- Kontomanagement -->
                      <div class="block px-4 py-2 text-xs text-gray-400">
                        Konto verwalten
                      </div>

                      <jet-dropdown-link :href="route('profile.show')">
                        Mein Profil
                      </jet-dropdown-link>

                      <div class="border-t border-gray-100"></div>

                      <!-- Authentication -->
                      <form @submit.prevent="logout">
                        <jet-dropdown-link as="button">
                          abmelden
                        </jet-dropdown-link>
                      </form>

                      <div class="border-t border-gray-100"></div>
                      <!-- Nachrichten -->
                      <div class="block px-4 py-2 text-xs text-gray-400 mt-3">
                        Nachrichten
                      </div>
                      <jet-dropdown-link :href="route('messages')">
                        Sofortnachrichten ({{ unreadMessages }})
                      </jet-dropdown-link>

                      <div class="border-t border-gray-100"></div>
                      <!-- Bewertungen -->
                      <div class="block px-4 py-2 text-xs text-gray-400 mt-3">
                        Bewertungen
                      </div>
                      <jet-dropdown-link :href="route('reviews.posted')">
                        abgegeben (0)
                      </jet-dropdown-link>
                      <jet-dropdown-link :href="route('reviews.confirmed')">
                        bestätigt (0)
                      </jet-dropdown-link>
                      <jet-dropdown-link :href="route('reviews.waiting')">
                        unbestätigt (0)
                      </jet-dropdown-link>
                      <jet-dropdown-link :href="route('reviews.faulty')">
                        fehlerhaft (0)
                      </jet-dropdown-link>
                    </template>
                  </jet-dropdown>
                </div>
              </div>

              <!-- Hamburger -->
              <div class="-mr-2 flex items-center sm:hidden mr-2 mt-2">
                <button
                  @click="
                    showingNavigationDropdown = !showingNavigationDropdown
                  "
                  class="
                    inline-flex
                    items-center
                    justify-center
                    p-2
                    rounded-md
                    text-gray-400
                    hover:text-gray-200
                    hover:bg-gray-400
                    focus:outline-none
                    focus:bg-gray-500
                    focus:text-gray-200
                    transition
                  "
                >
                  <svg
                    class="h-6 w-6"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 24 24"
                  >
                    <path
                      :class="{
                        hidden: showingNavigationDropdown,
                        'inline-flex': !showingNavigationDropdown,
                      }"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"
                    />
                    <path
                      :class="{
                        hidden: !showingNavigationDropdown,
                        'inline-flex': showingNavigationDropdown,
                      }"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Responsive Navigation Menu -->
          <div
            id="responsive-nav"
            :class="{
              block: showingNavigationDropdown,
              hidden: !showingNavigationDropdown,
            }"
            class="sm:hidden"
          >
            <!-- Responsive Settings Options -->
            <div
              v-if="$page.props.user"
              class="pt-4 pb-1 border-t border-gray-200 text-gray-200"
            >
              <div class="flex items-center px-4">
                <div
                  v-if="$page.props.jetstream.managesProfilePhotos"
                  class="flex-shrink-0 mr-3"
                >
                  <img
                    class="h-10 w-10 rounded-full object-cover"
                    :src="$page.props.user?.profile_photo_path"
                    :alt="$page.props.user?.name"
                  />
                </div>

                <div>
                  <div class="font-medium text-base text-gray-800">
                    {{ $page.props.user?.name }}
                  </div>
                  <div class="font-medium text-sm text-gray-500">
                    {{ $page.props.user?.email }}
                  </div>
                </div>
              </div>
              <jet-responsive-nav-link
                :href="route('profile.show')"
                :active="route().current('profile.show')"
              >
                Mein Profil
              </jet-responsive-nav-link>
              <jet-responsive-nav-link
                @click="logout"
                href="#"
                :active="route().current('logout')"
                method="POST"
              >
                Abmelden
              </jet-responsive-nav-link>
              <div class="border-t border-gray-100"></div>
              <div class="block px-4 py-2 text-xs text-gray-400 mt-3">
                Nachrichten
              </div>
              <jet-responsive-nav-link :href="route('messages')">
                Sofortnachrichten ({{ unreadMessages }})
              </jet-responsive-nav-link>

              <div class="border-t border-gray-100"></div>
              <!-- Bewertungen -->
              <div class="block px-4 py-2 text-xs text-gray-400 mt-3">
                Bewertungen
              </div>
              <jet-responsive-nav-link :href="route('reviews.posted')">
                abgegeben (0)
              </jet-responsive-nav-link>
              <jet-responsive-nav-link :href="route('reviews.confirmed')">
                bestätigt (0)
              </jet-responsive-nav-link>
              <jet-responsive-nav-link :href="route('reviews.waiting')">
                unbestätigt (0)
              </jet-responsive-nav-link>
              <jet-responsive-nav-link :href="route('reviews.faulty')">
                fehlerhaft (0)
              </jet-responsive-nav-link>
              <div class="border-t border-gray-100"></div>
              <jet-responsive-nav-link
                :href="route('dashboard')"
                :active="route().current('dashboard')"
              >
                Übersicht
              </jet-responsive-nav-link>
            </div>
            <!-- public menu -->
            <div v-else class="pt-2 pb-3 space-y-1 border-t border-gray-200">
              <jet-responsive-nav-link
                :href="route('login')"
                :active="route().current('login')"
              >
                Anmelden
              </jet-responsive-nav-link>
              <jet-responsive-nav-link
                v-if="!$page.props.user"
                class="level1"
                :href="route('register')"
                :active="route().current('register')"
              >
                registrieren
              </jet-responsive-nav-link>
            </div>
            <!-- public and private -->
            <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
              <jet-responsive-nav-link
                class="level1"
                :href="route('terms')"
                :active="route().current('terms')"
              >
                AGB
              </jet-responsive-nav-link>
              <jet-responsive-nav-link
                class="level1"
                :href="route('policy')"
                :active="route().current('policy')"
              >
                Datenschutzerklärung
              </jet-responsive-nav-link>
            </div>
          </div>
        </div>
      </nav>
      <div class="hidden sm:flex-grow sm:block"></div>
      <div
        class="
          min-h-screen
          sm:min-h-3/4screen
          flex flex-col
          sm:justify-center
          items-center
          pt-16
        "
      >
        <div
          class="
            w-full
            sm:min-h-full
            flex-grow
            md:w-4/5
            lg:w-3/4
            xl:w-3/5
            mt-0
            px-2
            py-2
            sm:px-6
            sm:py-4
            bg-white
            shadow-md
            overflow-hidden
            sm:rounded-lg
          "
        >
          <!-- Page Heading -->
          <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
              <slot name="header"></slot>
            </div>
          </header>

          <!-- Page Content -->
          <main>
            <slot></slot>
          </main>
        </div>
      </div>
      <div class="hidden sm:flex-grow sm:block"></div>
    </div>
    <div class="image-copyright"><slot name="imageCopyright"></slot></div>
  </div>
</template>

<script>
import { ref, watch } from "vue";
import JetApplicationMark from "@/Shared/ApplicationMark";
import JetBanner from "@/Shared/Banner";
import JetDropdown from "@/Shared/Dropdown";
import JetDropdownLink from "@/Shared/DropdownLink";
import JetNavLink from "@/Shared/NavLink";
import JetResponsiveNavLink from "@/Shared/ResponsiveNavLink";
import getEventbus from "../modules/GetEventbus";
import { MailIcon } from "@heroicons/vue/solid";

export default {
  components: {
    JetApplicationMark,
    JetBanner,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    MailIcon,
  },

  props: {
    backgroundImage: String,
  },

  setup(props) {
    const showingNavigationDropdown = ref(false);
    const eventBus = getEventbus();
    const unreadMessages = ref(0);
    const listOfUnreadMessages = ref({});

    const logout = () => {
      this.$inertia.post(route("logout"));
    };

    watch(
      () => listOfUnreadMessages,
      () => {
        unreadMessages.value = 0;

        for (const i in listOfUnreadMessages.value) {
          unreadMessages.value += listOfUnreadMessages.value[i];
        }
      },
      { deep: true }
    );

    eventBus.on("NumberOfUnreadMessages", (data) => {
      listOfUnreadMessages.value[data.user] = data.count;
    });

    return {
      showingNavigationDropdown,
      unreadMessages,
      logout,
    };
  },
};
</script>

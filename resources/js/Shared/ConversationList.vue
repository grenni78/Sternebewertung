<template>
  <div
    class="overflow-y-auto pl-3"
    aria-label="Directory"
    style="height: calc(100% - 3.5rem)"
  >
    <div class="relative">
      <div
        class="
          top-0
          border-t border-b border-gray-300
          bg-gray-100
          px-6
          text-sm
          font-medium
          text-gray-600
        "
      ></div>
      <div class="p-4 pl-6">
        <div class="mt-1 relative rounded-md shadow-sm">
          <div
            class="
              absolute
              inset-y-0
              left-0
              pl-1
              flex
              items-center
              pointer-events-none
            "
          >
            <SearchIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
          </div>
          <input
            type="text"
            name="user-search"
            id="user-search"
            class="
              focus:ring-indigo-500
              focus:border-indigo-500
              block
              w-full
              pl-10
              sm:text-sm
              text-gray-600
              border-gray-300
              rounded-md
            "
            placeholder="Unterhaltung suchen..."
            v-model.lazy="filter"
            v-debounce="300"
          />
          <Loader
            :scale="1"
            class="absolute left-1/2 top-[300px] mt-[-40px] z-10"
            v-if="modelValue.length < 1"
          />
        </div>
      </div>
    </div>
    <div
      v-for="letter in Object.keys(filteredValues)"
      :key="letter"
      class="relative"
    >
      <div
        class="
          z-10
          sticky
          top-0
          border-t border-b border-gray-200
          bg-gray-50
          px-6
          py-1
          text-sm
          font-medium
          text-gray-500
        "
      >
        <h3>{{ letter }}</h3>
      </div>
      <ul class="contactList relative z-0 divide-y divide-gray-200">
        <li
          v-for="person in filteredValues[letter]"
          :key="person.id"
          class="bg-white border-l-8 border-transparent"
          :id="`conversation-id-${person.partner.id}`"
          @click="conversationSelected($event, person.partner.id)"
        >
          <div
            class="
              relative
              px-6
              py-5
              flex
              items-center
              space-x-3
              hover:bg-gray-50
            "
          >
            <div class="flex-shrink-0 pointer-events-none relative">
              <img
                class="h-10 w-10 rounded-full"
                :src="person.partner.user.profile_photo_path"
                alt=""
              />
              <span
                v-if="person.unread_messages"
                class="
                  absolute
                  -bottom-0.5
                  -right-0.5
                  inline-flex
                  items-center
                  px-1.5
                  py-0.5
                  rounded-full
                  text-xs
                  font-medium
                  bg-green-700
                  text-green-200
                "
                >{{ person.unread_messages }}</span
              >
            </div>
            <div class="flex-1 min-w-0 pointer-events-none">
              <a href="#" class="focus:outline-none">
                <!-- Extend touch target to entire panel -->
                <span class="absolute inset-0" aria-hidden="true" />
                <p class="text-sm font-medium text-gray-900">
                  {{ person.partner.firstname + " " + person.partner.lastname }}
                </p>
                <p class="text-sm text-gray-500 truncate">
                  {{
                    person.partner.is_commercial
                      ? person.partner.company
                      : "privat"
                  }}
                </p>
              </a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { SearchIcon } from "@heroicons/vue/solid";
import { ref, watch, inject } from "vue";
import Loader from "../Shared/Loader.vue";
import getEventbus from "../modules/GetEventbus";

export default {
  props: {
    modelValue: {
      type: Array,
      default: [],
    },
    selected: {
      type: Number,
      default: 0,
    },
  },
  emits: ["selected"],

  components: {
    SearchIcon,
    Loader,
  },

  setup(props, { emit }) {
    const filteredValues = ref({});
    const userId = inject("userId");
    const currently_selected = ref(0);
    const contactList = ref(null);
    const eventBus = getEventbus();
    const filter = ref("");

    // filter the conversation list
    const filterConversations = function (ev) {
      // search string in Elements
      const filtered = props.modelValue.filter((el) => {
        // sort out messages sent by the current user

        //if (el.sender.id == userId.value) return false;

        const test = Object.values(el.sender).join("||") + "||" + el.content;

        return test.indexOf(ev) > -1;
      });

      filteredValues.value = {};
      // build Object with First Letters as keys
      filtered.forEach(function (el) {
        const otherUser =
          el.sender.id == userId.value ? el.recipient : el.sender;

        const firstChar = otherUser.lastname[0].toUpperCase();

        if (!filteredValues.value[firstChar]) {
          filteredValues.value[firstChar] = {};
        }

        if (!filteredValues.value[firstChar][otherUser.id]) {
          filteredValues.value[firstChar][otherUser.id] = {
            unread_messages: 0,
          };
        }

        filteredValues.value[firstChar][otherUser.id] = Object.assign(
          filteredValues.value[firstChar][otherUser.id],
          {
            partner: otherUser,
          }
        );

        if (el.unread && el.sender_id == otherUser.id) {
          filteredValues.value[firstChar][otherUser.id].unread_messages++;
        }

        eventBus.emit("NumberOfUnreadMessages", {
          user: otherUser.id,
          count: filteredValues.value[firstChar][otherUser.id].unread_messages,
        });
      });
    };

    // hilights the selected entry
    const highlight = function (el) {
      const old_els = document.querySelectorAll("ul.contactList > li");

      for (let i = 0; i < old_els.length; i++) {
        old_els[i].classList.remove("border-indigo-600");
        old_els[i].classList.add("border-transparent");
      }

      el.classList.remove("border-transparent");
      el.classList.add("border-indigo-600");
    };

    // event handler for when an entry is selected
    const conversationSelected = function (event, id) {
      emit("selected", id);
      currently_selected.value = id;
      if (event.target.nodeName != "LI") {
        highlight(event.target.parentNode);
      } else {
        highlight(event.target);
      }
    };

    watch(filter, () => {
      filterConversations(filter.value);
    });

    watch(
      () => props.modelValue,
      () => {
        filterConversations(filter.value);
        // select conversation. try at first the current selected, next the requested by url nad last the first in the sorted array
        const id = currently_selected.value
          ? currently_selected.value
          : props.selected
          ? props.selected
          : Object.keys(
              filteredValues.value[Object.keys(filteredValues.value)[0]]
            )[0];

        // wait for the dom to be recalculated
        setTimeout(
          () => document.getElementById(`conversation-id-${id}`)?.click(),
          200
        );
      },
      { deep: true }
    );

    eventBus.on("NewMessage", (data) => {
      // find the conversation and increment the "unread messages"- counter
      for (const letter in filteredValues.value) {
        const partner =
          data.sender_id == userId ? data.recipient_id : data.sender_id;

        if (partner in filteredValues.value[letter]) {
          filteredValues.value[letter][partner].unread_messages++;
        }
      }
    });

    filterConversations("");

    return {
      contactList,
      filteredValues,
      filterConversations,
      conversationSelected,
      filter,
    };
  },
};
</script>

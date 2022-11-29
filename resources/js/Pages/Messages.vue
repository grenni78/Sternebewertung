<template>
  <app-layout background-image="../img/dashboard-1920.jpg">
    <div
      class="
        md:w-[calc(100%+3rem)]
        -mx-2
        sm:-mx-6
        sm:w-[calc(100%+5rem)]
        h-screen-4
        flex flex-col
        sm:flex-row
        sm:auto-cols-max
        sm:h-3/4
        sm:max-h-3/4screen
        sm:-mr-6
        md:h-[75vh]
        -mb-4
      "
    >
      <transition
        name="fadeSlide"
        enter-active-class="transform transition ease-in-out duration-500 sm:duration-700"
        leave-active-class="transform transition ease-in-out duration-500 sm:duration-700"
        enter-from-class="-translate-x-full"
        enter-to-class="translate-x-0"
        leave-from-class="translate-x-0"
        leave-to-class="-translate-x-full"
      >
        <div
          v-show="open"
          class="
            fixed
            top-16
            bottom-0
            left-0
            w-full
            min-w-min
            sm:relative
            sm:flex-initial
            sm:w-1/3
            bg-white
            z-10
            shadow-xl
            sm:shadow-none
            sm:max-h-full
            sm:top-0
            sm:-my-4 sm:-mx-3
            md:max-h-screen
            md:h-[calc(100%+1rem)]
            md:flex-shrink-0
            md:w-96
            overflow-hidden
          "
        >
          <div
            class="
              sm:hidden
              absolute
              top-0
              right-0
              flex
              bg-gray-300
              border-b border-gray-300
            "
          >
            <button
              class="
                text-gray-500
                hover:text-white
                focus:outline-none
                focus:ring-2 focus:ring-blue-400
                p-2
                m-2
                rounded-full
              "
              @click="open = false"
            >
              <span class="sr-only">verbergen</span>
              <XIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
          <div
            class="
              bg-gray-300
              text-gray-600
              font-size-lg
              overflow-ellipsis
              p-4
              pl-6
              w-full
              leading-6
            "
          >
            Unterhaltungen
          </div>
          <conversation-list
            v-model="listOfConversations"
            :selected="contact"
            @selected="onConversationSelected"
          ></conversation-list>
        </div>
      </transition>
      <div class="sm:hidden w-full mb-2 border-b flex-grow-0 flex-shrink-0">
        <button
          class="
            flex
            text-gray-300
            hover:text-gray-600
            focus:text-gray-600
            w-auto
            h-8
            focus:outline-none
            focus:ring-2 focus:ring-blue-400
            p-1
            m-1
            rounded-full
          "
          @click="open = true"
          title="Unterhaltungen anzeigen"
        >
          <UsersIcon class="h-6 w-6" aria-hidden="true" />
          <span>Unterhaltungen anzeigen</span>
        </button>
      </div>
      <div
        class="
          w-full
          sm:w-auto
          flex-grow flex-shrink
          h-[calc(100%+1rem)]
          md:-mt-4
          md:pt-0
          flex flex-col
          bg-gradient-to-br
          from-gray-300
          to-indigo-500
          md:shadow-inner
        "
      >
        <div
          ref="messagesDisplay"
          class="
            w-full
            overflow-y-auto
            flex-grow flex-shrink
            md:overflow-y-hidden
            pr-[8px]
            md:hover:pr-0
            md:hover:overflow-y-scroll
            md:scrollbar-thin md:scrollbar-thumb-rounded
            scrollbar-track-indigo-700 scrollbar-thumb-indigo-300
            hover:scrollbar-thumb-gray-300
          "
        >
          <Conversation v-model="selectedConversation" />
        </div>
        <div class="w-full flex-grow-0 flex-shrink-0 h-[33vh] md:h-96">
          <Editor
            class="w-full h-full flex flex-col md:ml-2"
            v-model="html"
            editable
            @requestToSend="sendMessage"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import { ref, watch, inject, computed, provide, onMounted } from "vue";
import AppLayout from "../Layouts/AppLayout.vue";
import Conversation from "../Shared/Conversation.vue";
import ConversationList from "../Shared/ConversationList.vue";
import { XIcon, UsersIcon } from "@heroicons/vue/outline";
import Editor from "../Shared/Editor.vue";
import getEventbus from "../modules/GetEventbus";
import { usePage } from "@inertiajs/inertia-vue3";
import { messages as api } from "../api";

export default {
  components: {
    AppLayout,
    Conversation,
    ConversationList,
    XIcon,
    UsersIcon,
    Editor,
  },

  props: ["contact"],

  setup() {
    const open = ref(true);
    const html = ref("");
    const currently_chatting_to = ref(0);
    const listOfConversations = ref([]);
    const selectedConversation = ref([]);
    const userId = computed(() => usePage().props.value?.userDetails?.id);
    const eventBus = getEventbus();
    const messagesDisplay = ref(null);
    let observer = null;
    const timeouts = [];

    provide("userId", userId);
    provide("eventBus", eventBus);

    watch(listOfConversations, (value) => {
      onConversationSelected(currently_chatting_to.value);
    });

    watch(userId, (value) => {
      onConversationSelected(currently_chatting_to.value);
    });

    const messageDisplay_scrollToBottom = (restart_observer) => {
      setTimeout(() => {
        messagesDisplay.value.scroll({
          top: messagesDisplay.value.scrollHeight,
          behavior: "smooth",
        });
        if (restart_observer) observe_all_items();
      }, 150);
    };

    // start observing all Messages for visibility
    const observe_all_items = () => {
      // observe elements
      observer.disconnect();

      const messages = messagesDisplay.value.querySelectorAll(".message-item");

      messages.forEach((item) => {
        const assignedData = selectedConversation.value[item.dataset.idx];

        // only watch messages from forein users

        if (assignedData.unread && assignedData.sender_id != userId.value) {
          observer.observe(item);
        }
      });
    };

    // event handler for when a new conversation is selected
    const onConversationSelected = function (id) {
      const old_conversation = currently_chatting_to.value == id;
      currently_chatting_to.value = id;

      selectedConversation.value = listOfConversations.value.filter(
        (el) =>
          (el.sender_id == id && el.recipient_id == userId.value) ||
          (el.sender_id == userId.value && el.recipient_id == id)
      );
      // keep conversations open if the screen is big enough
      open.value = window.innerWidth >= 768 ? true : false;

      if (!old_conversation)
        setTimeout(() => {
          // scroll to bottom
          messageDisplay_scrollToBottom();

          observe_all_items();
        }, 150);
    };

    // event handler when message is to be sent
    const sendMessage = function () {
      api
        .send_message(html.value, currently_chatting_to.value)
        .then((data) => {
          listOfConversations.value.push(data);
          onConversationSelected(currently_chatting_to.value);
          messageDisplay_scrollToBottom();
          html.value = "";
        })
        .catch((error) => {
          console.error("Something went wrong: ", error?.message);
        });
    };

    // marks a message as read
    const markRead = function (entry) {
      //
      // stop observing this entry
      observer.unobserve(entry.target);

      const assignedData = selectedConversation.value[entry.target.dataset.idx];

      api.mark_read_message(true, assignedData.id).then(() => {
        selectedConversation.value[entry.target.dataset.idx].unread = false;
      });
    };

    // conctruct the intersection observer wir callback als closure
    const init_observer = () => {
      observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (timeouts[entry.target.dataset.idx]) {
              clearTimeout(timeouts[entry.target.dataset.idx]);
            }

            if (entry.isIntersecting) {
              timeouts[entry.target.dataset.idx] = setTimeout(() => {
                markRead(entry);
              }, 2000);
            } else {
              //
            }
          });
        },
        {
          root: messagesDisplay.value,
          threshold: 0.1,
        }
      );
    };

    // pull messages from server
    const get_messages = () => {
      api.get_messages().then((data) => {
        listOfConversations.value = data;
      });
    };

    const init_eventHandler = () => {
      // own message was read by foreign user
      eventBus.on("MessageRead", (data) => {
        let msg_idx = listOfConversations.value.findIndex(
          (el) => el.id == data.message_id
        );
        listOfConversations.value[msg_idx].unread = false;

        msg_idx = selectedConversation.value.findIndex(
          (el) => el.id == data.message_id
        );
        //        if (msg_idx) selectedConversation.value[msg_idx].unread = false;

        // message is from current chat
        if (
          listOfConversations.value[msg_idx].recipient_id ==
          currently_chatting_to.value
        ) {
          api.mark_read_message(true, data.message_id);
        }
      });
      // a new message was recieved
      eventBus.on("NewMessage", (data) => {
        api.get_message(data.message_id).then((data) => {
          listOfConversations.value.push(data);
          onConversationSelected(currently_chatting_to.value);
          messageDisplay_scrollToBottom(true);
        });
      });
    };

    onMounted(() => {
      init_eventHandler();
      init_observer();
      get_messages();
    });

    return {
      listOfConversations,
      selectedConversation,
      currently_chatting_to,
      userId,
      eventBus,
      observer,
      open,
      html,
      messagesDisplay,
      onConversationSelected,
      sendMessage,
    };
  },
};
</script>

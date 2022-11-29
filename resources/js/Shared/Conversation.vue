<template>
  <div class="flow-root p-8">
    <ul class="-mb-8">
      <li
        v-for="(messageItem, messageItemIdx) in modelValue"
        :key="messageItem.id"
        class="message-item"
        :data-idx="messageItemIdx"
        :data-unread="messageItem.unread"
      >
        <div class="relative pb-8">
          <span
            v-if="messageItemIdx !== modelValue.length - 1"
            class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
            aria-hidden="true"
          />
          <div class="relative flex items-start space-x-3">
            <div class="relative">
              <img
                class="
                  h-10
                  w-10
                  rounded-full
                  bg-gray-400
                  flex
                  items-center
                  justify-center
                  ring-2 ring-white
                "
                :src="messageItem.sender.user.profile_photo_path"
                alt=""
              />

              <!--<span
                v-if="messageItem.unread"
                class="
                  absolute
                  -bottom-0.5
                  -right-1
                  bg-red-600
                  rounded-full
                  w-2
                  h-2
                "
              >
              </span>-->
              <ClockIcon
                v-if="messageItem.sender_id == userId && messageItem.unread"
                class="
                  absolute
                  -bottom-1
                  -right-2
                  text-gray-800
                  bg-gray-100
                  w-5
                  h-5
                  rounded-full
                  animate-ping animate-iterate-1
                "
              />
              <StarIcon
                v-if="messageItem.sender_id != userId && messageItem.unread"
                class="
                  absolute
                  -bottom-1
                  -right-2
                  text-gray-800
                  bg-gray-100
                  w-5
                  h-5
                  rounded-full
                  animate-ping animate-iterate-1
                "
              />
            </div>
            <div
              :class="`
                min-w-0
                flex-1
                ${
                  messageItem.sender.user.id == userId
                    ? 'bg-green-200'
                    : 'bg-gray-100'
                }
                drop-shadow-md
                p-2
                relative
                -ml-5
                rounded-sm`"
            >
              <div>
                <div class="text-sm">
                  <a href="#" class="font-bold text-gray-900">{{
                    messageItem.sender.user.id == userId
                      ? "ich"
                      : messageItem.sender.user.name
                  }}</a>
                </div>
                <p class="mt-0.5 text-sm text-gray-500">
                  gesendet
                  {{ new Date(messageItem.created_at).toLocaleString() }}
                </p>
              </div>
              <div class="mt-2 text-sm text-gray-700">
                <p v-html="messageItem.content"></p>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { inject } from "vue";
import { UserCircleIcon } from "@heroicons/vue/solid";
import { ClockIcon, StarIcon } from "@heroicons/vue/solid";

export default {
  components: {
    UserCircleIcon,
    ClockIcon,
    StarIcon,
  },
  props: {
    modelValue: {
      type: Array,
      default: [],
    },
  },

  setup() {
    const userId = inject("userId");

    return {
      userId,
    };
  },
};
</script>

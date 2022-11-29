<template>
  <div class="editor w-screen sm:w-full h-full flex flex-col sm:mx-[-8px]">
    <div
      v-if="editor"
      :id="editorId"
      :class="classes + ' relative toolbar flex-grow-0'"
    >
      <Menu
        :items="toolbarItems"
        :toolbar="true"
        :editorId="editorId"
        @choosen="toolbarAction"
      />
      <!--
      <button @click="editor.chain().focus().undo().run()">undo</button>
      <button @click="editor.chain().focus().redo().run()">redo</button>
      -->
    </div>
    <div class="flex flex-row w-full flex-grow bg-gray-100 overflow-hidden">
      <editor-content
        :class="
          editorClasses +
          ' relative max-h-full w-full overflow-y-hidden overflow-x-hidden focus:outline-none'
        "
        :editor="editor"
      />
      <div class="flex-grow-0 w-24">
        <button
          class="
            border-0
            p-4
            text-gray-800
            h-full
            w-full
            text-center
            outline-none
            hover:border-none
            bg-gray-300
            hover:bg-gray-200
            transition-all
          "
          title="senden"
          @click="sendMessage"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 inline"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
              clip-rule="evenodd"
            />
            <path
              fill-rule="evenodd"
              d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import {
  mdiFormatBold,
  mdiFormatItalic,
  mdiFormatStrikethrough,
  mdiFormatUnderline,
  mdiCodeBraces,
  mdiFormatClear,
  mdiLayersRemove,
  mdiFormatListBulleted,
  mdiFormatListNumbered,
  mdiRuler,
  mdiWindowMinimize,
} from "@mdi/js";

import rand from "random-id";

import { Editor, EditorContent } from "@tiptap/vue-3";
import Document from "@tiptap/extension-document";
import Paragraph from "@tiptap/extension-paragraph";
import Text from "@tiptap/extension-text";
import Underline from "@tiptap/extension-underline";
import TextStyle from "@tiptap/extension-text-style";
import Superscript from "@tiptap/extension-superscript";
import Subscript from "@tiptap/extension-subscript";
import Strike from "@tiptap/extension-strike";
import Italic from "@tiptap/extension-italic";
import Code from "@tiptap/extension-code";
import Bold from "@tiptap/extension-bold";
import ListItem from "@tiptap/extension-list-item";
import BulletList from "@tiptap/extension-bullet-list";
import OrderedList from "@tiptap/extension-ordered-list";
import Image from "@tiptap/extension-image";
import Dropcursor from "@tiptap/extension-dropcursor";
import HorizontalRule from "@tiptap/extension-horizontal-rule";
import Heading from "@tiptap/extension-heading";
import HardBreak from "@tiptap/extension-hard-break";

import Blockquote from "@tiptap/extension-blockquote";
import Icon from "../Shared/MdiIcon.vue";
import Menu from "../Shared/Menu.vue";
import FindEmoji from "../modules/FindEmoji";

import { computed } from "@vue/runtime-core";

export default {
  props: {
    modelValue: {
      type: String,
      default: "",
    },
    classes: {
      type: String,
      default: "text-gray-600 bg-gray-300",
    },
    editorClasses: {
      String,
      default: "text-gray-800",
    },
  },
  emits: ["update:modelValue", "requestToSend"],
  components: {
    EditorContent,
    Icon,
    Menu,
  },
  data() {
    const toolbarItems = [];
    const editorId = "#editor-" + rand(5, "A0");

    return {
      editor: null,
      toolbarItems,
      editorId,
    };
  },

  /* composition API */
  watch: {
    modelValue(value) {
      const isSame = this.editor.getHTML() === value;

      if (isSame) {
        return;
      }

      this.editor.commands.setContent(this.modelValue, false);
    },
  },
  computed: {},
  methods: {
    addImage() {
      const url = window.prompt("URL");

      if (url) {
        this.editor.chain().focus().setImage({ src: url }).run();
      }
    },
    // a toolbar button was pressed
    toolbarAction(cmd) {
      const fn = cmd?.editorCmd;
      if (typeof fn == "function") {
        fn();
      }
    },
    // sends the current editor content so the server and clear the editor
    sendMessage() {
      /*const editor_content = this.editor.getHTML();

      this.editor.chain().clearContent(true).focus().run();*/

      this.$emit("requestToSend");
    },
  },
  mounted() {
    this.editor = new Editor({
      content: this.modelValue,
      extensions: [
        Document,
        Paragraph,
        Text,
        Underline,
        TextStyle,
        Superscript,
        Subscript,
        Strike,
        Italic,
        Code,
        Bold,
        ListItem,
        BulletList,
        OrderedList,
        Image,
        Dropcursor,
        HorizontalRule,
        Heading.configure({
          levels: [1, 2, 3, 4, 5],
        }),
        HardBreak,
        Blockquote,
      ],
      onUpdate: () => {
        this.$emit("update:modelValue", this.editor.getHTML());
      },
      editorProps: {
        handleDOMEvents: {
          keydown: (view, event) => {
            if (event.key === "Enter" && !event.shiftKey && !event.ctrlKey) {
              event.preventDefault();
              this.sendMessage();
              return true;
            }
            return false;
          },
        },
      },
    });

    const editor = this.editor;

    // Helper function for drawing svg (MDI) icon
    const mdiIcon = (path) => {
      return `<svg viewBox="0 0 24 24" fill="currentColor" height="24" width="24" class="mdi-icon" style="display inline-block">
              <path d="${path}"></path>
              </svg>`;
    };
    // builds the emoji List
    const emojisToInclude = [
      "grinning face",
      "grinning face with big eyes",
      "grinning face with smiling eyes",
      "grinning squinting face",
      "grinning face with sweat",
      "rolling on the floor laughing",
      "face with tears of joy",
      "slightly smiling face",
      "upside-down face",
      "winking face",
      "smiling face with smiling eyes",
      "smiling face with halo",
      "smiling face with hearts",
      "smiling face with heart-eyes",
      "star-struck",
      "face blowing a kiss",
      "face savoring food",
      "face with tongue",
      "winking face with tongue",
      "zany face",
      "hugging face",
      "shushing face",
      "face with hand over mouth",
      "thinking face",
      "zipper-mouth face",
      "face with raised eyebrow",
      "neutral face",
      "face without mouth",
      "smirking face",
      "unamused face",
      "face with rolling eyes",
      "grimacing face",
      "lying face",
      "relieved face",
      "drooling face",
      "sleeping face",
      "face with medical mask",
      "face with thermometer",
      "face with head-bandage",
      "nauseated face",
      "face vomiting",
      "sneezing face",
      "hot face",
      "cold face",
      "partying face",
      "smiling face with sunglasses",
      "nerd face",
      "face with monocle",
      "confused face",
      "worried face",
      "frowning face",
      "face with open mouth",
      "astonished face",
      "crying face",
      "loudly crying face",
      "tired face",
      "yawning face",
      "angry face",
      "face with symbols on mouth",
      "angry face with horns",
      "person facepalming",
      "skull",
      "pile of poo",
      "clown face",
      "ghost",
      "speak-no-evil monkey",
      "see-no-evil monkey",
      "hear-no-evil monkey",
    ];
    const symbolsToInclude = [
      "kiss mark",
      "love letter",
      "beating heart",
      "broken heart",
      "bomb",
      "waving hand",
      "raised hand",
      "hand with fingers splayed",
      "vulcan salute",
      "ok hand",
      "crossed fingers",
      "sign of the horns",
      "index pointing up",
      "thumbs up",
      "thumbs down",
      "clapping hands",
      "handshake",
      "brain",
      "bone",
      "eyes",
      "warning",
      "no entry",
      "right arrow",
      "left arrow",
      "up arrow",
      "down arrow",
      "red question mark",
      "exclamation question mark",
      "double exclamation mark",
      "check mark",
      "cross mark",
      "pirate flag",
      "white flag",
      "party popper",
      "balloon",
      "Christmas tree",
      "wrapped gift",
      "sports medal",
      "soccer ball",
      "egg plant",
      "birthday cake",
    ];
    const buildEmojiMenu = function (names) {
      const items = [];

      for (let i = 0; i < names.length; i++) {
        const emoji_name = names[i];
        const emoji = FindEmoji.byAnnotation(emoji_name)?.emoji;

        items.push({
          title: "",
          disabled: false,
          eventData: {
            editorCmd: () => editor.chain().focus().insertContent(emoji).run(),
          },
          content: emoji,
          class: "",
        });
      }

      return items;
    };

    // fill Toolbar
    this.toolbarItems.push(
      {
        title: "fett",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().toggleBold().run(),
        },
        content: mdiIcon(mdiFormatBold),
        classfn: function () {
          return editor.isActive("bold") ? "is-active" : "";
        },
      },
      {
        title: "kursiv",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().toggleItalic().run(),
        },
        content: mdiIcon(mdiFormatItalic),
        classfn: function () {
          return editor.isActive("italic") ? "is-active" : "";
        },
      },
      {
        title: "durchgestrichen",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().toggleStrike().run(),
        },
        content: mdiIcon(mdiFormatStrikethrough),
        classfn: function () {
          return editor.isActive("strike") ? "is-active" : "";
        },
      },
      {
        title: "unterstrichen",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().toggleUnderline().run(),
        },
        content: mdiIcon(mdiFormatUnderline),
        classfn: function () {
          return editor.isActive("underline") ? "is-active" : "";
        },
      },
      {
        title: "code",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().toggleCode().run(),
        },
        content: mdiIcon(mdiCodeBraces),
        classfn: function () {
          return editor.isActive("code") ? "is-active" : "";
        },
      },
      {
        title: "Formatierungen entfernen",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().unsetAllMarks().run(),
        },
        content: mdiIcon(mdiFormatClear),
        class: "",
      },
      {
        title: "Elemente entfernen",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().clearNodes().run(),
        },
        content: mdiIcon(mdiLayersRemove),
        class: "",
      },
      {
        title: "Überschrift",
        disabled: false,
        eventData: {},
        content:
          '<span style="font-weight:bold;font-size:24px;line-height:24px;">H</span>',
        class: "",
        items: [
          {
            title: "h1",
            disabled: false,
            eventData: {
              editorCmd: () =>
                editor.chain().focus().toggleHeading({ level: 1 }).run(),
            },
            content: "<h1>H1</h1>",
            classfn: function () {
              return editor.isActive("heading", { level: 1 })
                ? "is-active"
                : "";
            },
          },
          {
            title: "h2",
            disabled: false,
            eventData: {
              editorCmd: () =>
                editor.chain().focus().toggleHeading({ level: 2 }).run(),
            },
            content: "<h2>H2</h2>",
            classfn: function () {
              return editor.isActive("heading", { level: 2 })
                ? "is-active"
                : "";
            },
          },
          {
            title: "h3",
            disabled: false,
            eventData: {
              editorCmd: () =>
                editor.chain().focus().toggleHeading({ level: 3 }).run(),
            },
            content: "<h3>H3</h3>",
            classfn: function () {
              return editor.isActive("heading", { level: 3 })
                ? "is-active"
                : "";
            },
          },
          {
            title: "h4",
            disabled: false,
            eventData: {
              editorCmd: () =>
                editor.chain().focus().toggleHeading({ level: 4 }).run(),
            },
            content: "<h4>H4</h4>",
            classfn: function () {
              return editor.isActive("heading", { level: 4 })
                ? "is-active"
                : "";
            },
          },
          {
            title: "h5",
            disabled: false,
            eventData: {
              editorCmd: () =>
                editor.chain().focus().toggleHeading({ level: 5 }).run(),
            },
            content: "<h5>H5</h5>",
            classfn: function () {
              return editor.isActive("heading", { level: 5 })
                ? "is-active"
                : "";
            },
          },
        ],
      },
      {
        title: "Liste",
        disabled: false,
        eventData: {
          editorCmd: () =>
            editor
              .chain()
              .focus()
              .toggleBulletList({ HTMLAttributes: { class: "list-decimal" } })
              .run(),
        },
        content: mdiIcon(mdiFormatListBulleted),
        classfn: function () {
          return editor.isActive("bulletList") ? "is-active" : "";
        },
      },
      {
        title: "Aufzählung",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().toggleOrderedList().run(),
        },
        content: mdiIcon(mdiFormatListNumbered),
        classfn: function () {
          return editor.isActive("orderedList") ? "is-active" : "";
        },
      },
      {
        title: "horizontale Linie",
        disabled: false,
        eventData: {
          editorCmd: () => editor.chain().focus().setHorizontalRule().run(),
        },
        content: mdiIcon(mdiWindowMinimize),
        class: "",
      },
      {
        title: "Emojis",
        grid: true,
        disabled: false,
        eventData: {},
        content:
          '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"> \
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> \
           </svg>',
        class: "-ml-8",
        items: buildEmojiMenu(emojisToInclude),
      },
      {
        title: "Symbole",
        grid: true,
        disabled: false,
        eventData: {},
        content:
          '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"> \
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />\
           </svg>',
        class: "",
        items: buildEmojiMenu(symbolsToInclude),
      }
    );
  },

  beforeUnmount() {
    this.editor.destroy();
  },
};
</script>
<style>
@tailwind base;
@tailwind components;
@tailwind utilities;

div.ProseMirror {
  @apply absolute;
  @apply top-0;
  @apply left-0;
  @apply w-full;
  @apply shadow-inner;
  @apply bottom-0;
  @apply overflow-y-auto;
  @apply overflow-x-hidden;
  @apply sm:p-4;
  @apply p-2;
  outline: none;
}
.toolbar button {
  @apply border-0;
  @apply p-2;
}
.toolbar button:hover,
.toolbar button:active {
  @apply border-0;
}
button:hover,
button:active {
  @apply bg-gray-200;
  @apply border;
  @apply border-gray-600;
}
button:focus {
  @apply outline-none;
  @apply ring;
  @apply border-blue-300;
}
</style>

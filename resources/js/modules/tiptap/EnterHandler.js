import { Extension } from '@tiptap/core'
import { Plugin, PluginKey } from 'prosemirror-state'

export default class EnterHandler extends Extension {

  get name() {
    return 'enter_handler'
  }

    addAtrributes() {
        return {
            fnOnEnter: {
                default: () => { }
            }
        }
  }

  get plugins() {
    return [
        new Plugin({
          key: new PluginKey('enter_handler'),
        props: {
          handleKeyDown: (view, event) => {
            if (event.key === 'Enter' && ( !event.shiftKey || !event.controlKey) ) {
              // do something
              return true
            }

            return false
          },
        },
      }),
    ]
  }

}

import { Editor, Range } from '@tiptap/core'
import { Plugin, PluginKey } from 'prosemirror-state'
import { Decoration, DecorationSet, EditorView } from 'prosemirror-view'
import { ResolvedPos } from 'prosemirror-model'

export function findSuggestionMatch(config) {
  const {
    char,
    allowSpaces,
    startOfLine,
    $position,
  } = config

  // Matching expressions used for later
  const escapedChar = char
    .split('')
    .map(c => `\\${c}`)
    .join('')
  const suffix = new RegExp(`\\s${escapedChar}$`)
  const prefix = startOfLine ? '^' : ''
  const regexp = allowSpaces
    ? new RegExp(`${prefix}${escapedChar}.*?(?=\\s${escapedChar}|$)`, 'gm')
    : new RegExp(`${prefix}(?:^)?${escapedChar}[^\\s${escapedChar}]*`, 'gm')

  const isTopLevelNode = $position.depth <= 0
  const textFrom = isTopLevelNode
    ? 0
    : $position.before()
  const textTo = $position.pos
  const text = $position.doc.textBetween(textFrom, textTo, '\0', '\0')
  const match = Array.from(text.matchAll(regexp)).pop()

  if (!match || match.input === undefined || match.index === undefined) {
    return null
  }

  // JavaScript doesn't have lookbehinds; this hacks a check that first character is " "
  // or the line beginning
  const matchPrefix = match.input.slice(Math.max(0, match.index - 1), match.index)

  if (!/^[\s\0]?$/.test(matchPrefix)) {
    return null
  }

  // The absolute position of the match in the document
  const from = match.index + $position.start()
  let to = from + match[0].length

  // Edge case handling; if spaces are allowed and we're directly in between
  // two triggers
  if (allowSpaces && suffix.test(text.slice(to - 1, to + 1))) {
    match[0] += ' '
    to += 1
  }

  // If the $position is located within the matched substring, return that range
  if (from < $position.pos && to >= $position.pos) {
    return {
      range: {
        from,
        to,
      },
      query: match[0].slice(char.length),
      text: match[0],
    }
  }

  return null
}


export const EmojisPluginKey = new PluginKey('Emojis')

export function Emojis({
  pluginKey = EmojisPluginKey,
  editor,
  char = '@',
  allowSpaces = false,
  startOfLine = false,
  decorationTag = 'span',
  decorationClass = 'Emojis',
  command = () => null,
  items = () => [],
  render = () => ({}),
  allow = () => true,
}) {

  const renderer = render?.()

  return new Plugin({
    key: pluginKey,

    view() {
      return {
        update: async (view, prevState) => {
          const prev = this.key?.getState(prevState)
          const next = this.key?.getState(view.state)

          // See how the state changed
          const moved = prev.active && next.active && prev.range.from !== next.range.from
          const started = !prev.active && next.active
          const stopped = prev.active && !next.active
          const changed = !started && !stopped && prev.query !== next.query
          const handleStart = started || moved
          const handleChange = changed && !moved
          const handleExit = stopped || moved

          // Cancel when Emojis isn't active
          if (!handleStart && !handleChange && !handleExit) {
            return
          }

          const state = handleExit && !handleStart
            ? prev
            : next
          const decorationNode = document.querySelector(`[data-decoration-id="${state.decorationId}"]`)
          const props = {
            editor,
            range: state.range,
            query: state.query,
            text: state.text,
            items: (handleChange || handleStart)
              ? await items(state.query)
              : [],
            command: commandProps => {
              command({
                editor,
                range: state.range,
                props: commandProps,
              })
            },
            decorationNode,
            // virtual node for popper.js or tippy.js
            // this can be used for building popups without a DOM node
            clientRect: decorationNode
              ? () => {
                // because of `items` can be asynchrounous we’ll search for the current docoration node
                const { decorationId } = this.key?.getState(editor.state)
                const currentDecorationNode = document.querySelector(`[data-decoration-id="${decorationId}"]`)

                // @ts-ignore-error
                return currentDecorationNode.getBoundingClientRect()
              }
              : null,
          }

          if (handleExit) {
            renderer?.onExit?.(props)
          }

          if (handleChange) {
            renderer?.onUpdate?.(props)
          }

          if (handleStart) {
            renderer?.onStart?.(props)
          }
        },
      }
    },

    state: {
      // Initialize the plugin's internal state.
      init() {
        return {
          active: false,
          range: {},
          query: null,
          text: null,
          composing: false,
        }
      },

      // Apply changes to the plugin state from a view transaction.
      apply(transaction, prev) {
        const { composing } = editor.view
        const { selection } = transaction
        const { empty, from } = selection
        const next = { ...prev }

        next.composing = composing

        // We can only be suggesting if there is no selection
        // or a composition is active (see: https://github.com/ueberdosis/tiptap/issues/1449)
        if (empty || editor.view.composing) {
          // Reset active state if we just left the previous Emojis range
          if (
            (from < prev.range.from || from > prev.range.to)
            && !composing
            && !prev.composing
          ) {
            next.active = false
          }

          // Try to match against where our cursor currently is
          const match = findEmojisMatch({
            char,
            allowSpaces,
            startOfLine,
            $position: selection.$from,
          })
          const decorationId = `id_${Math.floor(Math.random() * 0xFFFFFFFF)}`

          // If we found a match, update the current state to show it
          if (match && allow({ editor, range: match.range })) {
            next.active = true
            next.decorationId = prev.decorationId ? prev.decorationId : decorationId
            next.range = match.range
            next.query = match.query
            next.text = match.text
          } else {
            next.active = false
          }
        } else {
          next.active = false
        }

        // Make sure to empty the range if Emojis is inactive
        if (!next.active) {
          next.decorationId = null
          next.range = {}
          next.query = null
          next.text = null
        }

        return next
      },
    },

    props: {
      // Call the keydown hook if Emojis is active.
      handleKeyDown(view, event) {
        const { active, range } = this.getState(view.state)

        if (!active) {
          return false
        }

        return renderer?.onKeyDown?.({ view, event, range }) || false
      },

      // Setup decorator on the currently active Emojis.
      decorations(state) {
        const { active, range, decorationId } = this.getState(state)

        if (!active) {
          return null
        }

        return DecorationSet.create(state.doc, [
          Decoration.inline(range.from, range.to, {
            nodeName: decorationTag,
            class: decorationClass,
            'data-decoration-id': decorationId,
          }),
        ])
      },
    },
  })
}

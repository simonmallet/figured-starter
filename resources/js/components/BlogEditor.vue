<template>
    <div>
        <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }" v-if="showMenuBar">
            <div class="menubar">

                <button
                    type="button"
                    class="menubar__button btn btn-light"
                    :class="{ 'is-active': isActive.bold() }"
                    @click="commands.bold"
                >
                    B
                </button>

                <button
                    type="button"
                    class="menubar__button btn btn-light"
                    :class="{ 'is-active': isActive.italic() }"
                    @click="commands.italic"
                >
                    i
                </button>

                <button
                    type="button"
                    class="menubar__button btn btn-light"
                    :class="{ 'is-active': isActive.strike() }"
                    @click="commands.strike"
                >
                    Strike
                </button>

                <button
                    type="button"
                    class="menubar__button btn btn-light"
                    :class="{ 'is-active': isActive.heading({ level: 1 }) }"
                    @click="commands.heading({ level: 1 })"
                >
                    H1
                </button>

                <button
                    type="button"
                    class="menubar__button btn btn-light"
                    :class="{ 'is-active': isActive.heading({ level: 2 }) }"
                    @click="commands.heading({ level: 2 })"
                >
                    H2
                </button>

                <button
                    type="button"
                    class="menubar__button btn btn-light"
                    :class="{ 'is-active': isActive.heading({ level: 3 }) }"
                    @click="commands.heading({ level: 3 })"
                >
                    H3
                </button>

            </div>
        </editor-menu-bar>
        <editor-content id="editor" class="editor__content" :editor="editor" />
    </div>
</template>

<script>
    import { Editor, EditorContent, EditorMenuBar } from 'tiptap'
    import {
        Heading,
        Bold,
        Italic,
        Strike,
    } from 'tiptap-extensions'

    export default {
        props: {'editable': {default: true}, 'showMenuBar': {default: true}, 'content': {default: ''}},
        data() {
            return {
                editor: new Editor({
                    extensions: [
                        new Heading({ levels: [1, 2, 3] }),
                        new Bold(),
                        new Italic(),
                        new Strike(),
                    ],
                    content: this.content,
                    editable: this.editable,
                    onUpdate: (state) => {
                        this.$emit('contentUpdated', state.getHTML());
                    }
                }),
            }
        },
        components: {
            EditorContent,
            EditorMenuBar,
        },
        beforeDestroy() {
            this.editor.destroy()
        },
    }
</script>

<template>
    <div>
        <div :class="'card text-' + (text ? text : 'white') + (color ? (' bg-' + color) : '') + (overlay ? ' well' : '') + (css ? ' ' + css : '')">
            <div class="card-header" v-if="title">
                <h4 :class="'m-b-0 text-' + (text ? text : 'white')"><mdi :icon="icon" v-if="icon"></mdi> <span v-html="title"></span></h4>
            </div>
            <div :class="'card-body' + (padding ? ' px-3 py-2' : 'p-0')">
                <slot></slot>
            </div>
            <div class="card-footer" v-if="$slots.footer">
                <slot name="footer"></slot>
            </div>
        </div>
        <div class="overlay" v-if="overlay">&nbsp;</div>
    </div>
</template>

<script>
    export default {
        props: {
            color: {
                required: false
            },
            icon: {
                required: false
            },
            title: {
                required: false
            },
            overlay: {
                required: false,
                default() {
                    return true;
                }
            },
            css: {
                required: false
            },
            text: {
                required: false
            },
            padding: {
                required: false,
                default() {
                    return true;
                }
            },
        }
    }
</script>

<style scoped>
    .overlay {
        background: #000;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: fixed;
        z-index: 98;
        opacity: 0.5;
    }
    .well {
        z-index: 99
    }
</style>
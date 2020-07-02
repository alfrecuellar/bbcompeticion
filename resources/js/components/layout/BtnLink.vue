<template>
    <a @click="emitClick" :class="'btn btn-' + color + ' ' + css" :title="title" :href="href">
        <mdi :icon="icon"></mdi> <span v-if="$slots.default"><slot></slot></span>
    </a>
</template>

<script>
    export default {
        props: [
            'css',
            'color',
            'title',
            'href',
            'icon',
        ],
        methods: {
            emitClick() {
                this.$emit('click');
            }
        }
    }
</script>

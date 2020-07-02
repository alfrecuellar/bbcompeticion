<template>
    <button :type="type ? type : 'button'" :class="'btn btn-' + color + ' ' + (css ? css : '')" :title="title" @click="click">
        <mdi :icon="icon"></mdi> <span v-if="$slots.default"><slot></slot></span>
    </button>
</template>

<script>
    export default {
        props: [
            'css',
            'color',
            'title',
            'icon',
            'type'
        ],
        methods : {
            click () {
                this.$emit('click');
            }
        }
    }
</script>

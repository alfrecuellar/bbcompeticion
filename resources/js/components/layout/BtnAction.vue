<template>
    <a :class="'btn btn-sm btn-outline-' + color + ' ' + (css ? css : '')" :title="title" :href="href ? href : '#'" @click.prevent="onclick">
        <mdi :icon="icon"></mdi>
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
            'method',
        ],
        methods : {
            onclick () {
                if (this.href) {
                    window.location = this.href;
                } else {
                    this.$emit('click');
                }
            }
        }
    }
</script>

<style scoped>
.btn-sm {
    padding: 0rem 0.5rem !important;
    font-size: 1rem !important;
}
</style>
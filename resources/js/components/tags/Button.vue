<template>
    <a class="dropdown-item" href="#" @click.prevent="index">
        <mdi :icon="icon"></mdi> &nbsp; {{ text }}
    </a>
</template>

<script>
    export default {
        props: ['type','text','icon'],
        methods: {
            index() {
                bus.$emit('tags-index');
            }
        }
    };
</script>
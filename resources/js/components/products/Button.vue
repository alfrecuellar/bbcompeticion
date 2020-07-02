<template>
    <button class="btn btn-outline-light my-2 my-sm-0 font-weight-bold" @click="create">
        <mdi icon="plus-thick" class="font-24"></mdi>
        Agregar Productos
    </button>
</template>

<script>
    export default {
        methods: {
            create() {
                bus.$emit('products-create');
            }
        }
    };
</script>
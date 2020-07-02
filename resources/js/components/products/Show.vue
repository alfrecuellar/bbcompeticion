<template>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog" aria-labelledby="productsCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div v-if="product" class="modal-content">
                <div class="modal-header bg-info text-white text-uppercase">
                    <h5 class="modal-title" id="productsCreateModalLabel">Datos del Producto</h5>
                </div>
                <div class="modal-body">
                    <div class="font-weight-bold h4">{{ product.name }}</div>
                    <div class="font-weight-bold">Precios</div>
                    <ul>
                        <li v-for="(price, index) in product.prices">
                            <span :class="{'font-weight-bold h4': !index}">{{ price.created_at | longdate }} - {{ price.amount | amount}}</span>
                        </li>
                    </ul>
                    <div class="font-weight-bold">Códigos</div>
                    <ul>
                        <li v-for="code in product.codes">{{ code.value }}</li>
                    </ul>
                    <div v-if="product.brand">
                        <span class="font-weight-bold">Marca:</span>
                        {{ product.brand.name }}
                    </div>
                    <div v-if="product.provider">
                        <span class="font-weight-bold">Proveedor:</span>
                        {{ product.provider.name }}
                    </div>
                    <div v-if="product.origin">
                        <span class="font-weight-bold">Origen:</span>
                        {{ product.origin.name }}
                    </div>
                    <div>
                        <span class="font-weight-bold">Descripción:</span>
                        {{ product.description }}
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <mdi icon="close"></mdi> Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" @click="edit">
                        <mdi icon="pencil"></mdi> Editar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product : null,
            };
        },
        mounted() {
            bus.$on('products-show', (product) => {
                this.product = product;
                $(this.$refs.modal).modal('show');
            });
        },
        methods: {
            edit() {
                $(this.$refs.modal).modal('hide');
                bus.$emit('products-edit', this.product);
                this.product = null;
            }
        }
    };
</script>
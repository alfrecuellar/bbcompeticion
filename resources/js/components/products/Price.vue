<template>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog" aria-labelledby="productsCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="productsCreateModalLabel">Cambiar Precio</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="name">Agregar Porcentaje</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input type="number" class="form-control text-right" v-model="percentage">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="name">Redondeo</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <select class="form-control text-right" v-model="rounding">
                                    <option :value="0">1</option>
                                    <option :value="1">10</option>
                                    <option :value="2">100</option>
                                    <option :value="3">1000</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <mdi icon="close"></mdi> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" @click="save">
                        <mdi icon="check"></mdi> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            products: {
                type: Array,
                default: []
            },
        },
        data() {
            return {
                percentage : null,
                rounding : 1,
            };
        },
        computed: {
            ids() {
                return _.map(this.products, (product) => product.id);
            }
        },
        mounted() {
            bus.$on('products-price', () => {
                this.clear();
                $(this.$refs.modal).modal('show');
            });
        },
        methods: {
            save() {
                axios.patch('/api/product/price', {
                        ids: this.ids,
                        percentage: this.percentage,
                        rounding: this.rounding,
                    })
                    .then(() => {
                        this.clear();
                        bus.$emit('products-updated-price');
                    });
            },
            clear() {
                this.percentage = null;
                this.rounding = 1;
                $(this.$refs.modal).modal('hide');
            }
        }
    };
</script>
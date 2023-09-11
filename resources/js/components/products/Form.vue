<template>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog" aria-labelledby="productsCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div v-if="action" class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="productsCreateModalLabel">
                        <template v-if="action == 'create'">Agregar Producto</template>
                        <template v-if="action == 'edit'">Editar Producto</template>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="name">Nombre</label>
                            <input v-model="name" id="name" type="text" class="form-control">
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="price">Precio Actual</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control text-right" v-model="price">
                                </div>
                            </div>
                        </div>
                        <div class="col-8" v-if="prices && prices.length">
                            <div class="form-group">
                                <label for="price">Precios Anteriores</label>
                                <select class="form-control">
                                    <option v-for="price in prices">
                                        {{ price.created_at | longdate }} - {{ price.amount | amount}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 form-group">
                            <label for="code">Código</label>
                            <vue-multiselect v-model="codes" label="value" track-by="id" :options="codes" @tag="addCodes"
                                :taggable="true" placeholder="Seleccionar" select-label="Agregar" :multiple="true"
                                deselect-label="Quitar" tag-placeholder="Nuevo" :selected-label="null">
                                <template slot="noOptions">
                                    <small class="font-weight-light font-italic text-secondary">No hay códigos todavía</small>
                                </template>
                            </vue-multiselect>
                        </div>
                        <div class="col-12 form-group">
                            <label for="brand">Marca</label>
                            <vue-multiselect v-model="brand" label="name" track-by="name" :options="brands" @tag="addBrand"
                                :taggable="true" placeholder="Seleccionar" select-label="Seleccionar"
                                deselect-label="Quitar" tag-placeholder="Nuevo" selected-label="Selecionado">
                                <template slot="noOptions">
                                    <small class="font-weight-light font-italic text-secondary">No hay marcas todavía</small>
                                </template>
                            </vue-multiselect>
                        </div>
                        <div class="col-6 form-group">
                            <label for="provider">Proveedor</label>
                            <vue-multiselect v-model="provider" label="name" track-by="name" :options="providers" @tag="addProvider"
                                :taggable="true" placeholder="Seleccionar" select-label="Seleccionar"
                                deselect-label="Quitar" tag-placeholder="Nuevo" selected-label="Selecionado">
                                <template slot="noOptions">
                                    <small class="font-weight-light font-italic text-secondary">No hay proveedores todavía</small>
                                </template>
                            </vue-multiselect>
                        </div>
                        <div class="col-6 form-group">
                            <label for="origin">Origen</label>
                            <vue-multiselect v-model="origin" label="name" track-by="name" :options="origins" @tag="addOrigin"
                                :taggable="true" placeholder="Seleccionar" select-label="Seleccionar"
                                deselect-label="Quitar" tag-placeholder="Nuevo" selected-label="Selecionado">
                                <template slot="noOptions">
                                    <small class="font-weight-light font-italic text-secondary">No hay origenes todavía</small>
                                </template>
                            </vue-multiselect>
                        </div>
                        <div class="col-12 form-group">
                            <label for="description">Descripción</label>
                            <textarea v-model="description" id="description" class="form-control"></textarea>
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
            brands: {
                type: Array,
                default: []
            },
            providers: {
                type: Array,
                default: []
            },
            origins: {
                type: Array,
                default: []
            },
        },
        data() {
            return {
                action : null,
                id : null,
                name : null,
                price : null,
                prices : null,
                codes : [],
                brand : null,
                provider : null,
                origin : null,
                description : null,
            };
        },
        mounted() {
            bus.$on('products-create', () => {
                this.clear();
                this.action = 'create';
                $(this.$refs.modal).modal('show');
            });
            bus.$on('products-edit', (product) => {
                this.clear();
                this.action = 'edit';
                this.id = product.id;
                this.name = product.name;
                this.prices = product.prices;
                this.codes = product.codes ? product.codes : [];
                this.brand = product.brand;
                this.provider = product.provider;
                this.origin = product.origin;
                this.description = product.description;

                $(this.$refs.modal).modal('show');
            });
        },
        methods: {
            addCodes(code) {
                this.codes.push({value:code});
            },
            addBrand(brand) {
                this.saveTag(brand, 'brand', (tag) => {
                    this.brands.push(tag);
                    this.brand = tag;
                });
            },
            addProvider(provider) {
                this.saveTag(provider, 'provider', (tag) => {
                    this.providers.push(tag);
                    this.provider = tag;
                });
            },
            addOrigin(origin) {
                this.saveTag(origin, 'origin', (tag) => {
                    this.origins.push(tag);
                    this.origin = tag;
                });
            },
            saveTag(name, type, callback) {
                axios.post('/api/tag', {name: name, type: type})
                    .then((response) => {
                        callback(response.data);
                    });
            },
            save() {
                let product = {
                    name : this.name,
                    price : this.price,
                    codes : this.codes,
                    brand : this.brand,
                    provider : this.provider,
                    origin : this.origin,
                    description : this.description,
                };
                if (this.action == 'edit') {
                    axios.patch('/api/product/' + this.id, product)
                        .then((response) => {
                            bus.$emit('products-updated', response.data);
                            this.clear();
                        });

                } else {
                    axios.post('/api/product', product)
                        .then((response) => {
                            bus.$emit('products-stored', response.data);
                            this.clear();
                        });
                }
            },
            clear() {
                this.action = null;
                this.id = null;
                this.name = null;
                this.price = null;
                this.prices = null;
                this.codes = [],
                this.brand = null;
                this.provider = null;
                this.origin = null;
                this.description = null;
                $(this.$refs.modal).modal('hide');
            }
        }
    };
</script>
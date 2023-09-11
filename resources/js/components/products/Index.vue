<template>
    <div>
        <vue-good-table
            v-if="columns.length"
            :columns="columns"
            :rows="products"
            :options="options"
            :select-options="selectOptions"
            @on-selected-rows-change="setSelectedRows"
            :fixed-header="true"
            styleClass="vgt-table table-hover"
            :line-numbers="true">
            <template slot="table-row" slot-scope="props">
                <template v-if="props.column.html">
                    <template v-if="props.column.field == 'name'">
                        <a href="javascript:;" @click="show(props.row)" class="font-weight-bold">{{ props.row['name'] }}</a>
                    </template>
                    <template v-if="props.column.field == 'codes'"><!-- eslint-disable-next-line -->
                        <span v-for="code in props.row['codes']" class="badge badge-info text-white mx-1">{{ code.value }}</span>
                    </template>
                    <template v-if="props.column.field == 'price' && props.row['price']">
                        <span class="font-weight-bold">{{ props.row['price']['amount'] | amount }}</span>
                    </template>
                    <template v-if="props.column.field == 'id'">
                        <btn-group>
                            <btn-action color="success" title="Ver" @click="show(props.row)" icon="magnify"></btn-action>
                            <btn-action color="primary" title="Editar" @click="edit(props.row)" icon="pencil"></btn-action>
                            <btn-action color="danger" title="Eliminar" @click="remove(props.row)" icon="trash-can"></btn-action>
                        </btn-group>
                    </template>
                </template>
                <template v-else>
                  {{ props.formattedRow[props.column.field] }}
                </template>
            </template>
            <template slot="selected-row-actions">
                <btn color="outline-primary" icon="currency-usd" @click="showPostpones">Cambiar Precio</btn>
            </template>
        </vue-good-table>
        <products-form :brands="brands" :providers="providers" :origins="origins"></products-form>
        <products-show></products-show>
        <products-price
            :products="selectedRows">
        </products-price>
    </div>
</template>

<script>
    export default {
        data: () => ({
            product: null,
            brands: [],
            providers: [],
            origins: [],
            products: [],
            selectedRows: [],
            columns: [],
            loading : false,
            params: [],
            options: {
                styleClass : 'table',
                nextText : 'Siguiente',
                prevText : 'Anterior',
                rowsPerPageText : 'Productos por Página',
                ofText : 'de',
                allText : 'Todo',
                theme : 'black-rhino'
            },
            selectOptions: {
                enabled: true,
                selectOnCheckboxOnly: true,
                selectionInfoClass: '',
                selectionText: 'productos seleccionados',
                clearSelectionText: 'x',
                disableSelectInfo: false,
                selectAllByGroup: false,
            },
        }),
        watch: {
            items(items) {
                this.setColumns();
                this.load();
            },
        },
        mounted() {
            this.stored();
            this.updated();
            this.updatedPrice();

            this.loadTags();
            this.setColumns();
            this.loadProducts();
        },
        methods: {
            setColumns() {
                let columns = [];
                columns.push({
                    label: 'Producto',
                    field: 'name',
                    thClass: 'align-middle',
                    html : true,
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Buscar por Nombre',
                    },
                    sortable: true,
                });
                columns.push({
                    label: 'Codigos',
                    field: 'codes',
                    thClass: 'align-middle',
                    html : true,
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Buscar por Codigo',
                        filterFn: (prices, keyword) => {
                            let matching = false;
                            _.each(prices, (price) => {
                                const priceValue = price.value.toLowerCase();
                                const keywordValue = keyword.toLowerCase();
                                if(priceValue.startsWith(keywordValue) || priceValue.endsWith(keywordValue)) {
                                    matching = true;
                                }
                            });
                            return matching;
                        }
                    },
                    sortable: false,
                });
                /*columns.push({
                    label: 'Origen',
                    field: 'origin.name',
                    thClass: 'align-middle',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Buscar por Origen',
                    },
                    sortable: true,
                    sortFn: (x, y, col, rowX, rowY) => {
                        let tagX = '';
                        let tagY = '';
                        _.each(rowX.tags, (tag) => {
                            if(tag.parent.name == 'origin') {
                                tagX = tag.name
                            }
                        });
                        _.each(rowY.tags, (tag) => {
                            if(tag.parent.name == 'origin') {
                                tagY = tag.name
                            }
                        });
                        return (tagX < tagY ? -1 : (tagX > tagY ? 1 : 0));
                    }
                });*/
                columns.push({
                    label: 'Marca',
                    field: 'brand.name',
                    thClass: 'align-middle',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Buscar por Marca',
                    },
                    sortable: true,
                });
                columns.push({
                    label: 'Proveedor',
                    field: 'provider.name',
                    thClass: 'align-middle',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Buscar por Proveedor',
                    },
                    sortable: true,
                });
                columns.push({
                    label: 'Precio',
                    field: 'price',
                    thClass: 'align-middle',
                    tdClass: 'text-right',
                    html : true,
                    sortable: true,
                    sortFn: (x, y, col, rowX, rowY) => {
                        let priceX = parseInt(x.amount);
                        let priceY = parseInt(y.amount);
                        return (priceX < priceY ? -1 : (priceX > priceY ? 1 : 0));
                    }
                });
                columns.push({
                    label: '',
                    field: 'id',
                    tdClass : 'text-right',
                    thClass: 'align-middle',
                    width: '80px',
                    html : true,
                    sortable: false,
                });
                this.columns = columns;
            },
            loadTags() {
                axios.get('/api/tag')
                    .then((response) => {
                        this.brands = response.data.brands;
                        this.providers = response.data.providers;
                        this.origins = response.data.origins;
                    });
            },
            loadProducts() {
                this.products = [];
                this.loading = true;
                axios.get('/api/product', {params: this.params})
                    .then((response) => {
                        this.products = response.data;
                        this.loading = false;
                    }).catch(error => {
                        console.log(error);
                        this.loading = false;
                    });
            },
            updateProducts(product, push) {
                let index = null;
                _.each(this.products, (item, i) => {
                    if(item.id == product.id) {
                         index = i;
                    }
                });
                if (push) {
                    this.products.splice(index, 1, product);
                }
                else {
                    this.products.splice(index, 1);
                }
            },
            show(product) {
                bus.$emit('products-show', product);
            },
            edit(product) {
                bus.$emit('products-edit', product);
            },
            remove(product) {
                bus.$emit('confirm-show', {
                    color : 'danger',
                    title : 'Eliminar Producto',
                    text : '¿Confirma que quiere eliminar el producto <b>' + product.name + '</b>?',
                    callback : () => {
                        axios.delete('/api/product/' + product.id)
                            .then((response) => {
                                this.updateProducts(product, false);
                            }).catch(error => {
                                console.log(error);
                            });
                    }
                });
            },
            updated() {
                bus.$on('products-updated', (product) => {
                    this.updateProducts(product, true);
                });
            },
            updatedPrice() {
                bus.$on('products-updated-price', () => {
                    this.loadProducts();
                });
            },
            stored() {
                bus.$on('products-stored', (product) => {
                    this.products.push(product);
                });
            },
            setSelectedRows(params) {
                const selectedRows = params.selectedRows ? params.selectedRows.length : null;
                this.selectOptions.selectionText = selectedRows === 1 ? 'productos seleccionados' : 'productos seleccionados';
                this.selectedRows = params.selectedRows;
            },
            showPostpones() {
                bus.$emit('products-price');
            },
        }
    };
</script>

<style scoped>
    .dropdown-menu {
        padding-top: 0px;
        padding-bottom: 0px;
    }
</style>
<template>
    <div class="modal in" tabindex="-1" role="dialog" ref="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div :class="'modal-header text-white text-uppercase bg-' + color">
                    <h5 class="modal-title" v-html="title"></h5>
                </div>
                <div class="modal-body">
                    <p v-html="text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <mdi icon="close"></mdi> Cancelar
                    </button>
                    <button type="button" :class="'btn btn-' + color" @click="confirm">
                        <mdi icon="check"></mdi> Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                color : null,
                title : null,
                text : null,
                callback : null,
            }
        },
        mounted () {
            bus.$on('confirm-show', this.show);
        },
        methods: {
            show (options) {
                $(this.$refs.modal).modal('show');
                this.color = options.color ? options.color : 'primary';
                this.title = options.title;
                this.text = options.text;
                this.callback = options.callback;
            },
            hide () {
                $(this.$refs.modal).modal('hide');
            },
            confirm () {
                this.callback();
                this.hide();
            }
        }
    }
</script>
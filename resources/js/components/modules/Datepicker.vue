<template>
    <div>
        <input type="type" :id="id" class="form-control" :value="formatedDisplay">
        <input type="hidden" :name="name" :value="formatedOutput">
    </div>
</template>

<script>

    export default {
        props : {
            value : null,
            formatDisplay : {
                type: [String],
                default: 'DD-MM-YYYY'
            },
            formatInput : {
                type: [String],
                default: 'YYYY-MM-DD'
            },
            formatOutput : {
                type: [String],
                default: 'YYYY-MM-DD'
            },
            name : {
                default : null
            },
            minView : {
                default : 'days'
            },
            monthDay : {
                default : 'start'
            }
        },
        data () {
            return {
                id : Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5),
                formatedInput : null,
                formatedOutput : null,
                formatedDisplay : null,
            }
        },
        watch: {
            value (value) {
                if (value) {
                    this.formatedDisplay = moment(value, this.formatInput).format(this.formatDisplay);
                    this.formatedOutput = moment(value, this.formatInput).format(this.formatOutput);
                    this.$emit('input', this.formatedOutput);

                    let date = moment(value).toDate();
                    $('#' + this.id).data('datepicker').selectDate(date);
                }
            },
        },
        mounted () {
            let app = this;
            $('#' + this.id).datepicker({
                autoClose : true,
                language: 'es',
                dateFormat : app.formatDisplay,
                view : app.minView,
                minView : app.minView,
                onSelect (formattedDate, date, inst) {
                    if (date) {
                        let moment_date = moment(date);
                        if (app.minView == 'months') {
                            if(app.monthDay == 'start') {
                                moment_date.startOf('month');
                            } else {
                                moment_date.endOf('month')
                            }
                        }
                        app.formatedDisplay = moment_date.format(app.formatDisplay);
                        app.formatedOutput = moment_date.format(app.formatOutput);
                    } else {
                        app.formatedDisplay = null;
                        app.formatedOutput = null;
                    }
                    app.$emit('input', app.formatedOutput);
                }
            });
            if (this.value) {
                let date = moment(this.value);
                $('#' + this.id).data('datepicker').selectDate(date.toDate());
            }
        }
    }
</script>

<style>

</style>
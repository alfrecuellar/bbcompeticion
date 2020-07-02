<template>
    <i :class="classes"></i>
</template>

<script>
    export default {
        props : ['icon','css','features'],
        computed : {
            classes() {
                let features = this.features ? _.map(this.features.split(' '), (feature) => {
                    return 'mdi-' + feature;
                }).join(' ') : '' ;
                return 'mdi mdi-' + this.icon + ' ' + (this.css ? this.css : '') + ' ' + features;
            }
        }
    }
</script>

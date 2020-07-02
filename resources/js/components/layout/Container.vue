<template>
    <div>
        <div class="row">
            <div :class="$slots.buttons ? 'col-12 col-sm-5': 'col-12'">
                <h4 class="d-inline"><mdi :icon="icon" css="mr-1 font-24" v-if="icon"></mdi> <span v-html="title" class="font-20"></span></h4>
                <p class="text-muted m-t-0 mb-2 mb-sm-4 font-16" v-if="subtitle">
                    <mdi :icon="subicon" css="mr-1" v-if="subicon"></mdi>
                    {{ subtitle }}
                </p>
            </div>
            <div class="col-12 col-sm-7 text-sm-right mb-3 mb-sm-0" v-if="$slots.buttons">
                <btn-group>
                    <slot name="buttons"></slot>
                </btn-group>
            </div>
        </div>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: [
            'icon',
            'title',
            'subtitle',
            'subicon',
        ]
    }
</script>
<template>
    <div :class="'row' + (border ? ' border-bottom border-grey mb-3' : '')">
        <div :class="$slots.buttons ? 'col-12 col-sm-6': 'col-12'">
            <h4 class="card-title" v-if="title">
                <mdi :icon="icon" css="mr-1" v-if="icon"></mdi>
                <a v-if="href" :href="href" v-html="title"></a>
                <span v-else v-html="title"></span>
            </h4>
            <h6 class="card-subtitle mb-2 text-muted" v-if="subtitle" v-html="subtitle"></h6>
        </div>
        <div class="col-12 col-sm-6 text-sm-right mb-2 mb-sm-0" v-if="$slots.buttons">
            <btn-group>
                <slot name="buttons"></slot>
            </btn-group>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'icon',
            'border',
            'title',
            'href',
            'subtitle',
        ]
    }
</script>
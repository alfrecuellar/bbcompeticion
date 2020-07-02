<template>
    <div class="card">
        <div class="card-header py-2" v-if="headerTitle">
            <div class="row">
                <div :class="$slots.headerButtons ? 'col-12 col-sm-5': 'col-12'">
                    <b class="m-b-0" >
                        <mdi v-if="headerIcon" :icon="headerIcon" css="mr-1"></mdi>
                        <a v-if="headerHref" :href="headerHref">{{ headerTitle }}</a>
                        <span v-else v-html="headerTitle"></span>
                    </b>
                    <span v-if="headerSubtitle"> - {{ headerSubtitle }}</span>
                </div>
                <div class="col-12 col-sm-7 text-sm-right mb-3 mb-sm-0" v-if="$slots.headerButtons">
                    <btn-group>
                        <slot name="headerButtons"></slot>
                    </btn-group>
                </div>
            </div>
        </div>
        <div :class="'card-body pt-3 ' + ((!$slots.default && $slots.table) ? 'pb-2' : 'pb-0')" v-if="$slots.default || cardTitle || $slots.cardButtons">
            <card-title :title="cardTitle" :href="cardTitleHref" :subtitle="cardSubtitle" :icon="cardIcon" :border="cardBorder">
                <template slot="buttons" v-if="$slots.cardButtons">
                    <slot name="cardButtons"></slot>
                </template>
            </card-title>
            <slot></slot>
        </div>
        <slot name="table"></slot>
        <div class="card-footer" v-if="$slots.footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'headerTitle',
            'headerSubtitle',
            'headerHref',
            'headerIcon',
            'cardIcon',
            'cardTitle',
            'cardTitleHref',
            'cardSubtitle',
            'cardBorder',
        ]
    }
</script>
<template>
    <div class="wpr-bar">
        <div class="cnr-bar" :class="status">
            <div class="bar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                 :style="'width: ' + total + '%'"></div>
        </div>
        <span v-if="status==='loading'" id="percent">{{total}} %</span>
    </div>
</template>

<script>
    export default {
        name: "v-bar",
        props: {
            status: {
                type: String,
                default: 'done'
            },
            total: {
                type: Number,
                default: 0
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wpr-bar {
        flex-grow: 1;
        display: flex;
        align-items: center;
    }
    .cnr-bar {
        flex-grow: 1;
        overflow: hidden;
        background: $gray-dark;
        border-radius: 10px;
        height: 4px;
        margin-right: 1.6vw;
        @include animate();

        .bar {
            height: 4px;
            background: $gray-dark;
            -webkit-transition: width 0.6s ease;
            transition: width 0.6s ease;
            border-radius: 10px;
            @include animate();
        }

        &.loading {
            background: $gray-light;

            .bar {
                background-color: #fff;
            }
        }

        &.error, &.error .bar{
            background: $red
        }
    }

    #percent {
        font-size: 1.1vw;
        font-style: italic;
    }
</style>

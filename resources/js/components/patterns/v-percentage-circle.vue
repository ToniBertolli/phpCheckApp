<template>
    <div>
        <svg viewBox="0 0 36 36" class="circular-chart">
            <path class="circle-bg"
                  d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
            />
            <path class="circle" :class="strokeColor"
                  :stroke-dasharray="total + ', 100'"
                  d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
            />
            <text v-if="hasText" x="18" y="20.35" class="percentage">{{total}}%</text>
        </svg>
    </div>
</template>

<script>
    export default {
        name: "v-percentage-circle",
        props: {
            hasText: {
                type: Boolean,
                default: true
            },
            total: {
                type: Number,
                default: 0
            }
        },
        computed: {
            strokeColor() {
                return this.total === 100 ? 'green' : 'red';
            }
        },
    }
</script>

<style lang="scss" scoped>
    .circular-chart {
        display: block;
        margin: 0 auto;
        max-height: 23vh;
    }

    .circle-bg {
        fill: none;
        stroke: $gray-lighter;
        stroke-width: 0.03vw;
    }

    .circle {
        fill: none;
        stroke-width: 0.03vw;
        stroke-linecap: round;
        @include animateslow();

        &.green {
            stroke: $green;
        }

        &.red {
            stroke: $red;
        }
    }

    .percentage {
        fill: #fff;
        font-family: $font-family-base;
        font-weight: 800;
        font-size: 0.25vw;
        letter-spacing: 0.008vw;
        text-anchor: middle;
    }
</style>

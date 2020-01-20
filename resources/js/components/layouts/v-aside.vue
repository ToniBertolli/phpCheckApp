<template>
    <div id="wpr-numbers">
        <div class="widget-number">
            <span>{{getNumber(endpoints)}}</span>
            <h4>Endpoints</h4>
        </div>
        <div class="widget-number">
            <span>{{getNumber(instances)}}</span>
            <h4>instances</h4>
        </div>
        <div class="widget-number">
            <span>{{getNumber(checksToday)}}</span>
            <h4>checks today</h4>
        </div>
        <div class="widget-number">
            <span>{{getNumber(errorsThisWeek)}}</span>
            <h4>errors this week</h4>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-aside",
        props: {
            endpoints: {
                type: Number,
                default: 0
            },
            instances: {
                type: Number,
                default: 0
            },
            checksToday: {
                type: Number,
                default: 0
            },
            errorsThisWeek: {
                type: Number,
                default: 0
            },
        },
        methods: {
            getNumber(num) {
                return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) + 'k' : Math.sign(num) * Math.abs(num);
            }
        }
    }
</script>

<style lang="scss" scoped>
    #wpr-numbers {
        padding: 3.6vh 0;
        display: flex;
        align-items: stretch;
        flex-wrap: wrap;
    }

    .widget-number {
        width: 100%;
        text-align: center;

        span {
            display: block;
            font-size: 4.5vw;
            color: $gray;
            letter-spacing: 0.3vw;
            line-height: 1;
            font-weight: 800;
            margin-bottom: 0.4vh;
            -webkit-text-fill-color: transparent;
            -webkit-text-stroke-width: .12vw;
            -webkit-text-stroke-color: $blue-gradient;
        }
    }
</style>

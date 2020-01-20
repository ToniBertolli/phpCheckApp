<template>
    <div class="wpr-server-bar">
        <div class="overlay" :style="'width:'+ calcPercent + '%;'"></div>
        <div class="cnr-server-bar">
            <div v-for="n in 20"><span></span></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-servers",
        props: {
            percent: {
                type: Number,
                default: 100
            }
        },
        computed: {
            calcPercent() {
                return (100 - this.percent);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wpr-server-bar {
        position: relative;

        .overlay {
            background: $gray-light;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            z-index: 2;
            width: 100%;
            @include animate();
        }

        .cnr-server-bar {
            margin-left: -1.875%;
            margin-right: -1.875%;
            display: flex;

            div {
                width: 5%;
                display: block;
                padding: 0 1.875%;

                span {
                    display: block;
                    width: 100%;
                    height: 1.5vw;
                    background: $green;
                }

                &:nth-child(n) {
                    span {
                        background: $green;
                    }
                }

                &:nth-child(n+8) {
                    span {
                        background: $orange;
                    }
                }

                &:nth-child(n+15) {
                    span {
                        background: $red;
                    }
                }
            }
        }
    }
</style>

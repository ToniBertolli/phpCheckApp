<template>
    <div id="wpr-errors" >
        <div class="text">
            <p ref="pError" :style="{animationDuration: animationDur + 's', animationDelay: '-' + animationDelay + 's'}">
                <span v-for="error in errors">{{error.code}} {{error.reason}}</span>
            </p>
        </div>
        <div class="text">
            <p :style="{animationDuration: animationDur + 's'}">
                <span v-for="error in errors">{{error.code}} {{error.reason}}</span>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-errors",
        props: {
            errors: {
                type: Array,
                default: []
            }
        },
        data() {
           return {
               animationDur: 0,
               animationDelay: 0,
           }
        },
        mounted() {
            let temp = this.$refs.pError.offsetWidth;
            temp = (temp * 1.6) / 100;
            this.animationDur = temp;
            this.animationDelay = temp / 2 ;
        },
    }
</script>

<style lang="scss" scoped>
    #wpr-errors {
        position: relative;
        width: 100%;
        height: 100%;

        .text {
            width: 100%;
            margin: 0.15vw auto 0;
            white-space: nowrap;
            overflow: hidden;
            position: absolute;

            p {
                display: inline-block;
                padding-left: 100%;
                animation: marquee 50s linear infinite;
                animation-play-state: running;

                span {
                    font-size: 1.1vw;
                    letter-spacing: 0.01vw;
                    font-weight: 500;
                    font-style: italic;
                    padding: 0 1vw;
                }
            }
        }

        &:hover {
            .text {
                p {
                    animation-play-state: paused;
                }
            }
        }
    }

    @keyframes marquee {
        0% {
            transform: translate(0, 0);
        }
        100% {
            transform: translate(-100%, 0);
        }
    }
</style>

<template>
    <div id="wpr-errorfree" v-if="error">
        <p><span class="big">{{getNumber(days)}}</span><span class="small">DAYS</span></p>
        <p><span class="big">{{getNumber(hours)}}</span><span class="small">HOURS</span></p>
        <p><span class="big">{{getNumber(minutes)}}</span><span class="small">MINUTES</span></p>
        <p><span class="big">{{getNumber(seconds)}}</span><span class="small">SECONDS</span></p>
    </div>
</template>

<script>
    export default {
        name: "v-error-free",
        props: {
            error: {
                type: Object,
            }
        },
        data() {
            return {
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
            }
        },
        watch: {
            error() {
                const that = this;
                setInterval(function () {
                    that.updateDate();
                }, 123);
            }
        },
        methods: {
            getNumber(num) {
                return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) + 'k' : Math.sign(num) * Math.abs(num);
            },
            updateDate() {
                let now = Date.now();
                let errorDate = new Date(this.error.created_at);
                let diff = Math.abs(now - errorDate) / 1000;

                // calculate (and subtract) whole days
                this.days = Math.floor(diff / 86400);
                diff -= this.days * 86400;

                // calculate (and subtract) whole hours
                this.hours = Math.floor(diff / 3600) % 24;
                diff -= this.hours * 3600;

                // calculate (and subtract) whole minutes
                this.minutes = Math.floor(diff / 60) % 60;
                diff -= this.minutes * 60;

                // what's left is seconds
                let temp = diff % 60;
                this.seconds = Math.floor(temp);  // in theory the modulus is not required
            },
        }
    }
</script>

<style lang="scss" scoped>
    #wpr-errorfree {
        margin-top: 0.6vw;

        p {
            margin: 0;
            line-height: 1.25;
        }

        .big, .small {
            letter-spacing: 0.03vw;
        }

        .big {
            font-weight: 800;
            font-size: 2.2vw;
            margin-right: 0.75vw;
        }

        .small {
            font-weight: 700;
            color: $gray-lighter;
            font-size: 0.92vw;
        }
    }
</style>

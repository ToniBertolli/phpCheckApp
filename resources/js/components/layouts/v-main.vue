<template>
    <div class="row row-vw">
        <div class="col-4">
            <div class="widget">
                <h3>LAST DEPLOYMENTS</h3>
                <v-deployment></v-deployment>
            </div>
        </div>
        <div class="col-8">
            <div class="widget">
                <h3>DURATION OF FULL CHECK (IN SECONDS)</h3>
                <v-chart :series="durations"></v-chart>
            </div>
        </div>
        <div class="col-4">
            <div class="widget">
                <h3>SERVERS</h3>
                <v-servers :servers="servers"></v-servers>
            </div>
        </div>
        <div class="col-4">
            <div class="widget">
                <h3>ONLINE</h3>
                <v-percentage-circle :total="total"></v-percentage-circle>
            </div>
        </div>
        <div class="col-4">
            <a href="/latest-errors">
                <div class="widget">
                    <h3>LATEST ERROR</h3>
                    <v-error-free :error="lastKnownError"></v-error-free>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-main",
        props: {
            total: {
                type: Number,
                default: 0,
            },
            durations: {
                type: Array,
                max: 10,
            },
            lastKnownError: {
                type: Object,
            },
            servers: {
                type: Array
            }
        }
    }
</script>

<style lang="scss" scoped>
    a {
        color: #fff;

        &:hover, &:focus {
            color: #fff;
            text-decoration: none;

            h3 {
                text-decoration: underline;
            }
        }
    }

    .widget {
        padding: 2.1vw 2.1vw;
        height: 31vh;
        background: $gray-light;
        box-shadow: 4px 4px 50px 0 rgba(0, 0, 0, 0.55);
    }
</style>

<template>
    <div id="wpr-loadingbar" :class="status">
        <div id="cnr-loadingbar">
            <div class="column">
                <v-spinner :status="status"></v-spinner>
            </div>
            <div class="column">
                <span id="statusText">{{text}}</span>
            </div>
            <div v-if="status==='error'" class="column flex-grow-1">
                <v-errors :errors="errors"></v-errors>
            </div>
            <div v-if="status==='loading'" class="column flex-grow-1">
                <v-bar :status="status" :total="total"></v-bar>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-loadingbar",
        props: {
            status: {
                type: String,
                default: 'done'
            },
            total: {
                type: Number,
                default: 0
            },
            errors: {
                type: Array,
                default: []
            }
        },
        computed: {
            text() {
                switch (this.status) {
                    case 'done':
                        return 'done checking, no errors';
                    case 'loading':
                        return 'checking all endpoints';
                    case 'error':
                        return 'ERRORS ' + '(' + this.errors.length + ')';
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    #wpr-loadingbar {
        width: 100%;
        height: 6vw;
        padding: 2vw 2.8vw;
        background: $gray-dark;
        margin-bottom: 1.5vw;
        @include animate();

        #cnr-loadingbar {
            margin-left: -0.8vw;
            margin-right: -0.8vw;
            display: flex;

            .column {
                margin: 0 0.8vw;
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
            }
        }

        #statusText {
            font-size: 1.1vw;
            font-style: italic;
        }

        &.error {
            background: $red;

            #statusText {
                font-weight: 800;
                font-style: normal;
                font-size: 1.3vw;
            }
        }
    }
</style>

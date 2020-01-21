<template>
    <div id="wpr-all">
        <v-header :instances="instances" title="Latest errors"></v-header>

        <div id="wpr-main">
<!--            <div class="wpr-endpoint"-->
<!--                 v-for="log in logs">-->
<!--                <p>{{log.code}}</p>-->
<!--            </div>-->

            <div class="wpr-endpoint"
                 :class="defineStatus(log.status)"
                 v-for="log in logs">
                <v-endpoint-error-detail :log="log" :status="defineStatus(log.status)"></v-endpoint-error-detail>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-endpoint-errors",
        props: {
            instance: {
                type: Object
            },
            logs: {
                type: Array
            }
        },
        data() {
            return {
                instances: []
            }
        },
        mounted() {
            this.getInstances();
        },
        methods: {
            getInstances() {
                axios
                    .get('/api/instances')
                    .then(response => {
                        this.instances = response.data;
                    });
            },
            defineStatus(data) {
                return data ? 'done' : 'error';
            },
        },
    }
</script>

<style lang="scss" scoped>
    #wpr-all {
        position: relative;
        overflow: hidden;
        min-height: 100vh;
    }

    #wpr-main {
        margin: 5vh 5vw 4vh;
    }

    main {
        width: 80%;
    }

    aside {
        width: 20%;
        display: flex;
    }

    .wpr-endpoint {
        background: $gray-dark;
        margin-bottom: 1.5vw;
        border: 0.08vw solid $gray-light;
        @include animate();

        &.error {
            //border-color: $red;
        }

        &:hover {
            border-color: $gray-lighter;
        }
    }
</style>

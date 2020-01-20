<template>
    <div id="wpr-all" v-if="instance">
        <v-header :instances="instances" :title="instance.name"></v-header>

        <div id="wpr-main">
            <div class="wpr-endpoint"
                 :class="defineStatus(endpoint.procedures[0].status)"
                 v-for="endpoint in instance.endpoints">
                <v-endpoint-detail :endpoint="endpoint" :status="defineStatus(endpoint.procedures[0].status)"></v-endpoint-detail>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-endpoints",
        props: {
            instance: {
                type: Object
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
        border: 0.08vw solid $green;
        @include animate();

        &.error {
            border-color: $red;
        }

        &:hover {
            background: lighten($gray-dark, 2%);
        }
    }
</style>

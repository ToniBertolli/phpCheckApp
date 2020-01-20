<template>
    <div>
        <v-alerts></v-alerts>
        <h1>Instance detail</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/instances">Instances</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{newInstance.name}} Endpoints</li>
            </ol>
        </nav>

        <v-card-collapse class="mb-3" id="editform" :title="'Edit '+newInstance.name" color="secondary">
            <v-instance-edit :user="user" :instance="newInstance" @refresh="updateArray"></v-instance-edit>
        </v-card-collapse>

        <v-card-collapse class="mb-5" id="createform" title="Create new endpoint" show="show">
            <v-endpoint-edit :instance="newInstance" @refresh="updateArray"></v-endpoint-edit>
        </v-card-collapse>

        <div v-if="endpoints" class="list-group mb-3">
            <a v-for="endpoint in endpoints" :href="'/admin/endpoints/'+endpoint.id" class="list-group-item list-group-item-action">
                {{endpoint.name}} <br/>
                {{endpoint.url}}
            </a>
        </div>
    </div>
</template>

<script>
    import VEndpointEdit from "./layouts/v-endpoint-edit";
    export default {
        name: "v-main-instance",
        props: {
            instance: Object,
            user: Object
        },
        data() {
            return {
                endpoints: {},
                newInstance: this.instance
            }
        },
        mounted() {
            this.getEndpoints();
        },
        methods: {
            getEndpoints() {
                axios
                    .get('/api/endpoints', {
                        params: {
                            instance_id: this.newInstance.id
                        }
                    })
                    .then(response => {
                        this.endpoints = response.data;
                    });
            },
            updateArray(data) {
                this.endpoints.push(data);
            },
            updateObject(data) {
                this.newInstance = data;
            }
        }
    }
</script>

<style scoped>

</style>

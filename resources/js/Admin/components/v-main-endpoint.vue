<template>
    <div>
        <v-alerts></v-alerts>
        <h1>Endpoint detail</h1>

        <nav v-if="instance" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/instances">Instances</a></li>
                <li class="breadcrumb-item"><a :href="'/admin/instances/'+instance.id">{{instance.name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{newEndpoint.name}}</li>
            </ol>
        </nav>

        <v-card-collapse class="mb-3" id="editform" :title="'Edit '+newEndpoint.name" color="secondary">
            <v-endpoint-edit :instance="instance" :endpoint="newEndpoint" @refresh="updateArray"></v-endpoint-edit>
        </v-card-collapse>

        <v-card-collapse v-if="procedure" class="mb-3" id="createoreditform" :title="'Alter procedure'" color="secondary" show="show">
            <v-procedure-edit :endpoint="newEndpoint" :procedure="procedure" @refresh="updateArray"></v-procedure-edit>
            <v-fields :procedure="procedure"></v-fields>
        </v-card-collapse>
    </div>
</template>

<script>
    export default {
        name: "v-main-endpoint",
        props: {
            endpoint: Object,
        },
        data () {
            return {
                procedure: null,
                instance: null,
                newEndpoint: this.endpoint
            }
        },
        mounted() {
            this.getProcedures();
            this.getInstanceById(this.newEndpoint.instance_id);
        },
        methods: {
            getProcedures() {
                axios
                    .get('/api/procedures', {
                        params: {
                            endpoint_id: this.newEndpoint.id
                        }
                    })
                    .then(response => {
                        this.procedure = response.data[0];
                    });
            },
            getInstanceById(id) {
                axios
                    .get('/api/instances/'+id)
                    .then(response => {
                        this.instance = response.data;
                    });
            },
            updateArray(data) {
                this.newEndpoint = data;
            }
        }
    }
</script>

<style scoped>

</style>

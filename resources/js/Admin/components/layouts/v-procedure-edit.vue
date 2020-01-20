<template>
    <div>
        <form class="mb-4" v-if="procedure" @submit="setProcedure" enctype="multipart/form-data">
            <div class="form-group">
                <label for="procedureInterval">Interval in minutes</label>
                <select @change="setProcedure" class="form-control" id="procedureInterval" v-model="procedure.interval" aria-describedby="intervalHelp">
                    <option value="5">5 min</option>
                    <option value="15">15 min</option>
                    <option value="30">30 min</option>
                    <option value="60">1 hour</option>
                    <option value="180">3 hour</option>
                    <option value="360">6 hour</option>
                    <option value="480">8 hour</option>
                    <option value="720">12 hour</option>
                    <option value="1440">1 day</option>
                    <option value="10080">7 days</option>
                </select>
                <small id="intervalHelp" class="form-text text-muted">Choose the right procedure for this endpoint.</small>
            </div>

            <div class="form-group">
                <label for="procedureType">Example select</label>
                <select @change="setProcedure" class="form-control" id="procedureType" v-model="procedure.type" aria-describedby="procedureTypeHelp">
                    <option v-if="types" v-for="type in types">{{type.key}}</option>
                </select>
                <small id="procedureTypeHelp" class="form-text text-muted">Choose the right procedure for this endpoint.</small>
            </div>
        </form>
    </div>
</template>

<script>
    import EventBus from '../../../event-bus.js';
    export default {
        name: "v-procedure-edit",
        props: {
            endpoint: Object,
            procedure: Object,
        },
        data() {
            return {
                types: []
            }
        },
        mounted() {
            this.getProcedureTypes();
        },
        methods: {
            getProcedureTypes() {
                let that = this;
                axios.get('/api/proceduretypes')
                    .then(function (response) {
                        that.types = response.data;
                    })
                    .catch(function (error) {
                        EventBus.$emit('alert', {
                            type: 'warning',
                            message: error
                        });
                    });
            },
            setProcedure(e) {
                e.preventDefault();
                let that = this;
                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                };
                let formData = new FormData();
                formData.append('type', that.procedure.type);
                formData.append('interval', that.procedure.interval);
                formData.append('endpoint_id', that.endpoint.id);
                formData.append('_method', 'PUT');

                axios.post('/api/procedures/' + that.procedure.id, formData, config)
                    .then(function (response) {
                        EventBus.$emit('alert', {
                            type: 'success',
                            message: 'Procedure has been updated!'
                        });
                        that.$emit('refresh', response.data);
                    })
                    .catch(function (error) {
                        EventBus.$emit('alert', {
                            type: 'warning',
                            message: error
                        });
                    });
            },
        }
    }
</script>

<style scoped>

</style>

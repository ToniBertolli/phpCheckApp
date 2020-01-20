<template>
    <div>
        <form @submit="setEndpoint" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" v-model="name" aria-describedby="nameHelp"
                       placeholder="Name">
                <small id="nameHelp" class="form-text text-muted">This is the name of your endpoint.</small>
            </div>

            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" class="form-control" id="url" v-model="url" aria-describedby="urlHelp"
                       placeholder="http://example.com">
                <small id="urlHelp" class="form-text text-muted">This is the url of your endpoint.</small>
            </div>

            <button type="submit" class="btn btn-primary">{{ submitText }}</button>
        </form>
        <button v-if="endpoint" @click="doDelete" class="btn btn-secondary">Delete</button>
    </div>
</template>

<script>
    import EventBus from '../../../event-bus.js';

    export default {

        name: "v-endpoint-edit",
        props: {
            instance: Object,
            endpoint: Object,
        },
        data() {
            return {
                name: '',
                id: null,
                url: '',
            }
        },
        computed: {
            submitText() {
                return this.endpoint ? 'Edit' : 'Create';
            }
        },
        mounted() {
            if (this.endpoint) {
                this.url = this.endpoint.url;
                this.name = this.endpoint.name;
                this.id = this.endpoint.id;
            }
        },
        methods: {
            setEndpoint(e) {
                e.preventDefault();
                let that = this;
                let endpoint = '/api/endpoints';
                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                };

                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('url', this.url);
                formData.append('instance_id', this.instance.id);
                if (this.id) {
                    formData.append('_method', 'PUT');
                    endpoint += '/' + this.id;
                }

                axios.post(endpoint, formData, config)
                    .then(function (response) {
                        EventBus.$emit('alert', {
                            key: 'endpoint-edit',
                            type: 'success',
                            message: 'Endpoint has been updated!'
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

            doDelete() {
                let that = this;
                let formData = new FormData();
                formData.append('_method', 'DELETE');
                axios.post('/api/endpoints/' + that.id, formData)
                    .then(function (response) {
                        EventBus.$emit('alert', {
                            type: 'success',
                            message: 'Endpoint has been deleted!'
                        });
                        window.location.href = '/admin/instances/' + that.instance.id;
                    })
                    .catch(function (error) {
                        EventBus.$emit('alert', {
                            type: 'warning',
                            message: error
                        });
                    });
            }
        }
    }
</script>

<style scoped>

</style>

<template>
    <form class="row" @submit="setField" enctype="multipart/form-data">
        <div class="d-flex align-items-end">
            <div v-if="procedure.type != 'BODY'" class="form-group col-3">
                <label :for="'handle'+id">Handle</label>
                <input type="text" class="form-control" :id="'handle'+id" v-model="handle" placeholder="handle">
            </div>
            <div class="form-group col-6">
                <label :for="'value'+id">value</label>
                <input type="text" class="form-control" :id="'value'+id" v-model="value" placeholder="value">
            </div>
            <div class="form-group col">
                <label></label>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary">{{ submitText }}</button>
                    <div v-if="field && procedure.type != 'BODY'" @click="doDelete" class="btn btn-secondary">Delete</div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import EventBus from '../../../event-bus.js';

    export default {
        name: "v-field-create",
        props: {
            procedure: Object,
            field: Object,
            index: Number
        },
        data() {
            return {
                handle: 'body',
                value: '',
                id: '',
                types: [],
            }
        },
        computed: {
            submitText() {
                return this.field ? 'Edit' : 'Create';
            }
        },
        mounted() {
            this.getProcedureTypes();
            if(this.field) {
                this.id = this.field.id;
                this.handle = this.field.handle;
                this.value = this.field.value;
            }
        },
        methods: {
            getProcedureTypes() {
                let that = this;
                axios.get('/api/fieldtypes')
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
            setField(e) {
                e.preventDefault();
                let that = this;
                let endpoint = '/api/fields';
                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                };
                let formData = new FormData();

                formData.append('handle', that.handle);
                formData.append('value', that.value);
                formData.append('procedure_id', that.procedure.id);
                if(this.id) {
                    formData.append('_method', 'PUT');
                    endpoint += '/' + this.id;
                }

                axios.post(endpoint, formData, config)
                    .then(function (response) {
                        EventBus.$emit('alert', {
                            type: 'success',
                            message: 'Field has been updated!'
                        });

                            if(!that.id) {
                                that.$emit('refresh', response.data);
                            }
                            // that.id ? that.$emit('refresh', response.data) : that.emptyInput();

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
                axios.post('/api/fields/' + that.id, formData)
                    .then(function (response) {
                        EventBus.$emit('alert', {
                            type: 'success',
                            message: 'Field has been deleted!'
                        });
                        that.$emit('remove', that.index);
                    })
                    .catch(function (error) {
                        EventBus.$emit('alert', {
                            type: 'warning',
                            message: error
                        });
                    });
            },
            emptyInput() {
                this.id = '';
                this.handle = '';
                this.value = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
    .d-flex {
        width: 100%;
    }
</style>

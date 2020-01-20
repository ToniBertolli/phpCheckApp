<template>
    <div>
        <form @submit="setInstance" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" v-model="name" aria-describedby="nameHelp"
                       placeholder="Name">
                <small id="nameHelp" class="form-text text-muted">This is the name of your instance.</small>
            </div>
            <button type="submit" class="btn btn-primary">{{ submitText }}</button>
        </form>
        <button v-if="instance" @click="doDelete" class="btn btn-secondary">Delete</button>
    </div>
</template>

<script>
    import EventBus from '../../../event-bus.js';
    export default {
        name: "v-instance-edit",
        props: {
            user: Object,
            instance: Object,
        },
        data() {
            return {
                name: '',
                id: null
            }
        },
        computed: {
            submitText() {
                return this.instance ? 'Edit' : 'Create';
            }
        },
        mounted() {
          if(this.instance) {
              this.name = this.instance.name;
              this.id = this.instance.id;
          }
        },
        methods: {
            setInstance(e) {
                e.preventDefault();
                let that = this;
                let endpoint = '/api/instances';

                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                };

                let formData = new FormData();
                formData.append('name', that.name);
                formData.append('logo', 'logo.png');
                formData.append('user_id', that.user.id);
                if(this.id){
                    formData.append('_method', 'PUT');
                    endpoint += '/' + this.id;
                }

                axios.post(endpoint, formData, config)
                    .then(function (response) {
                        EventBus.$emit('alert', {
                            type: 'success',
                            message: 'Instance has been updated!'
                        });
                        if(!that.id) {
                            that.$emit('refresh', response.data);
                        }
                    })
                    .catch(function (error) {
                        EventBus.$emit('alert', {
                            type: 'warning',
                            message: error
                        });
                    });
            },

            doDelete() {
                // this.deletedEntry('/api/instance/' + that.instance.id);
                let that = this;
                let formData = new FormData();
                formData.append('_method', 'DELETE');
                axios.post('/api/instances/' + that.instance.id, formData)
                    .then(function (response) {
                        EventBus.$emit('alert', {
                            type: 'success',
                            message: 'Instance has been deleted!'
                        });
                        window.location.href = '/admin/instances';
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

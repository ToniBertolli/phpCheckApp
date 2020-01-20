<template>
    <div>
        <v-alerts></v-alerts>
        <h1>Instance overview</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="instances">Instances</li>
            </ol>
        </nav>

        <v-card-collapse class="mb-5" id="createform" title="Create new instance" show="show">
            <v-instance-edit :user="user" @refresh="updateArray"></v-instance-edit>
        </v-card-collapse>

        <div v-if="instances" class="list-group">
            <a v-for="instance in instances" :href="'/admin/instances/'+instance.id" class="list-group-item list-group-item-action">
                #{{instance.id}}: {{instance.name}}
            </a>
        </div>

    </div>
</template>

<script>
    export default {
        name: "v-main-instances",
        props: {
            user: Object
        },
        data () {
            return {
                instances: {},
            }
        },
        mounted() {
            this.getInstances()
        },
        methods: {
            getInstances() {
                axios
                    .get('/api/instances', {
                        params: {
                            user_id: this.user.id
                        }
                    })
                    .then(response => {
                        this.instances = response.data;
                    });
            },
            updateArray(dash) {
                this.instances.push(dash);
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>

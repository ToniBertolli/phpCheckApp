<template>
    <div class="" v-if="!isTypeRequest">
        <div v-if="" v-for="(field, index) in fields">
            <v-field-create :key="field.id" :index="index"  @remove="remove" :field="field" :procedure="procedure"
                            @refresh="updateArray"></v-field-create>
        </div>
        <div v-if="showCreate">
            <v-field-create :procedure="procedure" @refresh="updateArray"></v-field-create>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-fields",
        props: {
            procedure: Object
        },
        data() {
            return {
                handle: '',
                value: '',
                types: [],
                fields: []
            }
        },
        computed: {
            isTypeRequest() {
                return this.procedure.type === 'REQUEST';
            },
            showCreate () {
                if (this.procedure.type === 'REQUEST') {
                    return false;
                }
                if (this.procedure.type === 'BODY' && this.fields.length >= 1) {
                    return false;
                }
                else {
                    return true;
                }
            }
        },
        mounted() {
            this.getFields();
        },
        methods: {
            getFields() {
                axios
                    .get('/api/fields', {
                        params: {
                            procedure_id: this.procedure.id
                        }
                    })
                    .then(response => {
                        this.fields = response.data;
                    });
            },
            updateArray(data) {
                this.fields.push(data);
            },
            remove(index) {
                this.fields.splice(index, 1);
            }
        }
    }
</script>

<style scoped>

</style>

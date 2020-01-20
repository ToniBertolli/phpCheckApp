<template>
    <div class="cnr-alert">
        <div v-if="message" class="alert alert-dismissible" :class="'alert-'+type" role="alert">
            {{message}}
            <button @click="dismiss" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-alert",
        props: {
            message: String,
            type: String
        },
        methods: {
            dismiss() {
                this.$emit('dismiss', this);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .cnr-alert {
        width: 100%;
        display: inline-block;
        text-align: center;

        .alert {
            display: inline-block;
            padding-bottom: 10px;
        }
    }
</style>

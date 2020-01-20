<template>
    <div class="card">
        <div :class="'card-header bg-'+color+' text-white font-weight-bold'" data-toggle="collapse" :data-target="'#'+id">
            {{title}}
        </div>
        <div :id="id" :class="'card-body collapse ' + show">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-card-collapse",
        props: {
            id: String,
            title: String,
            color: {
                type: String,
                default: 'primary'
            },
            show: {
                type: String,
                default: ''
            }
        }
    }
</script>

<style scoped>
    .card-header {
        cursor: pointer;
    }
</style>

<template>
    <div data-toggle="collapse" :data-target="'#collapseitem'+data.id" class="list-group-item">
        <slot></slot>

        <div :id="'collapseitem'+data.id" class="collapse">
            <ul>
                <li v-for="(value, propertyName) in data">
                    {{ propertyName }}: {{value}}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-list-group-item",
        props: {
            data: Object
        },
        data() {
            return {
                showSection: false
            }
        },
    }
</script>

<style scoped>

</style>

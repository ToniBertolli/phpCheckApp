<template>
    <div id="wpr-alerts">
        <div id="alerts" v-if="alerts">
            <v-alert @dismiss="doDismiss" v-for="alert in alerts" :type="alert.type" :message="alert.message" :key="Math.round(Math.random() * 10)"></v-alert>
        </div>
    </div>

</template>

<script>
    // Import the EventBus.
    import EventBus from '../../event-bus.js';
    export default {
        name: "v-alerts",
        data() {
            return {
                alerts: []
            }
        },
        mounted() {
            let that = this;
            EventBus.$on('alert', function(payload) {
                console.log(payload);
                that.alerts.push(payload);
            });
        },
        methods: {
            doDismiss(obj) {
                this.alerts.splice(obj, 1);
            }
        }
    }
</script>

<style lang="scss">
    #wpr-alerts {
        position: relative;
        z-index: 9;
    }

    #alerts {
        position: fixed;
        top: 20px;
        left: 0;
        right: 0;
    }
</style>

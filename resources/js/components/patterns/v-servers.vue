<template>
    <div id="wpr-servers">
        <div v-for="(percentage, label) in servers" class="cnr-server">
            <h2>{{ label }}</h2>
            <v-server-bar :percent="percentage" class="flex-grow-1"></v-server-bar>
            <div class="percentage">
                <span>{{ percentage }} %</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-servers",
        data () {
            return {
                servers: [],
                loading: false
            }
        },
        mounted() {
            this.fetch();

            setInterval(this.fetch, 3000); // Refetch every 3 seconds
        },
        methods: {
            async fetch() {
                // Skip fetch is already loading
                if (this.loading) {
                    return;
                }

                this.loading = true;
                try {
                    const {data} = await axios.get('/api/serverLoad');
                    this.servers = data;
                } catch (e) {
                    console.error(e);
                }
                this.loading = false;
            }
        }
    }
</script>

<style lang="scss" scoped>
    #wpr-servers {
        margin-top: 0.6vw;

        .cnr-server {
            display: flex;
            justify-content: space-between;
            align-items: baseline;

            h2 {
                width: 3.8vw;
                font-weight: 800;
                font-size: 2.2vw;
                line-height: 1.25;
                letter-spacing: 0.03vw;
                margin-right: 0.75vw;
            }

            .percentage {
                font-weight: 700;
                font-size: 0.92vw;
                color: $gray-lighter;
                margin-left: 0.75vw;
            }
        }
    }
</style>

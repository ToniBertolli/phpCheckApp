<template>
    <div id="wpr-all">
        <v-header :instances="instances" title="dashboard"></v-header>

        <div id="wpr-main">
            <v-loadingbar :status="status" :errors="errors" :total="totalLoading"></v-loadingbar>

            <div class="row flex-wrap">
                <main>
                    <v-main :durations="durations" :total="totalOnline" :lastKnownError="lastKnownError" :servers="servers"></v-main>
                </main>
                <aside>
                    <v-aside :endpoints="endpoints.length" :instances="instances.length" :checksToday="checksToday.length" :errorsThisWeek="errorsThisWeek.length"></v-aside>
                </aside>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-dashboard",
        data () {
            return {
                instances: [],
                endpoints: [],
                logs: [],

                durations: [],
                checksToday: [],
                errorsThisWeek: [],
                lastKnownError: {},

                errors: [],
                status: 'done',
                totalChecked: 0,

                servers: []
            }
        },
        beforeMount() {
            this.initPusher();
            this.bindConnections();
        },
        computed: {
            totalOnline() {
                let total = this.endpoints.length;
                let offline = 0;
                for( let i = 0; i < this.endpoints.length; i++){
                    if ( this.endpoints[i].procedures[0].status === 0) {
                        offline ++;
                    }
                }
                return Math.round(100 - (offline / (total/100)));
            },
            totalLoading() {
                 return Math.round((this.totalChecked * 100) / this.endpoints.length);
            },

        },
        mounted() {
            this.doRequests();
            setInterval(function () {
                window.location.reload();
            }, 8*60*60000)
        },
        methods: {
            /** Init Pusher **/
            initPusher() {
                this.client = new Pusher('e380dd57bab766f494fd', {
                    cluster: 'eu',
                    forceTLS: true
                });
            },
            /** Bind Connections **/
            bindConnections() {
                const that = this;
                const channel = this.client.subscribe('dashboard');
                channel.bind('CheckedProcedure', function(data) {
                    if(that.totalChecked >= 0 && that.totalChecked < that.endpoints.length) {
                        that.totalChecked++;
                    }
                });
                channel.bind('SyncChanged', function (data) {
                    that.runChecks(data);
                });
            },
            runChecks(data) {
                if(data.isSyncing) {
                    this.totalChecked = 0;
                    this.status = 'loading';
                    this.errors = [];
                }

                if(!data.isSyncing) {
                    this.doRequests();
                }
            },
            doRequests() {
                this.getInstances();
                this.getEndpoints();
                this.getLogs();
                this.getTotalResponseTime();
                this.getChecksToday();
                this.getErrorsThisWeek();
                this.getLastKnownError();
                this.getCurrentErrors();
            },
            getInstances() {
                axios
                    .get('/api/instances')
                    .then(response => {
                        this.instances = response.data;
                    });
            },
            getEndpoints() {
                axios
                    .get('/api/endpoints')
                    .then(response => {
                        this.endpoints = response.data;
                    });
            },
            getLogs() {
                axios
                    .get('/api/logs')
                    .then(response => {
                        this.logs = response.data;
                    });
            },
            getTotalResponseTime() {
                axios
                    .get('api/totalResponseTime')
                    .then(response => {
                        this.durations = response.data;
                    })
            },
            getChecksToday() {
                axios
                    .get('/api/checksToday')
                    .then(response => {
                        this.checksToday = response.data;
                    });
            },
            getErrorsThisWeek() {
                axios
                    .get('/api/errorsWeek')
                    .then(response => {
                        this.errorsThisWeek = response.data;
                    });
            },
            getCurrentErrors() {
                axios
                    .get('api/totalErrors')
                    .then(response => {
                        this.errors = response.data;
                        this.totalChecked = 0;
                        if(response.data.length > 0) {
                            this.status = 'error';
                        }
                        else {
                            this.status = 'done';
                        }
                    });
            },
            getLastKnownError() {
                axios
                    .get('/api/lastKnownError')
                    .then(response => {
                        if(response.data) {
                            this.lastKnownError = response.data;
                        }
                    });
            },
        }
    }
</script>

<style lang="scss" scoped>
    #wpr-all {
        position: relative;
        overflow: hidden;
        min-height: 100vh;
    }

    #wpr-main {
        margin: 5vh 5vw 4vh;
    }

    main {
        width: 80%;
    }

    aside {
        width: 20%;
        display: flex;

    }
</style>

<template>
    <div class="wrapper">
        <div v-for="deployment in deployments" class="entry">
            <div class="avatar">
                <div class="avatar-image">
                    <img :src="deployment.invoker_image" :alt="deployment.invoker" :title="deployment.invoker">
                </div>
                <div v-if="deployment.invoker_image !== deployment.committer_image" class="avatar-image avatar-small">
                    <img :src="deployment.committer_image" :alt="deployment.committer" :title="deployment.committer">
                </div>
            </div>

            <div class="description">
                <a :href="deployment.link" target="_blank">
                    <strong>{{ deployment.project }}</strong><br/>
                    {{ deployment.pipeline }}<br/>
                    {{ formatDate(deployment.created_at) }}
                </a>
            </div>

            <div class="status">
                <img v-if="deployment.status === 'SUCCESSFUL'" src="/images/Done.svg" alt="SUCCESSFUL">
                <img v-if="deployment.status === 'FAILED'" src="/images/ErrorRed.svg" alt="FAILED">
            </div>

        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    // import 'moment/locale/nl.js';

    export default {
        data() {
            return {
                loading: false,
                deployments: [],
            }
        },

        async mounted() {
            this.fetch();

            setInterval(this.fetch, 10000); // Refetch every 10 seconds
        },

        methods: {
            /**
             * Format date to from now date in Dutch
             * @param subject
             * @returns {string}
             */
            formatDate(subject) {
                return moment(subject).fromNow();
            },

            async fetch() {
                this.loading = true;
                try {
                    const {data} = await axios.get('/api/deployments/recent');
                    this.deployments = data;
                } catch (e) {
                    console.error(e);
                }
                this.loading = false;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wrapper {
        margin-top: 5px;
        overflow: auto;
        height: 100%;
    }

    .entry {
        display: flex;
        align-items: center;
        padding: 0.35vw 0;
        flex: 1;
    }

    .avatar {
        position: relative;
        display: inline-block;
        margin-right: 0.75rem;

        img {
            display: block;
            width: 100%;
            height: 100%;
        }

        &-image {
            border-radius: 100%;
            overflow: hidden;
            width: 3vw;
        }

        &-small {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 40%;
            height: 40%;
        }
    }

    .description {
        font-size: 0.76vw;
        flex: 1;

        strong {
            text-transform: uppercase;
        }

        > a {
            color: inherit;
        }

        > a:hover {
            text-decoration: none;
        }
    }

    .status {
        margin-left: 1rem;

        > img {
            width: 1.8vw;
        }
    }
</style>

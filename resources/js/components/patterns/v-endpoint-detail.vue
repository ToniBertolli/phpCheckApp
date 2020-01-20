<template>
    <div :class="status">
        <div class="cnr-endpoint" data-toggle="collapse" :data-target="'#id'+ endpoint.id">
            <div class="column">
                <v-spinner :isRed="true" :status="status"></v-spinner>
            </div>
            <div class="column">
                <span class="text">{{endpoint.procedures[0].code}}</span>
            </div>
            <div class="column">
                <span class="text">{{endpoint.name}}</span>
            </div>
            <div class="column">
                <span class="text statusText">{{endpoint.url}}</span>
            </div>
            <div class="column">
                <span class="text statusText">{{ endpoint.procedures[0].logs[endpoint.procedures[0].logs.length - 1].reason}}</span>
            </div>
            <div class="column">
                <span class="text statusText">{{ getTimeBetween(endpoint.procedures[0].logs[endpoint.procedures[0].logs.length - 1].created_at)}}</span>
            </div>
        </div>
        <div :id="'id'+endpoint.id"  :class="'logs collapse'">
            <div class="cnr-endpoint" v-for="(log, index) in reverse(endpoint.procedures[0].logs)">
                <div class="column">
                    <v-spinner :isRed="true" :status="defineStatus(log.status)"></v-spinner>
                </div>
                <div class="column">
                    <span class="text">{{log.code}}</span>
                </div>
                <div class="column">
                    <span class="text">{{endpoint.name}}</span>
                </div>
                <div class="column">
                    <span class="text statusText">{{endpoint.url}}</span>
                </div>
                <div class="column">
                    <span class="text statusText">{{log.reason}}</span>
                </div>
                <div class="column">
                    <span class="text statusText">{{ getTimeBetween(log.created_at)}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-endpoint-detail",
        props: {
            endpoint: {
                type: Object
            },
            status: {
                type: String,
                default: 'done'
            }
        },
        methods: {
            getTimeBetween(time) {
                console.log(time);
                let now = Date.now();
                let errorDate = new Date(time);
                let diff = Math.abs(now - errorDate) / 1000;

                // calculate (and subtract) whole days
                let days = Math.floor(diff / 86400);
                if (days > 0) {
                    return days + ' days ago';
                }
                diff -= days * 86400;

                // calculate (and subtract) whole hours
                let hours = Math.floor(diff / 3600) % 24;
                if (hours > 0) {
                    return hours + ' hours ago';
                }
                diff -= hours * 3600;

                // calculate (and subtract) whole minutes
                let minutes = Math.floor(diff / 60) % 60;
                if (minutes > 0) {
                    return minutes + ' minutes ago';
                }
                diff -= minutes * 60;

                // what's left is seconds
                let temp = diff % 60;
                let seconds = Math.floor(temp);  // in theory the modulus is not required
                return seconds + ' seconds ago';
            },
            defineStatus(data) {
                return data ? 'done' : 'error';
            },
            reverse(items) {
                let temp = items.slice().reverse();
                return temp.slice(0, 10)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .cnr-endpoint {
        cursor: pointer;
        display: flex;
        padding: 2vw 2.8vw;
        margin-left: -0.8vw;
        margin-right: -0.8vw;
    }

    .logs {
        .cnr-endpoint {
            cursor: unset;
            margin: 0;
            padding: 2vw;
            border-top: 0.08vw solid darken($green, 30%);
        }
    }

    .column {
        margin: 0 0.8vw;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;

        &:nth-child(3n) {
            width: 13%;
        }

        &:nth-child(4n) {
            width: 13%;
        }

        &:nth-child(5n) {
            width: 40%;
        }

        &:last-child {
            flex-grow: 1;
            justify-content: flex-end;
        }
    }

    .text {
        margin-top: 2px;
        font-size: 1vw;
    }

    .error {
        .logs {
            .cnr-endpoint {
                border-top: 0.08vw solid darken($red, 30%);
            }
        }

        .text {
            font-style: normal;
        }
    }
</style>

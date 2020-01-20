<template>
    <div :class="'wpr-nav toggled-' + toggled">
        <div class="cnr-nav">
            <nav>
                <h1 id="nav-title"><a href="/">Dashboard</a></h1>
                <ul class="p-0 mb-4">
                    <li v-for="instance in instances">
                        <a class="" :href="'/instances/' + instance.id"
                           :title="instance.name"><span>{{instance.name}}</span></a>
                    </li>
                </ul>
            </nav>
            <div class="wpr-settings">
                <div class="cnr-settings">
                    <a href="/admin/instances" title="Admin"><img src="/images/setting.svg" alt="settings"></a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "v-navigation",
        props: {
            instances: {
                type: Array
            },
            toggled: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wpr-nav {
        position: absolute;
        top: 0;
        bottom: 0;
        right: -40%;
        width: 40%;
        padding-top: 5vw;
        background: $gray-light;
        z-index: 2;
        box-shadow: 4px 4px 50px 0 rgba(0, 0, 0, 0.55);
        @include animate();

        &.toggled-true {
            right: 0%;
        }

        .cnr-nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-top: 5vw;
            padding-left: 10%;
        }

        a {
            color: #fff !important;
        }

        #nav-title {
            margin-bottom: 45px;
        }

        ul {
            list-style: none;
            margin: 0;

            li {
                font-size: 1.2vw;
                line-height: 1.25;
                font-weight: 700;
                text-transform: uppercase;
                margin: 20px 0;
                letter-spacing: 0.07vw;
                color: #fff;
            }
        }

        .wpr-settings {
            align-self: flex-end;

            .cnr-settings {
                img {
                    padding: 1vw;
                    width: 5vw;
                }
            }
        }

    }
</style>

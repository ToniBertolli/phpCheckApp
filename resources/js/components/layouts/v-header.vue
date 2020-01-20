<template>
    <div>
        <div id="header">
            <div class="cnr-logo">
                <a href="/" title="Dashboard"><img src="/images/logoW.jpg" alt="Logo Webtraders"/></a>
            </div>
            <div>
                <h1>{{title}}</h1>
            </div>
            <v-hamburger @click.native="toggle()"></v-hamburger>
        </div>
        <v-navigation :instances="instances" :toggled="toggled"></v-navigation>
    </div>
</template>

<script>
    export default {
        name: "v-header",
        props: {
            title: {
                type: String,
                default: 'DASHBOARD'
            },
            instances: {
                type: Array
            }
        },
        data() {
            return {
                toggled: false
            }
        },
        methods: {
            toggle() {
                this.toggled = !this.toggled;
            }
        }
    }
</script>


<style lang="scss" scoped>
    #header {
        position: relative;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
    }

    .cnr-logo {
        position: relative;
        z-index: 3;
        img {
            width: 5vw;
        }
    }
</style>

<template>
    <div>
        <img v-if="status === 'loading'" id="loading" src="/images/Loader.svg" alt="Loading icon">
        <img v-if="status === 'done'" id="done" src="/images/Done.svg" alt="Done icon">
        <img v-if="status === 'error' && isRed" id="error" src="/images/ErrorRed.svg" alt="Error icon">
        <img v-if="status === 'error' && !isRed" id="error" src="/images/Error.svg" alt="Error icon">
    </div>
</template>

<script>
    export default {
        name: "v-loadingbar",
        props: {
            status: {
                type: String,
                default: 'done'
            },
            isRed: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style lang="scss" scoped>
    img {
        width: 1.8vw;
    }

    #loading {
        -webkit-animation: load8 1.1s infinite linear;
        animation: load8 1.1s infinite linear;
    }
    @-webkit-keyframes load8 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes load8 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>

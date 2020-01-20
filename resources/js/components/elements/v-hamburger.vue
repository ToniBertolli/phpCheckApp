<template>
    <div class="hamburger">
        <div class="hamburger-box">
            <div class="hamburger-inner"></div>
        </div>

        <p class="title"></p>
    </div>
</template>

<script>
    export default {
        name: "v-hamburger"
    }
</script>

<style lang="scss" scoped>
    .hamburger {
        width: 5vw;
        height: 5vw;
        background-color: #fff;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding-bottom: 8px;
        z-index: 99999;
        pointer-events: auto;

        .hamburger-box {
            display: inline-block;
            position: relative;
            height: 28px;
            width: calc(.96154vw + 30.46154px);

            .hamburger-inner {
                display: block;
                position: absolute;
                width: 100%;
                background-color: #000;
                top: auto;
                bottom: 0;
                height: 4px;

                &::before {
                    position: absolute;
                    width: 100%;
                    transition-timing-function: ease;
                    transition-duration: .15s;
                    transition-property: transform;
                    background-color: #000;
                    display: block;
                    content: "";
                    height: 4px;
                    top: -12px;
                }

                &::after {
                    content: "";
                    position: absolute;
                    width: 100%;
                    transition-timing-function: ease;
                    transition-duration: .15s;
                    transition-property: transform;
                    background-color: #000;
                    display: block;
                    top: -24px;
                    height: 4px;
                }
            }
        }

        .title {
            color: $red;
            font-weight: 700;
            letter-spacing: .1rem;
            text-transform: uppercase;
            transition: content .25s ease;
            transition-delay: .3s;
            position: relative;
            width: 100%;
            text-align: center;
            margin: 4px 0 0 0px;

            &::before {
                content: "Menu";
                opacity: 1;
                transition: opacity .25s ease-out;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                margin: auto;
            }
        }
    }
</style>

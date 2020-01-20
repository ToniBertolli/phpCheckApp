<template>
    <apexchart v-if="newSeries" type="area" width="100%" height="100%" :options="chartOptions" :series="newSeries"/>
</template>

<script>
    export default {
        name: "v-chart",
        props: {
            series: {
                type: Array,
                max: 10,
            }
        },
        watch: {
            series() {
                this.newSeries = [{
                    data: this.series
                }];
            }
        },
        data() {
            return {
                newSeries: [{
                    data: []
                }],

                chartOptions: {
                    fill: {
                        colors: undefined,
                        opacity: 0.9,
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            type: "vertical",
                            shadeIntensity: 0.5,
                            gradientToColors: ['#2D2121'],
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100],
                            colorStops: []
                        },
                    },
                    theme: {
                        mode: 'dark',
                        monochrome: {
                            enabled: true,
                            color: '#6734C3',
                        },
                    },
                    chart: {
                        background: '#2D2121',
                        toolbar: {
                            show: false
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                    },
                    markers: {
                        size: 8,
                        color: '#6734C3',
                        strokeColors: '#6734C3',
                        discrete: [],
                        shape: "circle",
                    },
                    dataLabels: {
                        enabled: true,
                        textAnchor: 'middle',
                        offsetX: 0,
                        offsetY: -15,
                        style: {
                            fontSize: '0.85vw',
                            fontFamily: 'tt_norms_bold, Arial, sans-serif',
                            colors: ['#fff']
                        },
                    },
                    grid: {
                        borderColor: '#645C5C',
                        padding: {
                            top: 50,
                            right: 50,
                        },

                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                        yaxis: {
                            lines: {
                                show: false
                            }
                        }
                    },
                    xaxis: {
                        labels: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        }
                    },
                    yaxis: {
                        show: false,
                        showAlways: false,
                    },
                    legend: {
                        show: false
                    },
                }
            }
        }
    }
</script>

<style lang="scss">
    .apexcharts-datalabel {
        -webkit-font-smoothing: antialiased;
    }
</style>

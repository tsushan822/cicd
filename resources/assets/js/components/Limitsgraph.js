import Chart from 'chart.js';

export default {
    template: '<canvas position="relative" id="limitsgraph"></canvas>',

    props: {
        labels: {},
        unused: {},
        used: {},
        exceeded: {},
        baseccy: {},
        fill: {
//default: "rgba(0,220,220,0.2)"
        }
    },

    mounted() {
        var data = {
            labels: this.labels,

            datasets: [
                {
                    label: 'Used limit',
//     backgroundColor: "rgba(25,153,227,0.5)",
                    backgroundColor: "rgba(53,139,196,1)",
                    borderColor: "rgba(53,139,196,1)",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(53,139,196,0.6)",
                    hoverBorderColor: "rgba(53,139,196,1)",
                    data: this.used
                },
                {
                    label: 'Unused limit',
                    backgroundColor: "rgba(129,199,239,1)",
                    borderColor: "rgba(129,199,239,1)",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(129,199,239,0.6)",
                    hoverBorderColor: "rgba(129,199,239,1)",
                    data: this.unused
                }, {
                    label: 'Exceeded limit',
                    backgroundColor: "rgba(229, 62,54,1)",
                    borderColor: "rgba(229, 62,54,1)",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(229, 62,54,0.6)",
                    hoverBorderColor: "rgba(229, 62,54,1)",
                    data: this.exceeded
                }

            ]
        };
        var context = document.getElementById('limitsgraph').getContext('2d');
        const chart = new Chart(context,
            {

                type: 'horizontalBar',
                data: data,
                options: {
                    plugins: {
                        datalabels: {
                            display: false,
                        }
                    },
                    title: {

                        display: this.showtitle,
                        text: 'Limit usage per counterparty (' + this.baseccy + ')'
                    },

                    tooltips: {

                        borderColor: 'rgba(42,51,61,1)',
                        backgroundColor: 'rgba(255,255,255,0.8)',
                        bodyFontColor: 'rgba(42,51,61,1)',
                        titleFontColor: 'rgba(42,51,61,1)',
                        mode: 'label',


                        callbacks: {
                            label: function (tooltipItem, data) {
                                return Number(tooltipItem.xLabel).toFixed(0).replace(/./g, function (c, i, a) {
                                    return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                                });
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            stacked: true,
                            categoryPercentage: 1.0,
                            barPercentage: 1.0,
                            ticks: {
                                beginAtZero: true,
                                // stepSize: 100000,
                                // Return an empty string to draw the tick line but hide the tick label
                                // Return `null` or `undefined` to hide the tick line entirely
                                userCallback: function (value, index, values) {
                                    // Convert the number to a string and splite the string every 3 charaters from the end
                                    value = value.toString();
                                    value = value.split(/(?=(?:...)*$)/);

                                    // Convert the array to a string and format the output
                                    value = value.join(',');
                                    return value;
                                }
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            categoryPercentage: 1.0,
                            barPercentage: 0.8
                        }]
                    }
                }

            });
        console.log(chart.generateLegend());
    }
}
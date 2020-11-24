import Chart from 'chart.js';
import Annotation from 'chartjs-plugin-annotation';
import vueSlider from 'vue-slider-component/src/vue2-slider.vue';
export default {
    components: {vueSlider},
    props: {
        url: '', totallimit: '', showtitle: '', range: {}, rangemonths: {},
        bgStyle: {
            "backgroundColor": "#fff",
            "boxShadow": "inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)"
        },
        tooltipStyle: {
            "backgroundColor": "#666",
            "borderColor": "#666"
        },
        processStyle: {
            "backgroundColor": "#999"
        }
    },
    template: '<div><div id="wrapper" style="position: relative; height: 30vh"><canvas id="stackedlinegraphleases"></canvas></div><div><vue-slider v-bind="slider.default" v-model="internalrange" :min="20" :max="90" :step="4" :show="true" :data="rangemonths"  :lazy="true" :piecewise="true" :disabled="false" ></vue-slider></div></div>',
    data() {
        return {
            internalrange: this.range,
            slider: {
                //vue slider settings
                default: {
                    bgStyle: {
                        "backgroundColor": "#fff",
                        "boxShadow": "inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)"
                    },
                    tooltipStyle: {
                        "backgroundColor": "rgba(54,65,78,1)",
                        "borderColor": "rgba(54,65,78,1)"
                    },
                    processStyle: {
                        "backgroundColor": "rgba(54,65,78,0.5)"
                    },
                    tooltipDir: [
                        "bottom",
                        "bottom"
                    ]
                },
            }
        }
    }
    ,
    watch: {
        // whenever question changes, this function will run
        internalrange: _.debounce(function () {
            this.sliderChange();
        })
    },
    methods: {
        sliderChange:
            function () {
                //this.myChart.destroy();
                this.load();
                console.log(this.myChart);
            },
        load() {
            this.fetchData().then(response => {
                //console.log(response.data);
                //      console.log(response.data['labels'][0]); // Dumps object including
                const labels = response.data['labels'];
                const dataset = response.data['dataset'];
                const baseccy = response.data['baseccy'];
                const counterpartycount = response.data['counterpartyCount'];
                const dates = response.data['rangeHeader'];
                var datasetColor = [
                    "#4ABAEB",
                    "#4FC510",
                    "#4ABAEB",
                    "#9FDF7C"
                ];
                /*          var datasetColor = [
                              "25, 153, 227",
                              "54, 65, 78",
                              "231, 223, 232",
                              "79,197,16",
                              "255,191,0",
                              "239,62,54",
                              //Extra two color lighter
                              "30, 56, 136","71, 168, 189","248, 243, 43","141, 153, 174","132, 220, 198","10, 9, 12",
                              "66, 242, 247","70, 172, 194","108,190,237",
                              "127,134,142","246,243,246","143,218,102","255,202,46"
                              //https://coolors.co/36414e-1999e3-e7dfe8-f3b700-f6511d
          //"25, 153, 227",
          //"54, 65, 78",
          //
          //"79,178,134",
          //"245,203,92",
          //"234,99,140",
          //"100,97,160",
          //"219,50,77"
                              // http://paletton.com/palette.php?uid=73u2b0kuaRjilT%2BolS-LVPkMntE
          //                    "4, 96, 151", "108, 188, 235", "236, 130, 0", "255, 189, 109",
          //                    "0, 186, 12", "104, 243, 113", "236, 6, 0", "255, 113, 109"
                          ];*/
                var datasetValue = [];
                datasetValue[0] =
                    {
                        label: labels[0],
                        backgroundColor: datasetColor[0],
                        borderColor: datasetColor[0],
                        borderWidth: 4,
                        hoverBackgroundColor: datasetColor[0],
                        hoverBorderColor: datasetColor[0],
                        lineTension: 0,
                        fill: false, // explicitly fill the first dataset to the x axis
                        data: dataset[0]
                    }

                var data = {
                    labels: dates,
                    datasets: datasetValue
                };
                if (typeof this.myChart !== "undefined") {
                    this.myChart.data.labels = data.labels;
                    this.myChart.data.datasets = data.datasets;
                    this.myChart.update();
                } else {
                    document.getElementById("wrapper").style.height = '30vh';
                    var context = document.getElementById('stackedlinegraphleases').getContext('2d');
                    this.myChart = new Chart(context,
                        {
                            type: 'line',
                            data: data,
                            options: {
                                plugins: {
                                    datalabels: {
                                        display: false,
                                    }
                                },
                                responsive: true,
                                maintainAspectRatio: false,
                                title: {
                                    display: this.showtitle,
                                    text: 'Guarantee maturity in million ' + baseccy
                                },
                                elements: {
                                    line: {
                                        fill: '-1'
                                    }
                                },
                                tooltips: {
                                    mode: 'label',
                                    intersect: 'false',
                                    borderColor: 'rgba(42,51,61,1)',
                                    backgroundColor: 'rgba(255,255,255,0.8)',
                                    bodyFontColor: 'rgba(42,51,61,1)',
                                    titleFontColor: 'rgba(42,51,61,1)',
                                    callbacks: {
                                        label: function (tooltipItem, data) {
                                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || 'Other';
                                            var label = data.labels[tooltipItem.index];
                                            return datasetLabel + ': ' + Number(tooltipItem.yLabel).toFixed(2);
                                            //.replace(/./g, function(c, i, a) {
                                            //return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                                            //   });
                                        }
                                    }
                                },
                                scales: {
                                    xAxes: [{
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Month'
                                        }
                                    }],
                                    yAxes: [{
                                        scaleLabel: {
                                            display: false,
                                            labelString: 'TOTAL VALUE OF GUARANTEES'
                                        },
                                        stacked: false,
                                        ticks: {
                                            // fixedStepSize: '0.5',
                                            beginAtZero: true,
                                            // stepSize: 100000,
                                            // Return an empty string to draw the tick line but hide the tick label
                                            // Return `null` or `undefined` to hide the tick line entirely
                                            userCallback: function (value, index, values) {
                                                // Convert the number to a string and splite the string every 3 charaters from the end
                                                if (value >= 1000 || value <= -1000) {
                                                    value = value.toFixed(0);
                                                    value = value.toString();
                                                    value = value.split(/(?=(?:...)*$)/);
                                                    value = value.join(',');
                                                    // Convert the array to a string and format the output
                                                }
                                                else if (value >= 10 || value <= -10) {
                                                    value = value.toFixed(0);
                                                }
                                                else {
                                                    value = value.toFixed(2);
                                                }
                                                return value;
                                            }
                                        }
                                        //    categoryPercentage: 1.0,
                                        //   barPercentage: 0.8
                                    }]
                                },
                                annotation: {
                                    annotations: [{
                                        type: 'line',
                                        mode: 'horizontal',
                                        scaleID: 'y-axis-0',
                                        value: this.totallimit,
                                        borderColor: "rgba(54,65,78,1)",
                                        borderWidth: 4,
                                        borderDash: [2, 2],
                                        borderDashOffset: 5,
                                        label: {
                                            enabled: true,
                                            content: 'Total limit ' + this.totallimit + 'M ' + baseccy,
                                            backgroundColor: 'rgba(54,65,78,1)',
                                            position: "right",
                                            yAdjust: 20,
                                        }
                                    }]
                                }
                            }
                        });
                }
            });
        },
        fetchData() {
            return this.$http.get(this.url, {params: {range1: this.internalrange[0], range2: this.internalrange[1]}});
        },
    }
}

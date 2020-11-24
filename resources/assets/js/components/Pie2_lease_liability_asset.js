import Chart from 'chart.js';
import ChartJsPluginDataLabels from 'chartjs-plugin-datalabels';

export default{
    components: {ChartJsPluginDataLabels},
    props: {
        url: ''
    },
    template: '<div><div v-show="responseJson" id="wrapper3" style="position: relative; height: 22vh"><canvas id="pie2"></canvas><div id="chart-legends3"></div></div>  <div v-show="!responseJson" class="dashboardWrapper">Nothing to show</div></div>',
    mounted() {
        this.load();
    },
    data() {
        return {
            responseJson:false
        }
    },
    methods: {
        load() {
            this.fetchData().then(response =>
            {
                if(response.data['data'].length){
                    this.responseJson=response.data['data'].reduce((a,b)=>a+b)>95
                }
                const labels = response.data['labels'];
                const datasetValue = response.data['data'];
                const data = {
                    datasets: [{
                        backgroundColor: [
                            '#00c851',
                            '#fb3',
                            '#29B6F6',
                            '#FF5252',
                            '#26a69a',
                            '#fb8c00',
                            '#00c851',
                            '#fb3',
                            '#29B6F6'
                        ],
                        data: datasetValue
                    }],
                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: labels
                };
                if (typeof this.myChart !== "undefined") {
                    this.myChart.data.labels = data.labels;
                    this.myChart.data.datasets = data.datasets;
                    this.myChart.update();
                } else {
                    var context = document.getElementById('pie2').getContext('2d');
                    document.getElementById("wrapper3").style.height = '22vh';
                    this.myChart = new Chart(context,
                        {
                            type: 'bar',
                            data: data,

                            options: {
                        /*        legendCallback: function(chart) {
                                    var text = [];
                                    text.push('<ul class="legend">');
                                    for (var i=0; i<chart.data.datasets[0].data.length; i++) {
                                        //console.log(chart.data.datasets[i]); // see what's inside the obj.
                                        text.push('<li>');
                                        text.push('<span style="background-color:' + chart.data.datasets[0].backgroundColor[i] + '">'  + '</span>' + chart.data.labels[i]);
                                        text.push('</li>');
                                    }
                                    text.push('</ul>');
                                    return text.join("");
                                },*/
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: false,
                                    text: 'Short-term/Long-term',
                                    position: 'top'
                                },
                                responsive:true,
                                maintainAspectRatio: false,
                                plugins: {
                                    datalabels: {
                                        align: 'center',
                                        color: "#fff",
                                        font: {
                                            family: '"Font Awesome 5 Free"',
                                            size: 7
                                        },
                                        display: function(context) {



                                            return datasetValue[context.dataIndex] !== 0; // display labels with an odd index
                                        }
                                    }
                                },

                                tooltips: {
                                    borderColor: 'rgba(42,51,61,1)',
                                    backgroundColor: 'rgba(255,255,255,0.8)',
                                    bodyFontColor: 'rgba(42,51,61,1)',
                                    titleFontColor: 'rgba(42,51,61,1)',
                                    mode: 'label',
                                    callbacks: {
                                        label: function(tooltipItem, data) {
                                            var allData = data.datasets[tooltipItem.datasetIndex].data;
                                            var tooltipLabel = data.labels[tooltipItem.index];
                                            var tooltipData = allData[tooltipItem.index];
                                            var total = 0;
                                            for (var i in allData) {
                                                total += allData[i];
                                            }
                                            var tooltipPercentage = Math.round((tooltipData / total) * 100);
                                            return tooltipLabel + ': ' + Number(tooltipData).toFixed(0).replace(/./g, function (c, i, a) {
                                                return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                                            }) + ' (' + tooltipPercentage + '%)';
                                        }
                                    },
                                }
                            },
                        });
                }
               /* document.getElementById("chart-legends3").innerHTML =  this.myChart.generateLegend();*/
            });
        },
        fetchData() {
            return this.$http.get(this.url, {params: {}});
        },
    }
}
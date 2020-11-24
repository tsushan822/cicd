import Chart from 'chart.js';

export default {
    props: {
        url: ''
    },
    template: '<div><div v-show="responseJson" id="wrapper4" style="position: relative; height: 22vh"><canvas id="pie3"></canvas><div id="chart-legends4"></div></div><div v-show="!responseJson" class="dashboardWrapper">Nothing to show</div></div>',
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
                            '#4ABAEB',

                            '#38AFE8',

                            '#26A3E5',

                            '#1498E1',

                            '#028CDE',

                            '#027FCF',

                            '#0272C0',

                            '#0165B1',

                            '#0158A2'
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
                    var context = document.getElementById('pie3').getContext('2d');
                    document.getElementById("wrapper4").style.height = '22vh';
                    this.myChart = new Chart(context,
                        {
                            type: 'pie',
                            data: data,
                            options: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: false,
                                    text: 'Short-term/Long-term',
                                    position: 'top'
                                },
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    datalabels: {
                                        display: false,
                                    }
                                },
                                tooltips: {
                                    borderColor: 'rgba(42,51,61,1)',
                                    backgroundColor: 'rgba(255,255,255,0.8)',
                                    bodyFontColor: 'rgba(42,51,61,1)',
                                    titleFontColor: 'rgba(42,51,61,1)',
                                    mode: 'label',
                                    callbacks: {
                                        label: function (tooltipItem, data) {
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
               /* document.getElementById("chart-legends4").innerHTML = this.myChart.generateLegend();*/
            });
        },
        fetchData() {
            return this.$http.get(this.url, {params: {}});
        },
    }
}

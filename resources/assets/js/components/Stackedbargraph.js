
import Chart from 'chart.js';

export default{

    props: {
        url: '', typedataset: {}, typelabels: {},
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
        }},
    template: '<canvas position="relative" id="stackedbargraph"></canvas>',
 
    mounted() {
        this.load();


    },

    methods: {

        load() {
            this.fetchData().then(response =>
            {
                //console.log(response.data);
                //      console.log(response.data['labels'][0]); // Dumps object including 
                const labels = response.data['typelabels'];
                const counterpartylabels = response.data['typecounterpartylabels'];
                const dataset = response.data['typedataset'];
       
                const counterpartycount = response.data['counterpartyCount'];
                
               console.log(response);
            if (counterpartycount < 4) {
                var datasetColor = ["#81c7ef","#358bc4","#0e547c"];

            } else if (counterpartycount < 7) {
                var datasetColor = [
                    "#81c7ef", "#5fafe4","#4297d1","#2980b7","#176a9b","#0e547c"];

            } else {
                var datasetColor = ["#81c7ef","#71bbeb","#62b1e5","#54a6de","#479cd4","#3a91ca","#3087bf","#257cb2","#1d71a5","#166898","#115e8a","#0e547c"];

            }

           /*     var datasetColor = [
                 "25, 153, 227",
                 "54, 65, 78",
                 "231, 223, 232",
                 "79,197,16",
                 
                 "255,191,0",
                 "239,62,54",
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
                ];*/
                var datasetValue = [];


                var count = counterpartycount;
                //   const dataset=response.data['dataset'];
                for (var j = 0; j < count; j++) {
                    datasetValue[j] =
                            {
                                label: counterpartylabels[j],
                                lineTension: 0,
                                backgroundColor: datasetColor[j],
                                borderColor: datasetColor[j],
                                borderWidth: 1,
                                hoverBackgroundColor: datasetColor[j],
                                hoverBorderColor: datasetColor[j],
                                data: dataset[j]
                            }

                }



                var data = {
                    labels: labels,
                    datasets: datasetValue

                };
                if (typeof this.myChart !== "undefined") {

                    this.myChart.data.labels = data.labels;
                    this.myChart.data.datasets = data.datasets;
                    this.myChart.update();
                } else {
                    var context = document.getElementById('stackedbargraph').getContext('2d');
                    this.myChart = new Chart(context,
                            {

                                type: 'bar',
                                data: data,
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: false,
                                        }
                                    },
                                    scales: {
                                        xAxes: [{stacked: true,
                                            ticks: {
    autoSkip: false
}}],
                                        yAxes: [{
                                                stacked: true,
                                                ticks: {
                                                    beginAtZero: true,
                                                     
                                                }
                                            }]
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
                                                return datasetLabel + ': ' + Number(tooltipItem.yLabel).toFixed(0);
                                                //.replace(/./g, function(c, i, a) {
                                                //return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                                                //   });
                                            }
                                        }
                                    }}




                            });
                }
            });
        },
        fetchData() {

            return this.$http.get(this.url, {params: {}});
        },
    }


}







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
    template: '<div id="wrapper3" style="position: relative; height: 45vh"><canvas id="stackedbargraph2"></canvas> <div id="chart-legends"></div></div>',


    mounted() {
        this.load();


    },

    methods: {

        load() {
            this.fetchData().then(response =>
            {
                //console.log(response.data);
                //      console.log(response.data['labels'][0]); // Dumps object including
                const labels = response.data['typeLabels'];
            const counterpartylabels = response.data['typeCounterpartyLabels'];
            const dataset = response.data['typeDataSet'];

            const counterpartycount = response.data['counterpartyCount'];
            const liabilitycount = response.data['liabilityCount'];

            console.log(response);

            if (counterpartycount < 4) {
                var datasetColorLiability = ["#81c7ef",
                    "#358bc4",
                    "#0e547c"];
                var datasetColorAsset = [
                    "#8fda66",
                    "#4ba51f",
                    "#2c6c09"];
            } else if (counterpartycount < 7) {
                var datasetColorLiability = ["#81c7ef","#5fafe4","#4297d1","#2980b7","#176a9b","#0e547c"];
                var datasetColorAsset = ["#8fda66","#6cc63f","#54af27","#439917","#36820e","#2c6c09"];
            } else {
                var datasetColorLiability = ["#81c7ef","#71bbeb","#62b1e5","#54a6de","#479cd4","#3a91ca","#3087bf","#257cb2","#1d71a5","#166898","#115e8a","#0e547c"];
                var datasetColorAsset = [
                    "#8fda66",
                    "#7dd251","#6ec841","#62bd35","#58b42b","#4faa23","#489f1b","#409415","#3a8b11","#35810d","#30760a","#2c6c09"];
            }


            var datasetValue = [];


            var count = counterpartycount;


            var d =0;
            var e = 0;
            console.log(datasetColorAsset);

            for (var j = 0; j < count; j++) {

                if (j >= liabilitycount) {

                    datasetValue[j] =
                        {
                            label: counterpartylabels[j],

                            backgroundColor: datasetColorAsset[d],
                            borderColor: datasetColorAsset[d],
                            hoverBackgroundColor: datasetColorAsset[d],

                            hoverBorderColor: datasetColorAsset[d],
                            data: dataset[j]

                        }
                    d++;
                }
                else {

                    datasetValue[j] =
                        {
                            label: counterpartylabels[j],

                            backgroundColor: datasetColorLiability[e],
                            borderColor: datasetColorLiability[e],
                            hoverBackgroundColor: datasetColorLiability[e],

                            hoverBorderColor: datasetColorLiability[e],
                            data: dataset[j]

                        }

                    e++;
                }

            }


            var data = {
                labels: labels,
                datasets: datasetValue

            };
            console.log(data.datasets);
            if (typeof this.myChart !== "undefined") {

                this.myChart.data.labels = data.labels;
                this.myChart.data.datasets = data.datasets;
                this.myChart.update();
            } else {
                var context = document.getElementById('stackedbargraph2').getContext('2d');

                document.getElementById("chart-legends").style.height = '15vh';
                document.getElementById("wrapper3").style.height = '45vh';

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
                            legendCallback: function(chart) {
                                var text = [];
                                text.push('<ul class="legend">');
                                for (var i=0; i<chart.data.datasets.length; i++) {
                                    //console.log(chart.data.datasets[i]); // see what's inside the obj.
                                    text.push('<li>');
                                    console.log(chart.data.datasets[i].borderColor);
                                    text.push('<span style="background-color:' + chart.data.datasets[i].borderColor + '">'  + '</span>' + chart.data.datasets[i].label);
                                    text.push('</li>');
                                }
                                text.push('</ul>');
                                return text.join("");
                            },
                            legend: {
                                display: false
                            },
                            responsive:true,
                            maintainAspectRatio: false,
                            scales: {
                                xAxes: [{stacked: true,
                                    ticks: {
                                        autoSkip: false
                                    }}],
                                yAxes: [{
                                    stacked: true,
                                    ticks: {
                                        beginAtZero: true,
                                        userCallback: function (value, index, values) {
                                            // Convert the number to a string and splite the string every 3 charaters from the end
                                            if (value < 1) {
                                                value = value.toFixed(2);
                                            }
                                            else {
                                                value = value.toString();
                                                value = value.split(/(?=(?:...)*$)/);
                                                value = value.join(',');
                                                // Convert the array to a string and format the output
                                            }

                                            return value;
                                        }

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
                                        return datasetLabel + ': ' + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                                        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                                        });
                                    }
                                }
                            }}




                    });

            }
            document.getElementById("chart-legends").innerHTML =  this.myChart.generateLegend();
            console.log( this.myChart.generateLegend);
        });
        },

        fetchData() {

            return this.$http.get(this.url, {params: {}});
        },
    }


}






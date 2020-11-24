import Chart from 'chart.js';

export default {
    template: '<canvas width="600" height="200" id="bar"></canvas>',

    props: {
        labels: {},
        values: {},
        topic: '',
    },


    mounted() {
        const colours = this.values.map((value) => value < 0 ? '#1999E3' : '#FFBF00');
        var data = {
            labels: this.labels,

            datasets: [
                {
                    label: this.topic,

                    data: this.values,
                    backgroundColor: colours ,
                    borderColor: colours ,
                    borderWidth: 1
                }
            ]
        };
        var context = document.getElementById('bar').getContext('2d');

        const chart = new Chart(context,
            {

                type: 'bar',
                data: data,

                options: {
                    plugins: {
                        datalabels: {
                            display: false
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                // stepSize: 100000,
                                // Return an empty string to draw the tick line but hide the tick label
                                // Return `null` or `undefined` to hide the tick line entirely
                                userCallback: function (value, index, values) {
                                    // Convert the number to a string and splite the string every 3 charaters from the end


                                        value = value.toFixed(0);
                                        value = value.toString();
                                        value = value.split(/(?=(?:...)*$)/);
                                        value = value.join(',');
                                        value = value.replace('-,','-')
                                        // Convert the array to a string and format the output


                                    return value;
                                }
                            }
                        }],
                    },tooltips: {

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

                                var number=Number(tooltipItem.yLabel).toFixed(0);
                                number = number.toString();
                                number= number.split(/(?=(?:...)*$)/);
                                number= number.join(',');
                                number = number.replace('-,','-')

                                return datasetLabel + ': ' + number;
                                //.replace(/./g, function(c, i, a) {
                                //return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                                //   });
                            }
                        }
                    }
                }

            });
        console.log(chart.generateLegend());
    }
}
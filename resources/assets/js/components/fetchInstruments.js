
import Chart from 'chart.js';

export default{

    props: {
        url: ''
    },
    template: '<canvas position="relative" id="pie"></canvas>',

    mounted() {
        this.load();


    },

    methods: {

        load() {
            this.fetchData().then(response =>
            {
                //console.log(response.data);
                //      console.log(response.data['labels'][0]); // Dumps object including
                const labels = response.data['labels'];
            const datasetValue = response.data['data'];
            console.log(labels);
            console.log(datasetValue);


            const data = {
                datasets: [{
                    backgroundColor: [
                        "#1999E3",
                        "#36414E",
                        "#FFBF00"
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
                var context = document.getElementById('pie').getContext('2d');
                this.myChart = new Chart(context,
                    {

                        type: 'pie',
                        data: data,
                        options: {

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
        });
        },
        fetchData() {

            return this.$http.get(this.url, {params: {}});
        },
    }


}













Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
new Vue({
    el: '#deals',
//    data: {
//        newDeal: {
//            deals: [],
//
//        },
//
//    },

    data: {
        deals: []


    },
    ready: function () {
        this.fetchDeals();
    },
    methods: {
        fetchDeals: function () {
            //route
            this.$http.get('/api/deals', function (deals)
            {
                //key and date
                this.$set('deals', deals);
            });
        },
        onSubmitForm: function (deal)
            //called by this in view <form method="POST" v-on="submit: onSubmitForm">
        {

            //prevent the default action
            // added (e)
            //deal.preventDefault();
            //var deal = this;
            //send post ajax request
            this.$http.put('api/deals/'+ deal.id);

            this.deals.$remove(deal);
            //hide the submit button
            //add the v-if to <div class="form-group" v-if="!submitted">
        },
        onSubmitForm1: function (deal) {

            $.ajax({
                context: deal,
                type: "PATCH",
                url: "/api/deals/" + deal.id,
            })
            this.deals.$remove(deal);
        },
        removeDeal:function(deal){
            this.$http.patch("api/deals/" + deal.id);
            //this.deals.$remove(deal);
        }

    }
});



import Chart from 'chart.js';

export default{
    template: '<canvas width="600" height="400" id="graph"></canvas>',

 props: {
labels: {},
values: {},
fill: {
//default: "rgba(0,220,220,0.2)"
}
},
        
mounted() {
        var data = {
      labels: this.labels,
       
     datasets: [
    {
        label: 'Monthly Points',
     backgroundColor: this.fill,
//      strokeColor: "rgba(220,220,220,1)",
//      pointColor: "rgba(220,220,220,1)",
//      pointStrokeColor: "#fff",
//      pointHighlightFill: "#fff",
//      pointHighlightStroke: "rgba(220,220,220,1)",
      data: this.values
    },
     {
        label: 'Other Points',
     backgroundColor: "#000",
//      strokeColor: "rgba(220,220,220,1)",
//      pointColor: "rgba(220,220,220,1)",
//      pointStrokeColor: "#fff",
//      pointHighlightFill: "#fff",
//      pointHighlightStroke: "rgba(220,220,220,1)",
      data: [10,10,10]
    }
  ]
        };
   var context = document.getElementById('graph').getContext('2d');
   const chart=  new Chart(context,
                {

                    type: 'line',
                    data: data

                });
                console.log(chart.generateLegend());
    }
}
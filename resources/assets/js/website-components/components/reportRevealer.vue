<template>
    <div>
        <li  class="report_li" v-for="(report,index) in reports" :key="index">
            <div v-on:mouseover="revealText(index,true)" @mouseleave="revealText(index,false)">
                <p  class="d-flex justify-content-between" v-if="muted.includes(index)===false"><span v-text="report.name"></span><i class="fa nav_bg_color report_info_icon fa-info-circle"></i></p>
                <p v-show="false" v-else ><s v-text="report.name"></s><i class="fa nav_bg_color report_info_icon fa-info-circle"></i></p>
                <div v-show="report.expandedState" class="details" v-text="report.details"></div>
            </div>
        </li>
    </div>
</template>
<script>
    export default {
        props:['muted'],
        data() {
            return {
                reports:[
                    {
                        name:'Lease Changes Report',
                        details:'In this report, we will point out all starting values and changes of the lease term impacting the Balance Sheet values.',
                        expandedState:false,
                    },
                    {
                        name:'Lease Payments Report',
                        details:'The ‘Lease Payments’ report displays all lease payments during the selected report period. We will also display how your fixed asset part of the payment is split between interest cost and loan repayment.',
                        expandedState:false,
                    },
                    {
                        name:'Lease Month End Report',
                        details:'In this report, you can see the liability and asset values per month-end. You can also reevaluate your liabilities (if those are nominated in different currencies), book the accrued interest (if needed), and see the monthly depreciation.',
                        expandedState:false,

                    },
                    {
                        name:'Notes Maturity Report',
                        details:'In the ‘Notes Maturity’ report, we will split your future lease payments between different maturities. You need to have this report in your Financial Notes because it lists payments from the report onwards. If you want to assess your situation for 31.12.2019, use 1.1.2020 as the report date.',
                        expandedState:false,

                    },
                    {
                        name:'Lease Valuation Report',
                        details:'If you need to revaluate your lease against an interest rate - other than the one you have used when creating the lease flow, you can compare the two different liability values in this report.',
                        expandedState:false,

                    },
                    {
                        name:'Lease summary report',
                        details:'In this report, we will bring numbers from Lease changes, payments, and month-end reports. If you want to make postings on a summary level only, you can use this report for that purpose. Please note that this is a periodical report, meaning that items will be listed on a monthly basis into the report. The maximum number of months you can have in the report is 3. If you would want to run the report periodically for a full year, you would have to run it 4 times.',
                        expandedState:false,
                    },
                    {
                        name:'Lease summary report YTD',
                        details:'The ‘Lease Summary’ report YTD only works from report automation. You need to save the report with selections needed into the library. Following this step, you can run the report from the library into your email. In this report, we will bring numbers from Lease changes, payments, and month-end reports. If you want to make postings on a summary level only, you can easily use this report for that purpose. The report lists year-to-date numbers to each selected entity. One column is one entity. In this report we just bring numbers from Lease changes, payments and month end report. If you want to make postings only on summary level you can just simply use this report for that purpose. The reports lists year-to-date numbers to each entity selected into the report. One column is one entity.',
                        expandedState:false,

                    },
                    {
                        name:'RoU Asset by Lease Type Report',
                        details:'In this report, we will split all the RoU Asset posting items by lease type.',
                        expandedState:false,

                    },
                    {
                        name:'Additions to Lease Liability Report',
                        details:'In this report, we will list all values that have been added to the RoU Asset of each lease agreement. The items are Lease payments made on or before the commencement date, Initial direct cost, estimated cost for dismantling a restoring asset, Incentives received, and Residual value. In this report, all RoU Asset posting items can be split by lease type. In this report split all the RoU Asset posting items by lease type.',
                        expandedState:false,

                    } ,
                    {
                        name:'Additions to Right of Use Asset Report',
                        details:'In this report we list all values that has been added to RoU Asset to each lease agreement. So the items areLease payments made on or before commencement date,Initial direct cost,Estimated cost for dismantling restoring asset,Incentives received and Residual value In this report, we will list all values that have been added to the RoU Asset of each lease agreement. The items are Lease payments made on or before the commencement date, Initial direct cost, estimated cost for dismantling a restoring asset, Incentives received, and Residual value. The lists in the report are based on the selected date, and they will be brought from agreements that are valid during the selected date. All values will be entered into those columns.',
                        expandedState:false,

                    },
                    {
                        name:'Facility overview report',
                        details:'This report brings mostly data entered into the Facility management sheet. By leaving the date unselected, the report will use the latest currency rates if there is a need to convert some currency agreements into the selected currency. The report will bring all agreements (valid or outdated) where "Yes" is selected in the Facility management sheet in the Show agreement in report-dropdown.',
                        expandedState:false,

                    },
                    {
                        name:'Realised result',
                        details:'contact for more information',
                        expandedState:false,

                    },
                    {
                        name:'Unrealised result',
                        details:'contact for more information',
                        expandedState:false,

                    },
                    {
                        name:'Voucher history',
                        details:'contact for more information',
                        expandedState:false,

                    },
                    {
                        name:'Audit trail reporting',
                        details:'contact for more information',
                        expandedState:false,

                    },



                ],
                currentHoveredState:false,
            }
        },
        methods: {
            revealText(index,boolean){
                this.reports[index].expandedState = boolean
            }
        },
        mounted() {

        },
        created: function() {

        }
    }
</script>
<style scoped>
.report_info_icon{

}
    .nav_bg_color{
        color:#028CDE;
        position:absolute;
        right:10%;
    }
    .report_li{
        cursor:pointer;
        list-style:none;
    }
    .report_li .details{
        position: relative;
        top: -0.5rem;
    }
    .report_li span{
        text-align: left;
    }
</style>
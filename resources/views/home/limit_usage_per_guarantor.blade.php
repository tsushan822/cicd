<div class="x_title">
    <h2>Limit usage per guarantor</h2>
    <div class="clearfix"></div>
</div>

<div class="x_content">
    <div class="dashboard-widget-content">
        <limitsgraph :labels="{{ $returnValue['labels'] }}" :unused="{{ $returnValue['chartUnused'] }}" :used="{{ $returnValue['chartUsed'] }}"
                     :exceeded="{{ $returnValue['chartExceeded'] }}" baseccy="{{ $returnValue['baseCurrency'] }}" showtitle="{{false}}"
                     color="#fff">
        </limitsgraph>
    </div>
</div>
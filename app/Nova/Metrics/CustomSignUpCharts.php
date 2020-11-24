<?php

use Coroowicaksono\ChartJsIntegration\LineChart;

class CustomSignUpCharts extends LineChart
{

    public function leftJoin(string $joinTable, string $joinColumnFirst, string $joinEqual, string $joinColumnSecond): self
    {
        return $this->withMeta([ 'leftJoin' => ['joinTable' => $joinTable, 'joinColumnFirst' => $joinColumnFirst, 'joinEqual' => $joinEqual, 'joinColumnSecond' => $joinColumnSecond] ]);
    }
}
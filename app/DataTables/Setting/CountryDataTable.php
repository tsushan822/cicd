<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/11/2018
 * Time: 14.04
 */

namespace App\DataTables\Setting;


use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\Setting\Model\Country;
use App\Zen\User\Permission\Permission;

class CountryDataTable extends BaseDataTable
{
    use Permission;
    use DataTableActionPermission;

    /**
     * Build DataTable class.
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables() -> of($query)
            -> editColumn('currency_id', function ($country) {
                if(!file_exists('vendor/famfamfam/png/' . $country -> iso_3166_code . '.png'))
                    return '<img src="/vendor/famfamfam/png/fam.png"> ' . $country -> iso_4217_code;

                return '<img src="/vendor/famfamfam/png/' . $country -> iso_3166_code . '.png"> ' . $country -> currency -> iso_4217_code;
            })
            -> editColumn('is_EEA', function ($country) {
                return '<i class="' . getLargeCheckBox($country -> is_EEA) . '">' . '<span style="font-size:1px">' . $country -> is_EEA . '</span>';
            })
            -> rawColumns(['currency_id', 'is_EEA']);
    }

    public function query()
    {
        return Country :: with('currency') -> select('countries.*');
    }

    /**
     * Get columns.
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            'name',
            'iso_3166_code',
            'is_EEA',
            'currency_id' => ['name' => 'currency.iso_4217_code', 'title' => 'Currency'],
        ];
    }

    public
    function action($country)
    {
        $editPermission = 'is_superadmin';
        $deletePermission = 'is_superadmin';
        $editRoute = "/countries/" . $country -> id . "/edit";
        $deleteRoute = "/countries/" . $country -> id;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);
        return $returnValue;
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected
    function filename()
    {
        return 'Country_' . date('YmdHis');
    }

    /**
     * Optional method if you want to use html builder.
     * @return \Yajra\DataTables\Html\Builder
     */
    public
    function html()
    {
        //translation varaibles
        $locale = \App ::getLocale();
        $allTranslation = trans('master.All');
        return $this -> builder()
            -> columns($this -> getColumns())
            -> minifiedAjax()
            -> parameters([
                'buttons' => [
                    'extend' => 'collection',
                    'text' => __('Export'),
                    'buttons' => [
                        [
                            'extend' => 'csvHtml5',
                            'text' => __('CSV'),
                            'filename' => $this -> filename(),
                            'modifier' => [
                                'page' => 'all'
                            ]
                        ],
                        [
                            'extend' => 'excelHtml5',
                            'text' => __('Excel'),
                            'filename' => $this -> filename(),
                            'title' => '',
                            'modifier' => [
                                'page' => 'all'
                            ]
                        ],
                        ['extend' => 'pageLength',]
                    ]
                ],
                'oLanguage' => ['sUrl' => "/languages/dataTables.$locale.txt"],
                'dom' => 'Bfrtip',
                'pageLength' => 250,
                'stateSave' => false,
                'responsive' => true,
                "autoWidth" => false,
                "aLengthMenu" => [[250, 500, -1], [250, 500, $allTranslation]],
                "order" => $this -> setOrderBy(),
            ]);
    }
}
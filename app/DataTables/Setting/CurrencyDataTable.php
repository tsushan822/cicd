<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/11/2018
 * Time: 13.51
 */

namespace App\DataTables\Setting;


use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\Setting\Model\Currency;
use App\Zen\User\Permission\Permission;

class CurrencyDataTable extends BaseDataTable
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
            -> addColumn('action', function ($currency) {
                return $this -> action($currency);
            })
            -> editColumn('iso_4217_code', function ($currency) {
                if(!file_exists('vendor/famfamfam/png/' . $currency -> iso_3166_code . '.png'))
                    return '<img src="/vendor/famfamfam/png/fam.png"> ' . $currency -> iso_4217_code;

                return '<img src="/vendor/famfamfam/png/' . $currency -> iso_3166_code . '.png"> ' . $currency -> iso_4217_code;
            })
            -> editColumn('active_status', function ($currency) {
                return '<i class="' . getLargeCheckBox($currency -> active_status) . '">'. '<span style="font-size:1px">' . $currency -> active_status . '</span>';
            })
            -> rawColumns(['action', 'iso_4217_code', 'active_status']);
    }

    public function query()
    {
        return Currency :: select('currencies.*');
    }

    /**
     * Get columns.
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            'action',
            'iso_4217_code',
            'iso_3166_code',
            'iso_number',
            'currency_name',
            'active_status'
        ];
    }

    public
    function action($currency)
    {
        $editPermission = 'edit_currency';
        $deletePermission = 'delete_currency';
        $editRoute = "/currencies/" . $currency -> id . "/edit";
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute);
        return $returnValue;
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected
    function filename()
    {
        return 'Currency_' . date('YmdHis');
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
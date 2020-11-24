<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/11/2018
 * Time: 12.53
 */

namespace App\DataTables\Setting;


use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\Setting\Model\Portfolio;
use App\Zen\User\Permission\Permission;

class PortfolioDataTable extends BaseDataTable
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
            -> addColumn('action', function ($fxDeal) {
                return $this -> action($fxDeal);
            })
            -> rawColumns(['action']);
    }

    public function query()
    {
        return Portfolio :: all();
    }

    /**
     * Get columns.
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            'action' => ['title' => trans('master.Action')],
            'name' => ['data' => 'name', 'name' => 'name', 'title' => trans('master.Name')],
            'long_name' => ['data' => 'long_name', 'name' => 'long_name', 'title' => trans('master.Description')],

        ];
    }

    public
    function action($fxDeal)
    {
        $editPermission = 'edit_portfolio';
        $deletePermission = 'delete_portfolio';
        $editRoute = "/portfolios/" . $fxDeal -> id . "/edit";
        $deleteRoute = "/portfolios/" . $fxDeal -> id;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);
        $returnValue = $returnValue . ' <a href="/portfolios/copy/' . $fxDeal -> id . '"><i class="fas fa-copy edit_fontawesome_icon" title="Copy existing portfolios"></i></a>';
        return $returnValue;
    }

}
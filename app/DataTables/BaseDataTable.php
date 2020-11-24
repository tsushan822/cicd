<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/11/2018
 * Time: 16.32
 */

namespace App\DataTables;


use App\Zen\User\Permission\AllowedEntity;
use Yajra\DataTables\Services\DataTable;

class BaseDataTable extends DataTable
{
    use AllowedEntity;

    protected $isArchived = false;

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this -> isArchived;
    }

    /**
     * @param bool $isArchived
     * @return $this
     */
    public function setIsArchived(bool $isArchived)
    {
        $this -> isArchived = $isArchived;
        return $this;
    }

    /**
     * Optional method if you want to use html builder.
     * @return \Yajra\DataTables\Html\Builder
     */
    public
    function html()
    {
        //translation varaibles
        $locale = \App::getLocale();
        $allTranslation = trans('master.All');
        return $this -> builder()

            -> columns($this -> getColumns())
            -> minifiedAjax()
            -> parameters([
                'oLanguage' => ['sUrl' => "/languages/dataTables.$locale.txt"],
                'dom' => 'Bfrtip',
                'buttons' => ['excel', 'csv', 'print', 'copy', 'pageLength'],
                'pageLength' => 50,
                'stateSave' => false,
                'responsive' => true,
                "autoWidth" => false,
                "aLengthMenu" => [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, $allTranslation]],
                "order" => $this -> setOrderBy(),
            ]);
    }

    /**
     * @return array
     */
    public function setOrderBy(): array
    {
        return [[0, 'asc']];
    }
}
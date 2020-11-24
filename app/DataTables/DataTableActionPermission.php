<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 12/04/2018
 * Time: 14.37
 */

namespace App\DataTables;


trait DataTableActionPermission
{
    public function actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute = null)
    {
        $returnValue = '';
        $returnValue = $this -> checkAllowAccessWithoutException($editPermission) ?
            $returnValue . ' <a href="' . $editRoute . '"><i class="fas fa-pen-square edit_fontawesome_icon" title="Show/Edit the item"></i></a>' :
            $returnValue . ' <a href="' . $editRoute . '"><i class="fas fa-eye edit_fontawesome_icon" title="Show the item"></i></a>';
        if($deleteRoute)
            $returnValue = $this -> checkAllowAccessWithoutException($deletePermission) ? $returnValue . ' <a href="' . $deleteRoute . '"><i class="far fa-minus-square delete_fontawesome_icon" title="Delete the item"></i></a>' : $returnValue . '';
        return $returnValue;

    }
}
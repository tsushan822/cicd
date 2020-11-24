<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 02/05/2018
 * Time: 10.02
 */

namespace App\Zen\Lease\Model;


use App\Repository\Eloquent\Repository;
use App\Zen\Setting\Model\Counterparty;
use Illuminate\Support\Facades\Auth;

class LeaseTypeRepository extends Repository
{
    /**
     * Specify Model class name
     * @return mixed
     */
    public function model()
    {
        return LeaseType::class;
    }

    public function handleCreate($request)
    {
        $request -> request -> add(['user_id' => Auth ::id()]);
        flash() -> overlay(trans('master.New lease type created!'), trans('master.Success!'))-> message();
        return $this -> create($request -> all());
    }

    public function handleEdit($request, $id)
    {
        $request -> request -> add(['updated_user_id' => Auth ::id()]);
        flash() -> overlay(trans('master.Lease type updated!'), trans('master.Success!')) -> message();
        $this -> findOrFail($id) -> update($request -> all());
    }

    public function itemIcon()
    {
        $leaseItemIcons = ['Machinery' => 'Machinery', 'Building' => 'Building', 'IT' => 'IT', 'Vehicle' => 'Vehicle', 'Other' => 'Other'];
        return $leaseItemIcons;
    }

    public function checkDeletable(int $id)
    {
        $leaseType = LeaseType ::with( 'leases') -> findOrFail($id);
        return count($leaseType -> leases);
    }
}
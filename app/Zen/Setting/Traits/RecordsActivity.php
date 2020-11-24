<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 01/12/2017
 * Time: 10.46
 */

namespace App\Zen\Setting\Traits;


use App\Zen\Setting\Model\AuditTrail;
use App\Zen\User\UserList\AllUser;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

trait RecordsActivity
{
    use AllUser;

    /**
     * Register the necessary event listeners.
     * @return void
     */
    protected static function bootRecordsActivity()
    {
        foreach(static ::getModelEvents() as $event) {
            static ::$event(function ($model) use ($event) {
                if($event == 'deleted')
                    $model -> recordDeletedActivity($event);
                else
                    $model -> recordActivity($event);
            });
        }
    }

    /**
     * Record activity for the model.
     * @param string $event
     * @return void
     * @throws \ReflectionException
     */
    public function recordActivity($event)
    {
        list($before, $after, $flag) = $this -> getDiff();
        if($flag) {
            AuditTrail ::create([
                'user_id' => Auth :: check() ? Auth ::id() : 1,
                'table_id' => $this -> id,
                'model' => (new ReflectionClass($this)) -> getShortName(),
                'before' => $before,
                'after' => $after,
                'event' => $event
            ]);
        }
    }

    /**
     * Record activity for the model.
     * @param string $event
     * @return void
     * @throws \ReflectionException
     */
    public function recordDeletedActivity($event)
    {
        AuditTrail ::create([
            'user_id' => Auth :: check() ? Auth ::id() : 1,
            'table_id' => $this -> id,
            'model' => (new ReflectionClass($this)) -> getShortName(),
            'before' => (new ReflectionClass($this)) -> getShortName() . ' deleted',
            'after' => '',
            'event' => $event
        ]);

    }

    /**
     * @return array
     */
    protected function getDiff()
    {
        $before = [];
        $after = [];
        $flag = 0;
        $columnsName = $this -> getColumnsName();
        $changed = $this -> getDirty();
        foreach($changed as $field => $newdata) {
            $olddata = $this -> getOriginal($field);
            if($olddata != $newdata && in_array($field, $columnsName)) {
                $before = json_encode(array_intersect_key($this -> getOriginal(), $changed));
                $after = json_encode($changed);
                return array($before, $after, 1);
            }
        }
        return array($before, $after, $flag);
    }

    /**
     * Get the model events to record activity for.
     * @return array
     */
    protected static function getModelEvents()
    {
        if(isset(static ::$recordEvents)) {
            return static ::$recordEvents;
        }
        return ['updated', 'created', 'deleted'];
    }

    protected function getColumnsName()
    {
        if(isset(static ::$columnsName)) {
            return static ::$columnsName;
        }

        if(!isset(static ::$noAuditElements)) {
            $noAuditElements = ['id','created_at','updated_at'];
        }

        $allColumns = array_keys($this -> getAttributes());
        $auditColumns = array_diff($allColumns, $noAuditElements);
        return $auditColumns;
    }

}
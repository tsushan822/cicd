<?php

namespace Seeds\Tenant;

use App\Zen\User\Model\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    public
    function run()
    {
        DB ::table('permissions') -> truncate();

        $this -> createPermissions();

    }

    private function createPermissions()
    {
        $rolesArray = $this -> createPermissionArray();
        foreach($rolesArray as $role) {
            Permission ::create([
                'name' => $role['name'],
                'label' => $role['label'],
            ]);
        }
    }

    private function createPermissionArray(): array
    {

        $rolesArray = [
            //1
            [
                'name' => 'can_view',
                'label' => 'Can View',
            ],


            //2
            [
                'name' => 'create_fxrate',
                'label' => 'Create fxrate',
            ],

            //3
            [
                'name' => 'edit_fxrate',
                'label' => 'Edit fxrate',
            ],

            //4
            [
                'name' => 'delete_fxrate',
                'label' => 'Delete fxrate',
            ],

            //5
            [
                'name' => 'is_superadmin',
                'label' => 'Is superadmin',
            ],

            //6
            [
                'name' => 'view_user',
                'label' => 'View user',
            ],

            //7
            [
                'name' => 'edit_user',
                'label' => 'Edit user',
            ],

            //8
            [
                'name' => 'view_counterparty',
                'label' => 'View counterparty',
            ],

            //9
            [
                'name' => 'import_counterparty',
                'label' => 'Import counterparty',
            ],

            //10
            [
                'name' => 'create_counterparty',
                'label' => 'Create counterparty',
            ],

            //11
            [
                'name' => 'edit_counterparty',
                'label' => 'Edit counterparty',
            ],

            //12
            [
                'name' => 'delete_counterparty',
                'label' => 'Delete counterparty',
            ],

            //13
            [
                'name' => 'create_account',
                'label' => 'Create account',
            ],

            //14
            [
                'name' => 'edit_account',
                'label' => 'Edit account',
            ],

            //15
            [
                'name' => 'delete_account',
                'label' => 'Delete account',
            ],

            //16
            [
                'name' => 'create_portfolio',
                'label' => 'Create portfolio',
            ],

            //17
            [
                'name' => 'edit_portfolio',
                'label' => 'Edit portfolio',
            ],

            //18
            [
                'name' => 'delete_portfolio',
                'label' => 'Delete portfolio',
            ],


            //19
            [
                'name' => 'create_costcenter',
                'label' => 'Create Costcenter',
            ],

            //20
            [
                'name' => 'edit_costcenter',
                'label' => 'Edit Costcenter',
            ],

            //21
            [
                'name' => 'delete_costcenter',
                'label' => 'Delete Costcenter',
            ],


            //22
            [
                'name' => 'create_lease',
                'label' => 'Create Lease',
            ],

            //23
            [
                'name' => 'edit_lease',
                'label' => 'Edit Lease',
            ],

            //24
            [
                'name' => 'delete_lease',
                'label' => 'Delete Lease',
            ],

            //25
            [
                'name' => 'view_lease',
                'label' => 'View Lease',
            ],

            //26
            [
                'name' => 'create_lease_flow',
                'label' => 'Create Lease Flow',
            ],

            //27
            [
                'name' => 'edit_lease_flow',
                'label' => 'Edit Lease Flow',
            ],

            //28
            [
                'name' => 'delete_lease_flow',
                'label' => 'Delete Lease Flow',
            ],

            //29
            [
                'name' => 'view_lease_flow',
                'label' => 'View Lease Flow',
            ],

            //30
            [
                'name' => 'create_role',
                'label' => 'Create Role',
            ],

            //31
            [
                'name' => 'edit_role',
                'label' => 'Edit Role',
            ],

            //32
            [
                'name' => 'upload_document',
                'label' => 'Upload Document',
            ],

            //33
            [
                'name' => 'delete_document',
                'label' => 'Delete Document',
            ],

            //34
            [
                'name' => 'view_document',
                'label' => 'View Document',
            ],


            //35
            [
                'name' => 'import_lease',
                'label' => 'Import lease',
            ],

            //36
            [
                'name' => 'view_lease_type',
                'label' => 'View lease type',
            ],

            //37
            [
                'name' => 'create_lease_type',
                'label' => 'Create lease type',
            ],

            //38
            [
                'name' => 'edit_lease_type',
                'label' => 'Edit lease type',
            ],

            //39
            [
                'name' => 'delete_lease_type',
                'label' => 'Delete lease type',
            ],


            //40
            [
                'name' => 'view_account',
                'label' => 'View account',
            ],

            //41
            [
                'name' => 'import_account',
                'label' => 'Import account',
            ],

            //42
            [
                'name' => 'view_portfolio',
                'label' => 'View portfolio',
            ],

            //43
            [
                'name' => 'import_portfolio',
                'label' => 'Import portfolio',
            ],

            //44
            [
                'name' => 'view_costcenter',
                'label' => 'View costcenter',
            ],

            //45
            [
                'name' => 'import_costcenter',
                'label' => 'Import costcenter',
            ],


            //46
            [
                'name' => 'view_fxrate',
                'label' => 'View fxrate',
            ],

            //47
            [
                'name' => 'import_fxrate',
                'label' => 'Import fxrate',
            ],


            //48
            [
                'name' => 'view_currency',
                'label' => 'View currency',
            ],

            //49
            [
                'name' => 'create_currency',
                'label' => 'Create currency',
            ],

            //50
            [
                'name' => 'edit_currency',
                'label' => 'Edit currency',
            ],

            //51
            [
                'name' => 'view_country',
                'label' => 'View country',
            ],

            //52
            [
                'name' => 'create_country',
                'label' => 'Create country',
            ],

            //53
            [
                'name' => 'edit_country',
                'label' => 'Edit country',
            ],

            //54
            [
                'name' => 'view_report',
                'label' => 'View report',
            ],

            //55
            [
                'name' => 'save_report',
                'label' => 'Save report',
            ],

        ];
        return $rolesArray;
    }
}
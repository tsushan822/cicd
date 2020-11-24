<template>
    <div>
        <div class="pb-4 ">

            <div class=" px-1 cardSimiliarShadow bg-white">

                <section class="dark-grey-text px-2 ">

                    <div class="headingandbuttons  pl-2 pb-3 mt-2  py-2 borderRemoval boxShadowRemoval">
                        <div class="d-flex justify-content-between">
                            <div class=" d-flex align-items-center">
                                <div class="pageTitleAndinfo  w-100 text-left">
                                    <h6 class="  pl-1">
                                        <strong>                                    {{translate('master.User permission management')}}
                                        </strong>
                                    </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center zen_tab">

                            </div>
                            <div class="d-flex align-items-center" id="datatable-buttons">
                                <div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav ml-2 mr-2 nav-tabs" id="myClassicTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link borderRadiusRemoval active" id="create-tab-classic" data-toggle="tab"
                               href="#create"
                               role="tab"
                               aria-controls="create" aria-selected="true">{{translate('master.Create')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link borderRadiusRemoval" id="read-tab-classic" data-toggle="tab"
                               href="#read"
                               role="tab" aria-controls="read" aria-selected="false">{{translate('master.Read')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link borderRadiusRemoval" id="update-tab-classic" data-toggle="tab" href="#update"
                               role="tab"
                               aria-controls="update" aria-selected="false">{{translate('master.Update')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link borderRadiusRemoval" id="delete-tab-classic" data-toggle="tab" href="#delete"
                               role="tab"
                               aria-controls="delete" aria-selected="false">{{translate('master.Delete')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link borderRadiusRemoval" id="Other-tab-classic" data-toggle="tab" href="#Other"
                               role="tab"
                               aria-controls="update" aria-selected="false">{{translate('master.Other')}}</a>
                        </li>
                    </ul>


            <div class="classic-tabs mx-2">

                <div class="tab-content pt-0 card boxShadowRemoval pl-2 borderRemoval pt-1" id="myClassicTabContent">
                    <div class="tab-pane fade active show" id="create" role="tabpanel"
                         aria-labelledby="create-tab-classic">
                        <rolesPermissionCategory category="create"  :permissions="rolesCategoryArray[0].permisions" :roles="roles"></rolesPermissionCategory>
                    </div>
                    <div class="tab-pane  fade in show" id="read" role="tabpanel" aria-labelledby="read-tab-classic">
                        <rolesPermissionCategory category="view" :permissions="rolesCategoryArray[1].permisions" :roles="roles"></rolesPermissionCategory>

                    </div>
                    <div class="tab-pane  fade in show" id="update" role="tabpanel"
                         aria-labelledby="update-tab-classic">
                        <rolesPermissionCategory category="edit"  :permissions="rolesCategoryArray[2].permisions" :roles="roles"></rolesPermissionCategory>

                    </div>
                    <div class="tab-pane  fade in show" id="delete" role="tabpanel"
                         aria-labelledby="delete-tab-classic">
                        <rolesPermissionCategory category="deleting"  :permissions="rolesCategoryArray[3].permisions" :roles="roles"></rolesPermissionCategory>

                    </div>
                    <div class="tab-pane  fade in show" id="Other" role="tabpanel"
                         aria-labelledby="Other-tab-classic">
                        <rolesPermissionCategory category="other" :permissions="rolesCategoryArray[4].permisions" :roles="roles"></rolesPermissionCategory>

                    </div>
                </div>

            </div>
            <!-- Classic tabs -->
        </section>
            </div>
        </div>
    </div>
</template>
<script>
    import rolesPermissionCategory from '../ReportGeneration/RolesChildComponent/RolesPermissionCategory.vue'

    export default {
            components:{rolesPermissionCategory},
            data() {
            return {
                roles: [],
                permissions: [],
                rolesCategoryArray: [
                    {
                        name: 'Create',
                        permisions: []
                    },
                    {
                        name: 'View',
                        permisions: []
                    },
                    {
                        name: 'Edit',
                        permisions: []
                    },
                    {
                        name: 'Delete',
                        permisions: []
                    },
                    {
                        name: 'Other',
                        permisions: []
                    }

                ]
            }
        },
        methods: {
            permissionDataManipulation(permissions) {
                let filteredPermissions = permissions.filter(function (index) {
                    index.super = index[0];
                    index.admin = index[1];
                    index.dealer = index[2];
                    index.middle = index[3];
                    index.back = index[4];
                    index.forecaster = index[5];
                    return true;
                });
                return filteredPermissions;
            },
            setCrudPermission() {
                return new Promise(resolve => {
                    let crudPermisions = [];
                    this.rolesCategoryArray.forEach(role => {
                            if (role.name !== 'Other') {
                                role.permisions = this.permissions.filter(permission => {
                                    if (permission.label.includes(role.name)) {
                                        crudPermisions.push(permission);
                                        return true;
                                    }
                                });
                            }
                        }
                    );
                    resolve(crudPermisions);
                });
            },


            async setTabsTable() {
                const crudPermisions = await  this.setCrudPermission();
                const otherPermissionIndex=_.findIndex(this.rolesCategoryArray, { 'name': 'Other' });
                //set otherPermissions
                this.rolesCategoryArray[otherPermissionIndex].permisions=_.difference(this.permissions, crudPermisions);
            }
        },
        async created() {
            let self = this;
            axios
                .get('/getroles')
                .then(function (response) {
                    // handle success
                    self.permissions = self.permissionDataManipulation(response.data.permissions);
                    self.roles = response.data.roles;
                })
                .finally(() => this.setTabsTable())
        }
    }
</script>

<style>
    .headingandbuttons {
        margin-left: unset !important;
        margin-right: unset !important;
    }

</style>
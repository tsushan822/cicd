<template>
<div v-if="permissions.length !==0">
    <div class="table-wrapper">
        <!--Table-->
        <table class="table table-hover mb-0 table-responsive">

            <!--Table head-->
            <thead>
            <tr>
                <th>S. No.</th>
                <th>Label</th>
                <th v-for="role in roles" v-text="role.label"></th>
            </tr>
            </thead>
            <!--Table head-->

            <!--Table body-->
            <tbody>
            <tr v-for="(permission,index) in permissions">
                <td v-text="index"></td>
                <td v-text="permission.label"></td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                               v-on:change="changeRole(2, permission.id,permission.admin)"
                               v-model="permission.admin" :id="'admin'+index+category">
                        <label class="form-check-label" :for="'admin'+index+category"></label>
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                               v-on:change="changeRole(3, permission.id,permission.dealer)"
                               v-model="permission.dealer" :id="'dealer'+index+category">
                        <label class="form-check-label" :for="'dealer'+index+category"></label>
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                               v-on:change="changeRole(4, permission.id,permission.middle)"
                               v-model="permission.middle" :id="'middle'+index+category">
                        <label class="form-check-label" :for="'middle'+index+category"></label>
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                               v-on:change="changeRole(5, permission.id,permission.back)"
                               v-model="permission.back" :id="'back'+index+category">
                        <label class="form-check-label" :for="'back'+index+category"></label>
                    </div>
                </td>
            </tr>
            </tbody>
            <!--Table body-->
        </table>
        <!--Table-->
    </div>
</div>
</template>
<script>
export default {
  props:['roles','permissions','category'],
  data() {
    return {

    };
  },
  methods:{
      changeRole(role, permission, data) {
          axios
              .post(`/update/${role}/${permission}`, {
                  value: data,
              })
              .then(function (response) {
                  // handle success

              }).catch(function (error) {

          });
      }
  }
};
</script>
<template>
    <div>
        <form class="form">
          <div class="form-group">
            <label>产品线</label><select class="form-control" v-model="selectedApp">
                <option v-for="(app, i) in apps" :value="app">{{app.name}}</option>
            </select>
            </div>
          <div class="form-group">
            <label>权限</label><select class="form-control" v-model="selectedRole">
                <option v-for="(role, i) in selectedApp.roles" :value="role">{{role.display_name}}</option>
            </select>
            </div>
            <button type="submit" @click.prevent="submit" class="btn btn-primary">提交</button>
        </form>
    </div>
</template>

<script >
    export default {
        data: function () {
            return {
                apps: [],
                roles: [],
                selectedApp: {},
                selectedRole: {},
            }
        },
        methods: {
            submit: function () {
                console.log(this.selectedApp);
                this.$http.post('/api/apply', {
                    app_id: this.selectedApp.id,
                    role_id: this.selectedRole.id,
                }, {params:{alert:'提交申请'}}).then(function (res) {
                })
            }
        },
        // computed: {
        //     selectedRole: function(){
        //         if(!this.selectedApp.roles){
        //             return {};
        //         }
        //         else{
        //             return this.selectedApp.roles[0];
        //         }
        //     },
        // },
        watch: {
            selectedApp(curVal, oldVal){
                this.selectedRole = curVal.roles[0];
            },
        },
        created: function () {

            var self = this;
            $.when(this.$http.get('/api/app?with=roles')).then(function (apps, roles) {
                self.apps = apps.body.items;
                self.selectedApp = self.apps[0];
                self.selectedRole = self.selectedApp.roles[0];
            })
        }
    }
</script>

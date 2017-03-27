<template>
    <div>
        <form class="form">
          <div class="form-group">
            <label>产品线</label><select class="form-control" v-model="selectedApp">
                <option v-for="(app, i) in apps" :value="i">{{app.name}}</option>
            </select>
            </div>
          <div class="form-group">
            <label>权限</label><select class="form-control" v-model="selectedRole">
                <option v-for="(role, i) in roles" :value="i">{{role.display_name}}</option>
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
                selectedApp: null,
                selectedRole: null,
            }
        },
        methods: {
            submit: function () {
                this.$http.post('/api/apply', {
                    app_id: this.apps[this.selectedApp].id,
                    role_id: this.roles[this.selectedRole].id,
                }).then(function (res) {
                })
            }
        },
        created: function () {

            var self = this;
            $.when(this.$http.get('/api/app'), this.$http.get('/api/role')).then(function (apps, roles) {
                self.apps = apps.body.items;
                self.roles = roles.body.items;
            })
        }
    }
</script>

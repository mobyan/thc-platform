<template>
    <div class="">
        <table class="table table-bordered table-striped table-hover">
          <tbody>
            <tr class="fatal">
              <th>ID</th>
              <th>用户</th>
              <th>产品线</th>
              <th>权限</th>
              <th>操作</th>
          </tr>
          <tr v-for="(apply,i) in applies" class="">
              <td>{{ apply.id }}</td>
              <td>{{ apply.user.name }}</td>
              <td>{{ apply.app.name }}</td>
              <td>{{ apply.role.display_name }}</td>
              <td>
                <button class="btn btn-primary" @click="pass(apply.id, i)">通过</button>
                <button class="btn btn-default" @click="unpass(apply.id, i)">不通过</button>
            </td>
        </tr>
    </tbody>
</table>
</div>
</template>

<script>
    export default {
        data: function() {
            return {
                applies: [],
            }
        },
        methods: {
            pass: function(id, index) {
                this.$http.post('/api/apply/' + id + '/pass').then(function(res) {
                    this.applies.splice(index, 1);
                })
            },
            unpass: function(id, index) {
                this.$http.post('/api/apply/' + id + '/unpass').then(function(res) {
                    this.applies.splice(index, 1);
                })
            }
        },
        created: function() {
            var self = this;
            this.$http.get('/api/apply?with=user,role,app').then(function(res) {
                this.applies = res.body.items;
            })
        }
    }
</script>
<template>
    <div>
        <form>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" v-model="user.name" disabled class="form-control" id="name" placeholder="name">
        </div>
        <div class="form-group">
            <label for="type">Email</label>
            <input type="text" v-model="user.email" disabled class="form-control" id="type" placeholder="type">
        </div>
        <div class="form-group">
            <label for="type">AppId</label>
            <select class="form-control" v-model="user.app_id">
              <option v-for="app in apps" :value="app.id" >{{app.name}}</option>
          </select>
      </div>
      <button type="submit" @click.prevent="save()" class="btn btn-default">Submit</button>
  </form>
</div>
</template>
<script >
    export default {
        data : () => {
            return {
                user: {app_id:1},
                apps:[],
            }
        },
        created: function () {
            var self = this;
            $.when(this.$http.get('/api/app/'), this.$http.get('/api/user/' + this.$route.params.user)).then(function (apps, user) {
                self.apps = apps.body.items;
                self.user = user.body;
            })
        },
        methods: {
            save: function () {
                this.$http.put('/api/user/' + this.$route.params.user, {
                    app_id: this.user.app_id,
                }).then(res => {

                })
            }
        }
    }
</script>
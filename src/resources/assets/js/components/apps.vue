<template>
<div>
<div v-if="editable" style="margin-bottom: 10px;">
  <form class="form">
    <div class="form-group">
      <label>公司名称</label>
      <input :disabled="!editing" type="text" class="form-control" v-model="newApp.name">
    </div>
    <button type="submit" v-if="!editing" @click.prevent="createApp" class="btn btn-default">添加</button>
    <button type="submit" v-else @click.prevent="saveApp" class="btn btn-default">保存</button>
  </form>
</div>

<div v-if="editable" class="">
    <table class="table table-bordered table-striped table-hover">
      <tbody>
        <tr class="fatal">
          <th>id</th>
          <th>名称</th>
          <th>操作</th>
        </tr>
        <tr v-for="(ap,index) in apps" class="">
          <td>{{ ap.id }}</td>
          <td><input :disabled="!ap.editing" class="form-control" v-model="ap.name"></input></td>
          <td style="vertical-align: middle;width:33px;">
            <span v-if="!ap.editing" @click="editApp(index)"><img width="16px" height="16px" src="/image/info.png"></span>
            <span v-else @click="updateApp(index)"><img height="16px" src="/image/dashboard.png" class="signal"></span>
            <span @click="removeApp(ap, index)"><img width="16px" height="16px" src="/image/remove.png"></span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</template>

<script>
import utils from '../utils'
import bootbox from 'bootbox'
  export default {
    data: function () {
      return {
        editable: thc.can('sys_w', 0),
        editing: true,
        fillable: ['name'],
        apps: [],
        newApp: null,
      }
    },
    computed: {
      apiURI: function() {
          return '/api' + this.$route.path;
      },
    },
    created: function () {
      var self = this;
      this.createApp();
      this.$http.get('/api/app').then(function (res) {
        this.apps = res.body.items;
        this.apps = _.map(this.apps, function(app){app.editing = false; return app;});
      })
    },
    methods: {
        go: function () {
            this.$router.push({name:'station', params:{station:0}, query: {op:'create'}})
        },
        createApp: function(){
          this.newApp = {};
          this.editing = !this.editing;
        },
        editApp: function(index){
          this.apps[index].editing = !this.apps[index].editing;
          Vue.set(this.apps, index, this.apps[index]);
          //alert(this.apps[index].editing);
        },
        updateApp: function(index){
          var self = this;
          bootbox.confirm('确认更新？', function(result){
            if(result){
              self.$http.put('/api/app/'+self.apps[index].id, _.pick(self.apps[index], self.fillable), {params:{alert:'更新公司信息'}}).then(function() {
                self.editApp(index);
                });
            }
          });

        },
        removeApp: function(app, index){
          var self = this;
          bootbox.confirm('确认删除？', function(result) {
            if (result) {
                self.$http.delete('/api/app/'+app.id).then(function() {
                    self.apps.splice(index, 1);
                    //self.$router.go(0);
                })
            }
        })
        },
        saveApp: function(){
          var self = this;
          bootbox.confirm('确认添加？', function(result) {
            if (result) {
                self.$http.post('/api/app/', self.newApp, {params:{alert:"新建公司生产线"}}).then(function(res) {
                    //self.$router.go(0);
                    self.apps.push(res.body);
                })
            }
          })
          this.editing = !this.editing;
        }

    }
  }
</script>

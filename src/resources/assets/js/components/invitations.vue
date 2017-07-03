<template>
<div>
  <div v-if="regions.length > 1" style="float: right;">
    <label>当前管理地区：</label><select v-if="user" v-model="currentRegion" style="z-index: 9999; position: relative;"><option v-for="(region, index) in regions" :value="region.code">{{region.code}} - {{region.merged_name}}</option></select>&nbsp;&nbsp;&nbsp;
  </div>

  <div v-if="editable" style="margin-bottom: 10px;">
    <form class="form">
      <div class="form-group">
        <label>email</label><input :disabled="!editing" type="text" class="form-control" v-model="invite.email">
      </div>
      <div class="form-group">
          <label>地区</label>
          <select class="form-control" :disabled="!editing" v-model="invite.regioncode">
            <option v-for="reg in subRegions" :value="reg.code">{{reg.merged_name}}</option>
          </select>
      </div>
      <button type="submit" v-if="!editing" @click.prevent="createInvite" class="btn btn-default">添加</button>
      <button type="submit" v-if="editing" @click.prevent="saveInvite" class="btn btn-default">保存</button>
    </form>
  </div>

  <div class="">
    <table class="table table-bordered table-striped table-hover">
      <tbody>
        <tr class="fatal">
          <th>email</th>
          <th>邀请码</th>
          <th>地区</th>
          <th>产品线</th>
          <th>过期时间</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
        <tr v-for="invitation in invitations" class="">
          <td>{{ invitation.email }}</td>
          <td>{{ invitation.code }}</td>
          <td>{{ invitation.regioncode.merged_name }}</td>
          <td>{{ invitation.app.name }}</td>
          <td>{{ invitation.valid_till }}</td>
          <td><img height="20" :src="'/image/'+ invitation.status+'.png'" class="signal"></td>
          <td>
            <span @click="delete_invitation(invitation.id)"><img height="20" src="/image/remove.png" class="signal"></span>
            <span @click="extend_expire_data(invitation.id)"><img height="20" src="/image/dashboard.png" class="signal"></span>
          </td>
        </tr>
        <tr v-if="editable">
          <td style="text-align: right;" colspan="7">
          <button class="btn btn-primary" @click="go">添加</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</template>

<script>
  export default {
    data: function () {
      return {
        editable: thc.can('app_w'),
        editing: false,
        regions: [],
        currentRegion: null,
        subRegions:[],
        invitations: [],
        invite: null,
      }
    },
    created: function () {
      var self = this;
      this.createInvite();
      this.$http.get('/api/region').then(function(res){
        this.regions = res.body.items;
        this.currentRegion = this.regions[0];
      });
      this.$http.get('/api/sub_region?code='+this.currentRegion.code).then(function(res){
        this.subRegions = res.body.items;
      });
      this.$http.get('/api/invitation').then(function (res) {
        this.invitations = res.body.items;
      });
    },
    methods: {
      saveInvite: function(){
        this.$http.post('/api/invitation', this.invite, {params:{alert:'新建邀请码'}}).then(function (res) {
            this.editing = !this.editing;
            this.$router.push({
                name: 'station',
                params: {
                    station: res.body.id,
                }
            })
        });
      },
      createInvite: function(){
        this.invite = _.reduce(this.invite, function (carry, v) {
            carry[v] = '';
            return carry;
        }, {});
        this.editing = !this.editing;

      }
    }
  }
</script>

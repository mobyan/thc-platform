<template>
  <div>
    <div id='qlink'>
      <router-link to="/invitation">
        <img src="/image/tableg.png">
        站点列表
      </router-link>
    </div>
    <div>
      <div class="panel panel-default panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">邀请信息</h3>
        </div>
        <div class="panel-body">
          <div class="col-md-4">
            <img src="/image/noimage.jpg" id="no-image">
          </div>
          <div class="col-md-8">
            <form>
              <div class="form-group"><label>ID</label><input disabled type="text" class="form-control" v-model="invitation.id"></div>
              <div class="form-group"><label>email</label><input :disabled="!editing" type="text" class="form-control" v-model="invitation.email"></div>
              <div class="form-group"><label>邀请码</label><input disabled type="text" class="form-control" v-model="invitation.code"></div>
              <div class="form-group">
                <label>过期时间</label>
                <date-picker v-model="invitation.valid_till" :date="invitation.valid_till" :option="dp.option" :limit="limit"></date-picker>
              </div>
              <div class="form-group"><label>地区</label><input :disabled="!editing" type="text" class="form-control" v-model="invitation.regioncode.merged_name"></div>
              <div class="form-group">
                <label>权限</label><select class="form-control" v-model="invitation.role" :disabled="!editing">
                    <option v-for="(role, i) in invitation.app.roles" :value="role">{{role.display_name}}</option>
                </select>
              </div>

              <template v-if="editable">
                  <button v-if="editing" type="submit" @click.prevent="save()" class="btn btn-primary">确定</button>
                  <button v-if="editing" type="submit" @click.prevent="cancel_invitation()" class="btn btn-default" >取消</button>
                  <button v-if="!editing" type="submit" @click.prevent="editing = !editing;isCreate = false;" class="btn btn-primary">修改</button>
                  <button v-if="!editing" type="submit" @click.prevent="remove" class="btn btn-danger">删除</button>
              </template>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import bootbox from 'bootbox'
import myDatepicker from 'vue-datepicker'
import configs from '../configs'
    export default {
      data: function () {
        return {
          invitation: {},
          editing: false,
          editable: thc.can('app_w'),
          isCreate: false,
          fillable: ['email', 'type', 'location', 'lon', 'lat', 'alt'],
          dp: configs.datepicker,
          limit: [{
            type: 'fromto',
            from: '2016-01-01',
            // to: '2017-01-01',
            to: moment().add(1,'day').format('YYYY-MM-DD'),
          }],
      }
  },
  methods: {
    save: function () {
        if (this.isCreate) {
            this.$http.post('/api/invitation', this.invitation, {params:{alert:'新建邀请码'}}).then(function (res) {
                this.editing = !this.editing;
                this.$router.push({
                    name: 'invitation',
                    params: {
                        invitation: res.body.id,
                    }
                })
            });
        } else {
            this.$http.put('/api' + this.$route.path, _.pick(this.invitation, this.fillable), {params:{alert:'更新邀请码信息'}}).then(function () {
                this.editing = !this.editing;
            });
        }
    },
    create: function () {
        this.invitation = _.reduce(this.invitation, function (carry, v) {
            carry[v] = '';
            return carry;
        }, {});
        this.isCreate = true;
        this.editing = !this.editing;
    },
    cancel_invitation: function() {
      if (this.$route.params.invitation == '0') {
        this.$router.go(-1);
      }
      else{
        this.editing = !this.editing;
      }
    },
    remove: function (id) {
        var self = this;
        bootbox.confirm('确认删除？', function (result) {
            if (result) {
                self.$http.delete('/api' + self.$route.path).then(function () {
                    this.$router.push({name:'invitations'});
                })
            }
      })
    },
    load: function () {
      this.$http.get('/api/invitation/'+this.$route.params.station).then(function (res) {
        this.station = res.body;
      })
    }
  },
  watch: {
    '$route': 'load',
  },
  mounted: function () {
    if (this.$route.query.op == 'create') {
      this.create();
    } else {
      this.load();
    }
  }
}
</script>

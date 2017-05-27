<template>
  <div id="user_profile">
<!--     <div class="col-md-1"></div>
    <div class="col-sm-12"> -->
      <div class="panel panel-default panel-primary"> 
        <div class="panel-heading">
          <h3 class="panel-title">个人资料</h3>
        </div>
        <div class="panel-body">
          <div class="col-md-3">
            <div class="upic">
              <img src="/image/upic.png">
            </div>
          </div>
          <div class="col-md-9">
            <template v-if="editing">
              <div class="uinfo">
                <div class="col-md-6">
                  <form class="form">
                    <div class="form-group">
                      <label>Name:</label>
                      <input class="form-control" v-model="user_profile.name">
                    </div>
                    <div class="form-group">
                      <label>Position:</label>
                      <input type="text" class="form-control" v-model="user_profile.position">
                    </div>
                    <div class="form-group">
                      <label>Department:</label>
                      <input type="text" class="form-control" v-model="user_profile.department">
                    </div>
                    <div class="form-group">
                      <label>Institution:</label>
                      <input type="text" class="form-control" v-model="user_profile.institution">
                    </div>
                  </form>
                </div>
                <div class="col-md-6">
                  <form class="form">
                    <div class="form-group">
                      <label>Email:</label>
                      <input class="form-control" v-model="user_profile.email">
                    </div>
                    <div class="form-group">
                      <label>Cell:</label>
                      <input type="text" class="form-control" v-model="user_profile.cell">
                    </div>
                    <div class="form-group">
                      <label>Phone:</label>
                      <input type="text" class="form-control" v-model="user_profile.phone">
                    </div>
                    <div class="form-group">
                      <label>Address:</label>
                      <input type="text" class="form-control" v-model="user_profile.address">
                    </div>
                  </form>
                </div>
                <button type="submit" @click.prevent="save()" class="btn btn-success">确定</button>
                <button type="submit" @click.prevent="editing = !editing" class="btn btn-danger">取消</button>
              </div>
            </template>
            <template v-else>
              <div class="uinfo">
                <div class="col-md-5">
                  <dl>
                    <dt>Name:</dt>
                    <dd>{{ user_profile.name }}</dd>
                    <br>
                    <dt>Position:</dt>
                    <dd>{{ user_profile.position }}</dd>
                    <br>
                    <dt>Department:</dt>
                    <dd>{{ user_profile.department }}</dd>
                    <br>
                    <dt>Institution:</dt>
                    <dd>{{ user_profile.institution }}</dd>
                    <br>
                  </dl>
                </div>
                <div class="col-md-5">
                  <dl>
                    <dt>Email:</dt>
                    <dd>{{ user_profile.email }}</dd>
                    <br>
                    <dt>Cell:</dt>
                    <dd>{{ user_profile.cell }}</dd>
                    <br>
                    <dt>Phone:</dt>
                    <dd>{{ user_profile.phone }}</dd>
                    <br>
                    <dt>Address:</dt>
                    <dd>{{ user_profile.address }}</dd>
                    <br>
                  </dl>
                </div>
                <div class="col-md-2">
                    <img src="/image/tedit.png" @click.prevent="editing = !editing;" height="20">
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    <!-- </div> -->
    <!-- <div class="col-md-1"></div> -->
  </div>
</template>

<script>
import bootbox from 'bootbox'
    export default {
      data: function () {
        return {
          user_profile: {
          },
          editing: false,
          fillable: ['name', 'position', 'department', 'institution', 
                     'email', 'cell', 'phone', 'address'],
      }
  },
  methods: {
    save: function () {
      this.$http.put('/api/user_profile/' + this.user_profile.id, _.pick(this.user_profile, this.fillable), {params:{alert:'更新个人资料'}}).then(function () {
                this.editing = !this.editing;
            }
      );
    },
    get_user_profile: function(){
        var self = this;
        this.$http.get('/api/user_profile').then(function(res){
          self.user_profile = res.body.user_profile;
        })
      },
  },
  created: function()
    {
      this.get_user_profile();
    },
}
</script>
<template>
  <div id="user_profile">
      <div class="panel panel-default panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">个人资料</h3>
        </div>
        <div class="panel-body">
          <div class="col-md-3 col-sm-12">
            <template v-if="!editing">
              <div class="upic">
                <img :src="user_profile.avatar_url">
              </div>
            </template>
            <template v-if="editing">
              <dropzone id="userAvatar" url="/api/avatar" @vdropzone-success="showSuccess" :dropzone-options="customOptionsObject" v-bind:use-custom-dropzone-options="true">
                <input type="hidden" name="token" value="user">
              </dropzone>
            </template>
          </div>
          <div class="col-md-9">
            <template v-if="editing">
              <div class="uinfo">
                <div class="col-md-6">
                  <form class="form">
                    <div class="form-group">
                      <label>名称</label>
                      <input class="form-control" v-model="user_profile.name">
                    </div>
                    <div class="form-group">
                      <label>职位</label>
                      <input type="text" class="form-control" v-model="user_profile.position">
                    </div>
                    <div class="form-group">
                      <label>部门</label>
                      <input type="text" class="form-control" v-model="user_profile.department">
                    </div>
                    <div class="form-group">
                      <label>公司</label>
                      <input type="text" class="form-control" v-model="user_profile.institution">
                    </div>
                  </form>
                </div>
                <div class="col-md-6">
                  <form class="form">
                    <div class="form-group">
                      <label>邮箱</label>
                      <input class="form-control" v-model="user_profile.email">
                    </div>
                    <div class="form-group">
                      <label>座机</label>
                      <input type="text" class="form-control" v-model="user_profile.cell">
                    </div>
                    <div class="form-group">
                      <label>手机</label>
                      <input type="text" class="form-control" v-model="user_profile.phone">
                    </div>
                    <div class="form-group">
                      <label>通讯地址</label>
                      <input type="text" class="form-control" v-model="user_profile.address">
                    </div>
                  </form>
                </div>
                <button type="submit" @click.prevent="save()" class="btn btn-success">确定</button>
                <button type="submit" @click.prevent="editing_switch()" class="btn btn-danger">取消</button>
              </div>
            </template>
            <template v-else>
              <div class="uinfo">
                <div class="col-md-5">
                  <dl>
                    <dt>名称:</dt>
                    <dd>{{ user_profile.name }}</dd>
                    <br>
                    <dt>职位:</dt>
                    <dd>{{ user_profile.position }}</dd>
                    <br>
                    <dt>部门:</dt>
                    <dd>{{ user_profile.department }}</dd>
                    <br>
                    <dt>公司:</dt>
                    <dd>{{ user_profile.institution }}</dd>
                    <br>
                  </dl>
                </div>
                <div class="col-md-5">
                  <dl>
                    <dt>邮箱:</dt>
                    <dd>{{ user_profile.email }}</dd>
                    <br>
                    <dt>座机:</dt>
                    <dd>{{ user_profile.cell }}</dd>
                    <br>
                    <dt>手机:</dt>
                    <dd>{{ user_profile.phone }}</dd>
                    <br>
                    <dt>通讯地址:</dt>
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
  </div>
</template>

<script>
import bootbox from 'bootbox'
import Dropzone from 'vue2-dropzone'
    export default {
      components: {
        Dropzone,
      },
      data: function () {
        return {
          user_profile: {
          },
          editing: false,
          customOptionsObject: {
            maxNumberOfFiles: 1,
            autoProcessQueue: true,
            maxFileSizeInMB: 2,
            acceptedFileTypes: 'image/jpeg,image/jpg,image/png',
            resizeWidth: 200,
            resizeHeight: 200,
            resizeQuality: 100,
            resizeMethod: 'crop',
            // resizeMimeType: 'image/jpg',
            language: {
              dictFileTooBig: '上传文件过大({{filesize}}MiB) 文件大小限制: {{maxFilesize}}MiB',
              dictInvalidFileType: '非法上传文件类型',
              dictCancelUpload: '取消上传',
              dictCancelUploadConfirmation: '确定要取消上传',
              dictDefaultMessage: '拖拽或点击上传新头像',
              dictRemoveFile: '删除文件',
              dictMaxFilesExceeded: '达到上传数量上限',
            },
          },
          fillable: ['name', 'position', 'department', 'institution', 
                     'email', 'cell', 'phone', 'address'],
      }
  },
  methods: {
    save: function () {
      var self = this;
      this.$http.put('/api/user_profile/' + this.user_profile.id, _.pick(this.user_profile, this.fillable), {params:{alert:'更新个人资料'}}).then( function(){
          self.editing = !self.editing;
          self.$http.get('/api/user_profile').then(function(res){
            self.user_profile = res.body.user_profile;
          })
        }
      );
    },
    get_user_profile: function(){
      var self = this;
      this.$http.get('/api/user_profile').then(function(res){
        self.user_profile = res.body.user_profile;
      })
    },
    showSuccess(file) {
      // console.log('A file was successfully uploaded');
    },
    editing_switch() {
      this.editing = !this.editing;
      // this.$router.go(0);
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

<template>
  <div>
    <div id='qlink'>
      <router-link :to="dashboard_url">
        <img src="/image/dashboardg.png">
        Dashboard
      </router-link>
      <router-link to="/station">
        <img src="/image/tableg.png">
        站点列表
      </router-link>
    </div>
    <div>
      <div class="panel panel-default panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">基本信息</h3>
        </div>
        <div class="panel-body">
          <template v-if="!editing">
            <div class="col-md-4">
              <img :src="station.avatar_url" id="no-image">
            </div>
          </template>
          <template v-else>
            <div class="col-md-4">
              <dropzone id="avatarDropzone" :url="avatar_push_url" @vdropzone-success="showSuccess" :dropzone-options="customOptionsObject" v-bind:use-custom-dropzone-options="true">
                <input type="hidden" name="token" value="station">
              </dropzone>
            </div>
          </template>
          <div class="col-md-8">
            <form>
              <div class="form-group"><label>ID</label><input disabled type="text" class="form-control" v-model="station.id"></div>
              <div class="form-group"><label>名称</label><input :disabled="!editing" type="text" class="form-control" v-model="station.name"></div>
              <div class="form-group"><label>类型</label><input :disabled="!editing" type="text" class="form-control" v-model="station.type"></div>
              <div class="form-group"><label>地址</label><input :disabled="!editing" type="text" class="form-control" v-model="station.location"></div>
              <div class="form-group"><label>纬度</label><input :disabled="!editing" type="text" class="form-control" v-model="station.lat"></div>
              <div class="form-group"><label>经度</label><input :disabled="!editing" type="text" class="form-control" v-model="station.lon"></div>
              <div class="form-group"><label>高度</label><input :disabled="!editing" type="text" class="form-control" v-model="station.alt"></div>
              <div class="form-group"><label>状态</label><input disabled type="text" class="form-control" v-model="station.status"></div>
              <template v-if="editable">
                  <button v-if="editing" type="submit" @click.prevent="save()" class="btn btn-primary">确定</button>
                  <button v-if="editing" type="submit" @click.prevent="cancel_station()" class="btn btn-default" >取消</button>
                  <button v-if="!editing" type="submit" @click.prevent="editing = !editing;isCreate = false;" class="btn btn-primary">修改</button>
                  <!-- <button v-if="!editing" type="submit" @click.prevent="create" class="btn btn-default">创建</button> -->
                  <button v-if="!editing" type="submit" @click.prevent="remove" class="btn btn-danger">删除</button>
              </template>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
      <div v-if="station.id" class="panel panel-default panel-primary">
        <div class="panel-heading" >
          <h3 class="panel-title">设备列表</h3>
        </div>
        <div class="panel-body">
          <router-view></router-view>
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
          station: {},
          editing: false,
          editable: thc.can('app_w'),
          isCreate: false,
          fillable: ['name', 'type', 'location', 'lon', 'lat', 'alt'],
          dashboard_url: '/station/'+this.$route.params.station + '/dashboard',
          avatar_push_url: '/api/avatar?station_id='+this.$route.params.station,
          customOptionsObject: {
            maxNumberOfFiles: 1,
            autoProcessQueue: true,
            maxFileSizeInMB: 3,
            acceptedFileTypes: 'image/jpeg,image/jpg,image/png',
            resizeWidth: 350,
            resizeHeight: 350,
            resizeQuality: 100,
            resizeMethod: 'crop',
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
      }
  },
  methods: {
    save: function () {
        this.station.app_id = thc.user.app_id;
        if (this.isCreate) {
            this.$http.post('/api/station', this.station, {params:{alert:'新建站点'}}).then(function (res) {
                this.editing = !this.editing;
                this.$router.push({
                    name: 'station',
                    params: {
                        station: res.body.id,
                    }
                })
            });
        } else {
            this.$http.put('/api' + this.$route.path, _.pick(this.station, this.fillable), {params:{alert:'更新站点信息'}}).then(function () {
                this.editing = !this.editing;
            });
        }
    },
    create: function () {
        this.station = _.reduce(this.station, function (carry, v) {
            carry[v] = '';
            return carry;
        }, {});
        this.isCreate = true;
        this.editing = !this.editing;
    },
    cancel_station: function() {
      if (this.$route.params.station == '0') {
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
                    this.$router.push({name:'stations'});
                })
            }
      })
    },
    load: function () {
      this.$http.get('/api/station/'+this.$route.params.station).then(function (res) {
        this.station = res.body;
      })
    },
    showSuccess(file) {
      // console.log('A file was successfully uploaded');
    },
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

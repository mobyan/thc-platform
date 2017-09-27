<template>
    <div>
        <div id='qlink'>
            <router-link to="/admin/station">
                <img src="/image/tableg.png"> 站点列表
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
                        <div class="col-md-3">
                            <dropzone id="stationAvatar" :url='avatar_push_url' @vdropzone-success="showSuccess" :dropzone-options="customOptionsObject" v-bind:use-custom-dropzone-options="true">
                                <input type="hidden" name="token" value="station">
                            </dropzone>
                        </div>
                    </template>
                    <div class="col-md-4 col-xs-12">
                        <form>
                            <div class="form-group">
                                <label>产品线</label>
                                <select v-model="station.app_id" style="z-index: 9999; position: relative;" :disabled="!editing">
                                    <option v-for="(app, index) in apps" :value="app.id">{{app.id}} - {{app.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>名称</label>
                                <input :disabled="!editing" type="text" class="form-control" v-model="station.name">
                            </div>
                            <div class="form-group">
                                <label>地址</label>
                                <input :disabled="!editing" type="text" class="form-control" v-model="station.location">
                            </div>
                            <div class="form-group">
                                <label>纬度</label>
                                <input :disabled="!editing" type="text" class="form-control" v-model="station.lat">
                            </div>
                            <div class="form-group">
                                <label>经度</label>
                                <input :disabled="!editing" type="text" class="form-control" v-model="station.lon">
                            </div>
                            <div class="form-group">
                                <label>高度</label>
                                <input :disabled="!editing" type="text" class="form-control" v-model="station.alt">
                            </div>
                            <div class="form-group">
                                <label>区划</label>
                                <!--                                 <div v-if="!editing" class="input-group">
                                    <code-view :search="station.bcode" :editing="editing"></code-view>
                                </div>
                                <div v-if="editing" class="input-group">
                                    <code-linkage-view @codeChanged="onCodeUpdate"></code-linkage-view>
                                </div> -->
                                <input v-if="!editing" :disabled="!editing" type="text" class="form-control" v-model="station.bcode.merged_name">
                                <code-linkage-view v-if="editing" @codeChanged="onCodeUpdate"></code-linkage-view>
                            </div>
                            <div class="form-group">
                                <label>状态</label>
                                <input disabled type="text" class="form-control" v-model="station.status">
                            </div>
                            <template v-if="editable">
                                <button v-if="editing" type="submit" @click.prevent="save()" class="btn btn-primary">{{ buttonHint }}</button>
                                <button v-if="editing" type="submit" @click.prevent="cancel_station()" class="btn btn-default">取消</button>
                                <button v-if="!editing" type="submit" @click.prevent="editing = !editing;isCreate = false;" class="btn btn-primary">修改</button>
                                <button v-if="!editing" type="submit" @click.prevent="remove" class="btn btn-danger">删除</button>
                            </template>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
            <div v-if="station.id" class="panel panel-default panel-primary">
                <div class="panel-heading">
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
import code_linkage_view from './code_linkage_view.vue'
import code_view from './code_view.vue'
import Dropzone from 'vue2-dropzone'
export default {
    data: function() {
        return {
            station: { bcode: { merged_name: "" } },
            apps: [],
            editing: false,
            editable: thc.can('sys_w', 0),
            isCreate: false,
            fillable: ['name', 'location', 'lon', 'lat', 'alt', 'app_id', 'code'],
            dashboard_url: '/station/' + this.$route.params.station + '/dashboard',
            avatar_push_url: '/api/avatar?station_id=' + this.$route.params.station,
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
            code: null,
            buttonHint: "确定",
        }
    },
    components: {
        'code-view': code_view,
        'code-linkage-view': code_linkage_view,
        Dropzone,
    },
    methods: {
        // onCodeUpdate: function(data) {
        //     console.log(data);
        //     this.station.code = data.code;
        //     this.station.bcode = data;
        // },
        onCodeUpdate: function(data) {
            // console.log(data);
            this.code = data;
        },
        get: function() {
            this.$http.get('/api/code/search?content=' + this.station.code.merged_name).then(function(res) {
                this.codes = res.body;
                this.isShow = !this.isShow;
            });
        },
        save: function() {
            // if (this.isCreate) {
            //     this.$http.post('/api/station', this.station, { params: { alert: '新建站点' } }).then(function(res) {
            //         this.editing = !this.editing;
            //         this.$router.push({
            //             name: 'admin-station',
            //             params: {
            //                 station: res.body.id,
            //             }
            //         })
            //     });
            // } else {
            //     var self = this;
            //     this.$http.put('/api/station/' + this.station.id, _.pick(this.station, this.fillable), { params: { alert: '更新站点信息' } }).then(function() {
            //         self.editing = !self.editing;
            //         self.$http.get('/api/station/' + self.$route.params.station + '?with=bcode').then(function(res) {
            //             self.station = res.body;
            //         });
            //     });
            // }
            if (this.code != null) {
                this.buttonHint = "上传中";
                var self = this;
                this.$http.get('/api/code/' + this.code.id + '?with=roles').then(function(res) {
                    self.station.code = res.body.code;
                    self.station.bcode = res.body;
                    if (self.isCreate) {
                        self.$http.post('/api/station', self.station, { params: { alert: '新建站点' } }).then(function(res) {
                            self.buttonHint = "确定";
                            self.code = null;
                            self.editing = !self.editing;
                            self.$router.push({
                                name: 'admin-station',
                                params: {
                                    station: res.body.id,
                                }
                            })
                        });
                    } else {
                        self.$http.put('/api/station/' + self.station.id, _.pick(self.station, self.fillable), { params: { alert: '更新站点信息' } }).then(function() {
                            self.buttonHint = "确定";
                            self.code = null;
                            self.editing = !self.editing;
                            self.$http.get('/api/station/' + self.$route.params.station + '?with=bcode').then(function(res) {
                                self.station = res.body;
                            });
                        });
                    }
                });
            }
        },
        create: function() {
            this.station = _.reduce(this.station, function(carry, v) {
                carry[v] = '';
                return carry;
            }, {});
            this.isCreate = true;
            this.editing = !this.editing;
        },
        cancel_station: function() {
            if (this.$route.params.station == '0') {
                this.$router.go(-1);
            } else {
                this.buttonHint = "确定";
                this.code = null;
                this.editing = !this.editing;
                var self = this;
                this.$http.get('/api/station/' + this.$route.params.station + '?with=bcode').then(function(res) {
                    self.station = res.body;
                });
            }
        },
        remove: function(id) {
            var self = this;
            bootbox.confirm('确认删除？', function(result) {
                if (result) {
                    self.$http.delete('/api' + self.$route.path).then(function() {
                        this.$router.push({ name: 'stations' });
                    })
                }
            })
        },
        load: function() {
            if (this.$route.params.station == 0) {
                return;
            } else {
                this.$http.get('/api/station/' + this.$route.params.station + '?with=bcode').then(function(res) {
                    this.station = res.body;
                })
            }
        },
        showSuccess(file) {
            // console.log('A file was successfully uploaded');
        },
    },
    created: function() {
        var self = this;
        this.$http.get('/api/app').then(function(res) {
            self.apps = res.body;
            //console.log(self.apps);
        });
    },
    watch: {
        '$route': 'load',
    },
    mounted: function() {
        if (this.$route.query.op == 'create') {
            this.create();
        } else {
            this.load();
        }
    }
}
</script>
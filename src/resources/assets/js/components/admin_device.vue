<template>
<div v-if="device">
    <div id='qlink'>
      <router-link :to="devices_url">
        <img src="/image/tableg.png">
        设备列表
      </router-link>
    </div>
<!-- 设备基本信息 -->
    <div class="panel panel-default panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title">基本信息</h3>
        </div>
        <div class="panel-body">
            <form>
                <div class="form-group">
                    <label for="name">名称</label>
                    <input :disabled="!editing" type="text" v-model="device.name" class="form-control" id="name" placeholder="名称">
                </div>
                <div class="form-group">
                    <label for="type">类型</label>
                    <input :disabled="!editing" type="text" v-model="device.type" class="form-control" id="type" placeholder="类型">
                </div>
                <div class="form-group">
                    <label for="nacompanyme">公司</label>
                    <input :disabled="!editing" type="text" v-model="device.company" class="form-control" id="company" placeholder="公司">
                </div>
                <div class="form-group">
                    <label for="model">观测对象</label>
                    <input :disabled="!editing" type="text" v-model="device.model" class="form-control" id="model" placeholder="观测对象">
                </div>
                <div class="form-group">
                    <label for="sn">序列号</label>
                    <input :disabled="!editing" type="text" v-model="device.sn" class="form-control" id="sn" placeholder="sn">
                </div>
                <div class="form-group">
                    <label for="iccid">iccid</label>
                    <input :disabled="!editing" type="text" v-model="device.iccid" class="form-control" id="iccid" placeholder="iccid">
                </div>
                <div class="form-group">
                    <label for="version">版本号</label>
                    <input :disabled="!editing" type="text" v-model="device.version" class="form-control" id="version" placeholder="version">
                </div>
                <template v-if="editable">
                    <button v-if="editing" type="submit" @click.prevent="save()" class="btn btn-primary">确定</button>
                    <button v-if="editing" type="submit" @click.prevent="cancel_device()" class="btn btn-default">取消</button>
                    <button v-if="!editing" type="submit" @click.prevent="editing = !editing;isCreate = false;" class="btn btn-primary">修改</button>
                    <!-- <button v-if="!editing" type="submit" @click.prevent="create" class="btn btn-default">创建</button> -->
                    <button v-if="!editing" type="submit" @click.prevent="remove" class="btn btn-danger">删除</button>
                </template>
            </form>
        </div>
    </div>
<!-- 设备配置 -->
    <div v-if="device.id" class="panel panel-default panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title">配置</h3>
        </div>
        <div class="panel-body">
            <form>
                <div class="form-group">
                </div>
                <div class="form-group">
                    <label for="data">采集数据信息</label>
                    <div style="overflow:auto">
                        <table v-if="activeConfig" class="table table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>名称</th>
                                    <th>端口</th>
                                    <th>传感器</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                                <tr v-for="(v,k) in activeConfig.data">
                                    <template v-if="v !== null">
                                        <td>{{k}}</td>
                                        <td><select class="form-control" :disabled="!editing_config" v-model="activeConfig.data[k].port">
                                            <option v-for="port in ports" :value="port">{{port}}</option>
                                        </select></td>
                                        <td>
                                            <select :disabled="!editing_config" v-model="activeConfig.data[k].sensor_type" class="form-control">
                                                <option v-for="sensor in sensors" :value="sensor.name">{{ sensor.desc + ': ' + sensor.name}}</option>
                                            </select>
                                        </td>
                                        <td><input type="text" :disabled="!editing_config" v-model="activeConfig.data[k].desc" class="form-control" :id="k" :placeholder="k" ></td>
                                        <td style="vertical-align: middle;"><div v-if="editing_config" @click="removeData('data', k)"><img width="16px" height="16px" src="/image/remove.png"></div></td>

                                    </template>
                                </tr>
                                <tr><td colspan="8">
                                    <div style="text-align: right;" ><img v-if="editing_config" @click="addDataConfig('data')" width="16px" height="16px" src="/image/add.png"></div>
                                </td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label for="control">控制参数信息</label>
                    <div style="overflow:auto">
                        <table v-if="activeConfig" class="table table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>名称</th>
                                    <th>分</th>
                                    <th>时</th>
                                    <th>日</th>
                                    <th>月</th>
                                    <th>周</th>
                                    <th>操作</th>
                                </tr>
                                <tr v-for="(v,k) in activeConfig.control">
                                    <td>{{k}}</td>
                                    <td v-for="(v, key) in activeConfig.control[k]" ><input :disabled="!editing_config" type="text" class="form-control" name="" v-model="activeConfig.control[k][key]"></td>
                                    <td style="vertical-align: middle;width:33px;"><div v-if="editing_config" @click="removeData('control', k)"><img width="16px" height="16px" src="/image/remove.png"></div></td>

                                </tr>
                                <tr><td colspan="7">
                                    <div style="text-align: right;" ><img v-if="editing_config" @click="addDataConfig('control')" width="16px" height="16px" src="/image/add.png"></div>
                                </td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <template v-if="editable">
                    <button type="submit" v-if="editing_config" @click.prevent="addConfig()" class="btn btn-default btn-primary">确认</button>
                    <button type="submit" v-if="editing_config" @click.prevent="editing_config = !editing_config" class="btn btn-default btn-default">取消</button>
                    <button type="submit" v-if="!editing_config" @click.prevent="editing_config = !editing_config" class="btn btn-default btn-primary">修改</button>
                </template>
            </form>
        </div>
    </div>
</div>
</template>

<script >
import sensors from '../configs/sensors'
import ports from '../configs/ports'
import utils from '../utils'
import bootbox from 'bootbox'
export default {
    data: function() {
        return {
            device: null,
            sensors,
            ports,
            editing: false,
            editing_config: false,
            editable: thc.can('app_w')||thc.can('sys_w', 0),
            isCreate: false,
            fillable: ['name', 'type', 'company', 'model', 'sn', 'version', 'iccid'],
            dashboard_url: '/station/'+this.$route.params.station + '/dashboard',
        };
    },
    computed: {
        devices_url: function(){
            return '/admin/station/'+this.$route.params.station;
        },
        isAdmin: function(){
            return thc.can('sys_w',0);
        },
        activeConfig: function() {
            var res = _.last(this.device.configs);
            if (res) {
                res.control = _.reduce(res.control, function(carry, v, k) {
                    if (_.isObject(v)) {
                        carry[k] = v;
                        return carry;
                    }
                    var job = _.split(v, ' ');
                    carry[k] = {
                        minute: job[0],
                        hour: job[1],
                        day: job[2],
                        month: job[3],
                        week: job[4],
                    }
                    return carry;
                }, {})
            }
            return res;
        },
        apiURI: function() {
            return '/api/station/'+this.$route.params.station+'/device/'+this.$route.params.device;
            //return '/api' + this.$route.path;
        },
    },
    created: function() {
        if (this.$route.query.op == 'create') {
            this.create();
        } else {
            this.load();
        }
    },
    watch: {
        '$route': 'load',
    },
    methods: {
        load: function() {
            this.$http.get(this.apiURI + '?with=configs').then(function(res) {
                if (res.body.configs.length == 0) {
                    res.body.configs.push({data:{},control:{}});
                }
                this.device = res.body;
            })
        },
        update: function() {
            this.$http.put(this.apiURI, _.pick(this.device, this.fillable), {params:{alert:'更新设备信息'}}).then(function() {
                this.editing = !this.editing;
            });
        },
        cancel_device: function() {
            if(this.$route.params.device == '0'){
                this.$router.go(-1);
            }
            else{
                this.editing = !this.editing;
            }
        },
        save: function() {
            if (this.isCreate) {
                this.$http.post('/api/station/' + this.$route.params.station + '/device', this.device, {params:{alert:'修改设备信息'}}).then(function(res) {
                    this.editing = !this.editing;
                    this.$router.push({
                        name: 'device',
                        params: {
                            station: this.$route.params.station,
                            device: res.body.id,
                        }
                    })
                })
            } else {
                this.update();
            }
        },
        remove: function() {
            var self = this;
            bootbox.confirm('确认删除？', function(result) {
                if (result) {
                    self.$http.delete(self.apiURI).then(function() {
                      self.$router.push({
                          name: 'admin-station',
                          params: {
                              station: self.$route.params.station,
                          }
                      });

                    })
                }
            })
        },
        create: function() {
            this.device = _.reduce(this.device, function(carry, v) {
                carry[v] = '';
                return carry;
            }, {});
            this.isCreate = true;
            this.editing = !this.editing;
        },
        addConfig: function() {
            var self = this;
            var data = _.reduce(this.activeConfig.data, function(res, v, k) {
                var sensor = _.find(sensors, {
                    name: v.sensor_type
                });
                v.type = sensor.type;
                v.unit = sensor.unit;
                v.max_v = sensor.max_v;
                v.min_v = sensor.min_v;
                res[k] = v;
                return res;
            }, {})
            var control = _.reduce(this.activeConfig.control, function(res, v, k) {
                res[k] = _.join([v.minute || '*', v.hour || '*', v.day || '*', v.month || '*', v.week || '*'], ' ');
                return res;
            }, {});
            var body = {
                data,
                control: control,
            }
            this.$http.post(this.apiURI + '/config', body, {params:{alert:'保存设备配置'}}).then(function(res) {
                this.device.configs.push(res.body)
                this.editing_config = !this.editing_config
            })
        },
        removeData: function(type, k) {
            Vue.delete(this.activeConfig[type], k);
        },
        addDataConfig: function(type) {
            var self = this;
            bootbox.prompt("输入配置项名称：", function(result) {
                if (!result || self.activeConfig[type][result]) return;
                Vue.set(self.activeConfig[type], result, type == 'data' ? {
                    type: '',
                    unit: '',
                    port: '',
                    max_v: '',
                    min_v: '',
                    desc: '',
                } : {
                    minute: '*',
                    hour: '*',
                    day: '*',
                    month: '*',
                    week: '*'
                });
            });
        }
    }
}
</script>

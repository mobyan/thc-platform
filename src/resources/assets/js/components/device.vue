<template>
  <div>
    <div class="panel panel-default panel-primary">
      <div class="panel-heading" >
        <h3 class="panel-title">基本信息</h3>
      </div>
      <div class="panel-body">
        <form>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" v-model="device.name" class="form-control" id="name" placeholder="name">
          </div>
          <div class="form-group">
            <label for="type">type</label>
            <input type="text" v-model="device.type" class="form-control" id="type" placeholder="type">
          </div>
          <button type="submit"  @click.prevent="save()" class="btn btn-default btn-primary">Submit</button>
        </form>
      </div>
    </div>

    <div class="panel panel-default panel-primary">
      <div class="panel-heading" >
        <h3 class="panel-title">配置</h3>
      </div>
      <div class="panel-body">
        <form>
          <div class="form-group">
<!--             <label for="version">Version</label>
            <input type="text" v-model="activeConfig.id" class="form-control" id="version" placeholder="version" disabled> -->

          </div>
          <div class="form-group">
            <label for="data">Data</label>
            <table class="table table-bordered table-striped table-hover">
              <tbody>
                <tr>
                  <th>名称</th>
                  <th>端口</th>
                  <!-- <th>类型</th> -->
                  <!-- <th>单位</th> -->
                  <th>传感器</th>
                  <th>备注</th>
                  <th>操作</th>
                </tr>
                <tr v-for="(v,k) in activeConfig.data">
                  <template v-if="v !== null">
                    <td>{{k}}</td>
                    <td><select class="form-control" v-model="activeConfig.data[k].port">
                      <option v-for="port in ports" :value="port">{{port}}</option>
                    </select></td>
                    <!-- <td><input type="text" v-model="activeConfig.data[k].port" class="form-control" :id="k" :placeholder="k" ></td> -->
                    <!-- <td><input type="text" v-model="activeConfig.data[k].type" class="form-control" :id="k" :placeholder="k" ></td> -->
                    <!-- <td><input type="text" v-model="activeConfig.data[k].unit" class="form-control" :id="k" :placeholder="k" ></td> -->
                    <td>
                      <select v-model="activeConfig.data[k].sensor_type" class="form-control">
                        <option v-for="sensor in sensors" :value="sensor.name">{{ sensor.desc + ': ' + sensor.name}}</option>
                      </select>
                    </td>
                    <td><input type="text" v-model="activeConfig.data[k].desc" class="form-control" :id="k" :placeholder="k" ></td>
                    <td style="vertical-align: middle;"><div @click="removeData('data', k)"><img width="16px" height="16px" src="/image/remove.png"></div></td>

                  </template>
                </tr>
                <tr><td colspan="8">
                  <div style="text-align: right;" ><img @click="addDataConfig('data')" width="16px" height="16px" src="/image/add.png"></div>
                </td></tr>
              </tbody>
            </table>

          </div>
          <div class="form-group">
            <label for="control">Controller</label>
            <table class="table table-bordered table-striped table-hover">
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
                  <!-- <td><input type="text" v-model="activeConfig.control[k]" class="form-control" :id="k" :placeholder="k" ></td> -->
                  <td v-for="(v, key) in activeConfig.control[k]" ><input type="text" class="form-control" name="" v-model="activeConfig.control[k][key]"></td>
                  <td style="vertical-align: middle;width:33px;"><div @click="removeData('control', k)"><img width="16px" height="16px" src="/image/remove.png"></div></td>

                </tr>
                <tr><td colspan="7">
                  <div style="text-align: right;" ><img @click="addDataConfig('control')" width="16px" height="16px" src="/image/add.png"></div>
                </td></tr>
              </tbody>
            </table>

          </div>
          <button type="submit" @click.prevent="addConfig()" class="btn btn-default btn-primary">Submit</button>
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
    data: function () {
      return {
        device: {},
        sensors,
        ports,
      };
    },
    computed: {
      activeConfig: function () {
        var res = _.last(this.device.configs);
        if (res) {
          if (res.data.length == 0) {
            res.data = {};
          }
          if (res.control.length == 0) {
            res.control = {};
          }
          res.control = _.reduce(res.control, function(carry, v,k) {
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
        return res || {};
      }
    },
    created: function () {
      var self = this;
      var deviceId = this.$route.params.device;
      this.$http.get(this.apiURI() +  '?with=configs').then(function (res) {
        this.device = res.body;
        console.log(this.device)
      })
    },
    methods: {
      apiURI: function () {
        return '/api' + this.$route.path ;
      },
      save: function () {
        this.$http.put(this.apiURI(),{
            name: this.device.name,
            type: this.device.type,
          }).then(()=>{});
      },
      addConfig: function() {
        var self = this;
        var data = _.reduce(this.activeConfig.data, function (res, v, k) {
          var sensor = _.find(sensors, {name:v.sensor_type});
          v.type = sensor.type;
          v.unit = sensor.unit;
          res[k] = v;
          return res;
        }, {})
        var control = _.reduce(this.activeConfig.control, function (res, v, k) {
          res[k] = _.join([v.minute||'*', v.hour||'*', v.day||'*', v.month||'*', v.week||'*'], ' ');
          return res;
        }, {});
        var body = {
          data,
          control: control,
        }
        this.$http.post(this.apiURI()+'/config', body).then(function (res) {
          this.device.configs.push(res.body)
          utils.alert('success' , '保存设备配置成功');
        })
      },
      removeData: function (type, k) {
        // this.device.configs[this.device.configs.length - 1].data[k] = null;
        // this.activeConfig.data[k] = null;
        Vue.delete(this.activeConfig[type], k);
      },
      addDataConfig: function (type) {
        var key = 'new';
        // do {
        //   key = 'new_' + _.random(1,100);
        // } while(key in this.activeConfig[type])
        // 
        var self = this;
        bootbox.prompt("输入配置项名称：", function(result){ 
          if (!result || self.activeConfig[type][result]) return;

          Vue.set(self.activeConfig[type], result, type == 'data' ? {
            type: '',
            unit: '',
            port: '',
            max_v: '',
            min_v: '',
            desc: '',
          } : {minute: '*', hour: '*', day: '*', month: '*', week: '*'});
        });
      }
    }
  }
</script>
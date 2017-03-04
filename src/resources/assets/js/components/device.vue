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
          <button type="submit" @click.prevent="save()" class="btn btn-default">Submit</button>
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
            <label for="version">Version</label>
            <input type="text" v-model="activeConfig.id" class="form-control" id="version" placeholder="version" disabled>

          </div>
          <div class="form-group">
            <label for="data">Data</label>
            <table class="table table-bordered table-striped table-hover">
              <tbody>
                <tr>
                  <th>名称</th>
                  <th>类型</th>
                  <th>端口</th>
                  <th>单位</th>
                  <th>Max</th>
                  <th>Min</th>
                  <th>备注</th>
                  <th>操作</th>
                </tr>
                <tr v-for="(v,k) in activeConfig.data">
                  <template v-if="v !== null">
                    <td><input type="text" :value="k" class="form-control" :id="k" :placeholder="k" ></td>
                    <td><input type="text" v-model="activeConfig.data[k].type" class="form-control" :id="k" :placeholder="k" ></td>
                    <td><input type="text" v-model="activeConfig.data[k].port" class="form-control" :id="k" :placeholder="k" ></td>
                    <td><input type="text" v-model="activeConfig.data[k].unit" class="form-control" :id="k" :placeholder="k" ></td>
                    <td><input type="text" v-model="activeConfig.data[k].max_v" class="form-control" :id="k" :placeholder="k" ></td>
                    <td><input type="text" v-model="activeConfig.data[k].min_v" class="form-control" :id="k" :placeholder="k" ></td>
                    <td><input type="text" v-model="activeConfig.data[k].desc" class="form-control" :id="k" :placeholder="k" ></td>
                    <td style="vertical-align: middle;"><div @click="removeData('data', k)"><img width="16px" height="16px" src="/image/remove.png"></div></td>

                  </template>
                </tr>
              </tbody>
            </table>
            <div style="text-align: right;" ><img @click="addDataConfig('data')" width="16px" height="16px" src="/image/add.png"></div>

          </div>
          <div class="form-group">
            <label for="control">Controller</label>
            <table class="table table-bordered table-striped table-hover">
              <tbody>
                <tr><th>名称</th><th>设置</th><th>操作</th></tr>
                <tr v-for="(v,k) in activeConfig.control">
                  <td><input type="text" :value="k" class="form-control" :id="k" :placeholder="k" ></td>
                  <td><input type="text" v-model="activeConfig.control[k]" class="form-control" :id="k" :placeholder="k" ></td>
                  <td style="vertical-align: middle;"><div @click="removeData('control', k)"><img width="16px" height="16px" src="/image/remove.png"></div></td>

                </tr>
              </tbody>
            </table>
            <div style="text-align: right;" ><img @click="addDataConfig('control')" width="16px" height="16px" src="/image/add.png"></div>

          </div>
          <button type="submit" @click.prevent="addConfig()" class="btn btn-default">Submit</button>
        </form>    
      </div>
    </div>
  </div>
</template>

<script >
  export default {
    data: function () {
      return {
        device: {},
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
        } 
        return res || {};
      }
    },
    created: function () {
      var self = this;
      var deviceId = this.$route.params.device;
      $.get(this.apiURI() +  '?with=configs', function (device) {
        self.device = device;
      })
    },
    methods: {
      apiURI: function () {
        return '/api' + this.$route.path ;
      },
      save: function () {
        $.ajax({
          url: this.apiURI(),
          method: 'put',
          data: {
            name: this.device.name,
            type: this.device.type,
          },
          success: function (data, res) {
            console.log(res)
          }
        })
      },
      addConfig: function() {
        var body = {
          data: this.activeConfig.data,
          control: this.activeConfig.control,
        }
        this.$http.post(this.apiURI()+'/config', body).then(function (res) {
          this.device.configs.push(res.body)
        })
      },
      removeData: function (type, k) {
        // this.device.configs[this.device.configs.length - 1].data[k] = null;
        // this.activeConfig.data[k] = null;
        Vue.delete(this.activeConfig[type], k);
      },
      addDataConfig: function (type) {
        var key = 'new';
        do {
          key = 'new_' + _.random(1,100);
        } while(key in this.activeConfig[type])
        Vue.set(this.activeConfig[type], key, type == 'data' ? {
          type: '',
          unit: '',
          port: '',
          max_v: '',
          min_v: '',
          desc: '',
        } : '* * * * *')
      }
    }
  }
</script>
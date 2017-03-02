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
            <label for="name">Data</label>
            <textarea rows="3" v-model="activeConfig.data" class="form-control" id="name" placeholder="name">
            </textarea>
          </div>
          <div class="form-group">
            <label for="type">Controller</label>
            <textarea rows="3" v-model="activeConfig.control" class="form-control" id="type" placeholder="type">
            </textarea>
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
        return _.last(this.device.configs) || {};
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

      }
    }
  }
</script>
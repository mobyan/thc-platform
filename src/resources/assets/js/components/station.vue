<template>
  <div>
    <div class="">
      <div class="panel panel-default panel-primary">
        <div class="panel-heading" >
          <h3 class="panel-title">基本信息</h3>
      </div>
      <div class="panel-body">
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
                <button v-if="editing" type="submit" @click.prevent="editing = !editing" class="btn btn-default" >取消</button>
                <button v-if="!editing" type="submit" @click.prevent="editing = !editing;isCreate = false;" class="btn btn-primary">修改</button>
                <button v-if="!editing" type="submit" @click.prevent="create" class="btn btn-default">创建</button>
                <button v-if="!editing" type="submit" @click.prevent="remove" class="btn btn-danger">删除</button>
            </template>
        </form>
    </div>
</div>
</div>
<div class="panel panel-default panel-primary">
    <div class="panel-heading" >
        <h3 class="panel-title">设备列表</h3>
    </div>
    <div class="panel-body">
      <router-view></router-view>
  </div>
</div>
</template>

<script>
import bootbox from 'bootbox'
    export default {
      data: function () {
        return {
          station: {},
          editing: true,
          editable: false,
          isCreate: false,
          fillable: ['name', 'type', 'location', 'lon', 'lat', 'alt'],
      }
  },
  methods: {
    save: function () {
        if (this.isCreate) {
            this.$http.post('/api/station', this.station).then(function (res) {
                this.editing = !this.editing;
                this.$router.push({
                    name: 'station',
                    params: {
                        station: res.body.id,
                    }
                })
            });
        } else {
            this.$http.put('/api' + this.$route.path, _.pick(this.station, this.fillable)).then(function () {
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
    remove: function (id) {
        var self = this;
        bootbox.confirm('确认删除？', function (result) {
            if (result) {
                self.$http.delete('/api' + self.$route.path).then(function () {
                    this.$router.push({name:'stations'});
                })
            }
    })
    }
  },
  mounted: function () {
    this.editable = thc.can('app_w');
    this.editing = this.$route.query.op == 'edit';
    this.$http.get('/api/station/'+this.$route.params.station).then(function (res) {
      this.station = res.body;
  })
}
}
</script>
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
                <button v-if="editing" type="submit" @click.prevent="editing = !editing" class="btn btn-primary">确定</button>
                <button v-if="editing" type="submit" @click.prevent="editing = !editing" class="btn btn-default" >取消</button>
                <button v-if="!editing" type="submit" @click.prevent="editing = !editing" class="btn btn-default">修改</button>
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
    export default {
      data: function () {
        return {
          station: {},
          editing: true,
          editable: false,
      }
  },
  created: function () {
    this.editable = app.user.roles.length > 0;
    this.editing = this.$route.query.op == 'edit';
    this.$http.get('/api/station/'+this.$route.params.station).then(function (res) {
      this.station = res.body;
  })
}
}
</script>
<template>
    <div>
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
</template>

<script >
  export default {
    data: function () {
      return {
        device: {}
    }
},
created: function () {
  var self = this;
  var deviceId = this.$route.params.device;
  $.get(this.apiURI(), function (device) {
    self.device = device;
})
},
methods: {
    apiURI: function () {
        return '/api' + this.$route.path;
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
    }
}
}
</script>
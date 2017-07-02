<template>
  <div>
    <table id="grid-table"></table>
  </div>
</template>
<script>
    export default {
      data: function () {
        return {
          codes: [],
          app: null
        };
      },
      created: function () {
        this.codes = thc.user.codes;
        this.app = thc.user.app;
        var self = this;
        /*this.codes = _.map(this.codes, function(v){
          self.$http.get("/api/station?app_id="+self.user.app_id+"&code="+v.code).then(function(res){
            v.stations = res.body.items;
            v.counts = res.body.counts;
            return v;
          })
        });*/
      },
      methods: {

      }
    }
</script>

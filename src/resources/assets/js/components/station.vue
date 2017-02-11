<template>
  <div>
    <div class="">
      <p><label>id</label>: {{station.id}}</p>
      <p><label>name</label>: {{station.name}}</p>
      <p><label>type</label>: {{station.type}}</p>
      <p><label>location</label>: {{station.location}}</p>
      <p><label>lat</label>: {{station.lat}}</p>
      <p><label>lon</label>: {{station.lon}}</p>
      <p><label>alt</label>: {{station.alt}}</p>
      <p><label>status</label>: {{station.status}}</p>
    </div>
    <router-view></router-view
 </div>
</template>

<script>
  export default {
    data: function () {
      return {
        station: {}
      }
    },
    created: function () {
      var self = this;
      $.get('/api/station/'+this.$route.params.station, function (station) {
        self.station = station;
      })
    }
  }
</script>
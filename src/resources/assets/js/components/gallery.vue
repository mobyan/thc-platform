<template>
  <div>
    <div v-for="device in devices">
      <div v-for="gallery in device.galleries">
        <div>
        <h4>Date: {{gallery.date}} {{device.name}}</h4>
        </div>
        <div class="row">
          <div v-for="image in gallery.images" class="col-xs-6 col-md-3">
            <div class="thumbnail">
              <img :src="'http://thc-platfrom-storage.b0.upaiyun.com' + image.value" alt="alt" >
              <div><span>{{image.ts}}</span><span style="float: right;" @click="download" ><img height="16px" width="16px" src="/image/dl.png"></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <viewer :images="testImages" index="1"></viewer> -->
  </div>
</template>

<script >
  export default {
    props: ['images'],
    data: function () {
      return {
        testImages: [
        {src: '/image/dl.png'},
        {src: '/image/dl.png'},
        {src: '/image/dl.png'},
        {src: '/image/dl.png'},
        ]
      };
    },
    computed: {
      devices: function () {
        return _.map(this.images, function (v,k) {
          var res = {};
          res.galleries = _.reduce(v.data, function (memo, value) {
            var ts = moment(value.ts).format('YYYY-MM-DD');
            memo[ts] = memo[ts] || {date: ts, images:[]};
            memo[ts].images.push(value)
            return memo;
          },{});
          res.name = v.name;
          return res;
        })
      }
    },
    methods: {
      download: function (e) {
        var url = $(e.target).parent().parent().siblings('img').attr('src');
        var a = $("<a>")
        .attr("href", url)
        .attr("download", "img.png")
        .appendTo("body");
        a[0].click();
        a.remove();
      }
    },
    created: function () {
    }
  }
</script>

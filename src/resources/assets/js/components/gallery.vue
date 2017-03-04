<template>
    <div>
        <div v-for="device in devices">
            <div v-for="gallery in device">
                <div>
                  <h3>Date: {{gallery.date}}</h3>
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
</div>
</template>

<script >
    export default {
        props: ['images'],
        computed: {
            devices: function () {
                return _.map(this.images, function (v,k) {
                    var res = _.reduce(v.data, function (memo, value) {
                        var ts = moment(value.ts).format('YYYY-MM-DD');
                        memo[ts] = memo[ts] || {date: ts, images:[]};
                        memo[ts].images.push(value)
                        return memo;
                    },{});
                    return res;
                })
            }
        },
        methods: {
          download: function (e) {
            var url = $(e.target).parent().parent().siblings('img').attr('src');
            console.log(url)
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
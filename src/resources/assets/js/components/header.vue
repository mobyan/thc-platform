<template>
  <div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
    <div >
      <div id="title" style="float: left;">
      <span style="font-weight:bold; font-size: 16px;">{{title}} </span>
      </div>
      <div v-if="user.rcodes.length > 1 && currentRCode" style="float: right;">
        <label>当前区域：</label><select v-if="user" v-model="currentRCode" style="z-index: 9999; position: relative;"><option v-for="(rcode, index) in user.rcodes" :value="rcode.id">{{rcode.id}} - {{rcode.merged_name}}</option></select>&nbsp;&nbsp;&nbsp;
      <!--<button class="btn btn-primary btn-xs" @click="back()">
        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> 返回</button>-->
      </div>
            <div style="clear:both;"></div>

    </div>

  </div>
</template>
<script >
  export default {
    props: ['title'],
    data: function () {
      return {
        currentRCode: Cookie.get('currentRCode'),
        user: thc.user,
      }
    },
    watch: {
      currentRCode: function () {
        Cookie.set('currentRCode',this.currentRCode);
        location.href = '/';
      }
    },
    created: function () {
      Cookie.set('currentRCode', Cookie.get('currentRCode') || (thc.user.rcodes[0]?thc.user.rcodes[0].id:null));
    },
    methods: {
      back: function () {
        this.$router.go(-1);
      }
    },
  }
</script>

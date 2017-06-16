<template>
  <div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
    <div >
      <div id="title" style="float: left;">
      <span style="font-weight:bold; font-size: 16px;">{{title}} </span>
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
        currentApp: Cookie.get('currentApp'),
        user: thc.user,
        apps: [],
      }
    },
    watch: {
      currentApp: function () {
        Cookie.set('currentApp',this.currentApp);
        location.href = '/';
      }
    },
    created: function () {
      //var self = this;
      //this.$http.get('/api/app').then(function (res) {
      //  self.apps = res.body.items;
      //})
      //  Cookie.set('currentApp', Cookie.get('currentApp') || (self.apps[0]?self.apps[0].id:null));
    },
    methods: {
      back: function () {
        this.$router.go(-1);
      }
    },
  }
</script>

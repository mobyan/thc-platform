<template>
  <div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
    <div >
      <div id="title" style="float: left;">
      <span style="font-weight:bold; font-size: 16px;">{{title}} </span>
      </div>
      <div v-if="user.apps.length > 1 && currentApp" style="float: right;">
        <label>当前产品线：</label><select v-if="user" v-model="currentApp" style="z-index: 9999; position: relative;"><option v-for="(app, index) in user.apps" :value="app.id">{{app.id}} - {{app.name}}</option></select>&nbsp;&nbsp;&nbsp;
      <button class="btn btn-primary btn-xs" @click="back()"> 
        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> 返回</button>
      </div>
            <div style="clear:both;"></div>

    </div>
    <div id="alert" class="alert" role="alert" ></div>

  </div>
</template>
<script >
  export default {
    props: ['title'],
    data: function () {
      return {
        currentApp: Cookie.get('currentApp'),
        user: thc.user,
      }
    },
    watch: {
      currentApp: function () {
        Cookie.set('currentApp',this.currentApp);
        location.href = '/';
      }
    },
    created: function () {
      Cookie.set('currentApp', Cookie.get('currentApp') || (thc.user.apps[0]?thc.user.apps[0].id:null));
    },
    methods: {
      back: function () {
        this.$router.go(-1);
      }
    },
  }   
</script>
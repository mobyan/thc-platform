<template>
  <div class="page-header">
    <div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
      <div >
        <div id="title" style="float: left;">
        <span style="font-weight:bold; font-size: 16px;">{{title}} </span>
        </div>
        <div style="clear:both;"></div>

      </div>

    </div>
    <div v-if="user.codes.length > 1 && currentCode" class="btn-group">
      <label>当前区域</label>
      <select v-if="user" v-model="currentCode">
        <option v-for="(code, index) in user.codes" :value="code.id">{{code.code}} - {{code.merged_name}}</option>
      </select>
    <!--<button class="btn btn-primary btn-xs" @click="back()">
      <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> 返回</button>-->
    </div>
  </div>
</template>
<script>
  import Vue from "vue";
  var bus = new Vue();
  export default {
    props: ['title'],
    data: function () {
      return {
        currentCode: Cookie.get('currentCode'),
        user: thc.user,
      }
    },
    watch: {
      currentCode: function () {
        console.log('header.vue currentCode');
        Cookie.set('currentCode',this.currentCode);
        bus.$emit('ccodeChanged',this.currentCode);
        // location.href = '/eason';
      }
    },
    created: function () {
      if (isNaN(parseInt(Cookie.get('currentCode')))) {
        Cookie.set('currentCode',(thc.user.codes[0]?thc.user.codes[0].id:null));
      }
      // Cookie.set('currentCode', =='null' || (thc.user.codes[0]?thc.user.codes[0].id:null));
    },
    methods: {
      back: function () {
        this.$router.go(-1);
      }
    },
  }
</script>

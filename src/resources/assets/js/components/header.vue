<template>
  <div class="page-header">
    <h1>{{titile}}
    </h1>
    <div v-if="user.codes.length > 1 && currentRCode" class="btn-group">
      <label>当前区域</label>
      <select v-if="user" v-model="currentRCode">
        <option v-for="(code, index) in user.codes" :value="code.id">{{code.code}} - {{code.merged_name}}</option>
      </select>
    <!--<button class="btn btn-primary btn-xs" @click="back()">
      <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> 返回</button>-->
    </div>
  </div>
</template>
<script>
  export default {
    props: ['title'],
    data: function () {
      return {
        currentCode: Cookie.get('currentCode'),
        user: thc.user,
      }
    },
    watch: {
      currentRCode: function () {
        Cookie.set('currentCode',this.currentCode);
        location.href = '/';
      }
    },
    created: function () {
      Cookie.set('currentCode', Cookie.get('currentCode') || (thc.user.codes[0]?thc.user.codes[0].id:null));
    },
    methods: {
      back: function () {
        this.$router.go(-1);
      }
    },
  }
</script>

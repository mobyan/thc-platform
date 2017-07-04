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
      },
      methods: {

      }
    }
</script>

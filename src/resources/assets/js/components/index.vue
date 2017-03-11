<template>
  <div class="">
    <table class="table table-bordered table-striped table-hover">
      <tbody>

        <template v-for="(item, i) in items">
          <tr v-if="i == 0" class="fatal">
            <th v-if="!schema[k].hidden" v-for="(v,k) in item">{{ k }}</th>
            <th width="110px">操作</th>
          </tr>
          <tr class="">
            <td v-if="!schema[k].hidden" v-for="(v,k) in item" @dblclick="toggle">
              <input type="text" class="form-control" :value="v" name="" disabled="">
            </td>
            <td width="110px">
            <span><button type="button" class="btn btn-primary btn-sm">edit</button></span>
              <span><button type="button" class="btn btn-danger btn-sm">del</button></span>
              </td>
            </tr>

          </template>
        </tbody>
      </table>
    </div>
  </template>

  <script>
    export default {
      data: function () {
        return {
          items: []
        }
      },
      created: function () {
        var self = this;
        var model = this.$route.params.model;
        $.when(this.$http.get('/api/'+ model +'/schema'), this.$http.get('/api/'+ model +'')).then(function (schema, stations) {
          self.items = stations[0].items;
          self.schema = schema[0];
        })
      },
      methods: {
        toggle (e) {
          // alert('ff')
          $(e.target).children('input').prop('disabled', function(i, v) { return !v; });
        }
      }
    }
  </script>
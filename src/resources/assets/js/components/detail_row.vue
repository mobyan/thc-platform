<template>
  <div>
    <div class="inline field">
      <label>ID: </label>
      <span>{{rowData.id}}</span>
    </div>
    <div class="inline field">
      <label>名称: </label>
      <input type="text" v-model="rowData.name">
    </div>
    <button class="ui basic button inline btn-success"
      @click="onClick()">
      <i class="fa fa-refresh">更新</i>
    </button>
  </div>
</template>

<script>
import bootbox from 'bootbox'
export default {
  props: {
    rowData: {
      type: Object,
      required: true
    },
    rowIndex: {
      type: Number
    }
  },
  data: function(){
    return {
      fillable:['name']
    };
  },
  methods: {
    onClick () {
      var self = this;
      bootbox.confirm('确认更新？', function(result){
        if(result){
          self.$http.put('/api/app/'+self.rowData.id, _.pick(self.rowData, self.fillable), {params:{alert:'更新公司信息'}}).then(function() {
            });
        }
      });
      //console.log('my-detail-row: on-click', event.target)
    }
  },
}
</script>

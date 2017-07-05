<template>
  <div class="input-group">
    <input v-model="search.merged_name" :disabled="!editing" @keydown.enter="searchInput()" class="form-control"/>
    <div class="input-group-btn">
      <button @click="searchInput()" :disabled="!editing" class="btn btn-white btn-primary"><i class="fa fa-search"></button>
      <button @click="clearInput()" :disabled="!editing" class="btn btn-white btn-primary"><i class="fa fa-refresh"></button>
    </div>
      <div class="search-select">
          <transition-group name="itemfade" tag="ul" mode="out-in" v-cloak v-show="isShow">
              <li v-for="(cv,index) in codes" :class="{selectback:index==now}" :key="index" @click.prevent="searchThis(index)" @mouseover="selectHover(index)" class="search-select-option search-select-list">
                  {{cv.merged_name}}
              </li>
          </transition-group>
      </div>
  </div>
</template>
<script>
export default{
  props: {
    search:{
      type: Object,
      required: true
    },
    editing:{
      type: Boolean,
      default: true
    }
  },
  data: function(){
    return{
      codes: [],
      flag: 0,
      now: -1,
      isShow: false,
    }
  },
  //watch:{
  //  search: function(){
  //    this.code = search.code? search.code:"";
  //  }
  //},
  methods:{
      get: function() {
          console.log(this.search);
          this.$http.get('/api/code/search?content='+this.search.merged_name).then(function(res) {
              this.codes = res.body;
              this.isShow = !this.isShow;
          });
      },
      searchInput: function(){
        this.get();
      },
      searchThis: function(index) {
            this.$http.get('/api/code/'+this.codes[index].id+'?with=roles').then(function(res){
              this.search = res.body;
              this.$emit('code-update', res.body);
              // this.$emit('code-info',this.code);
            });
            // this.code = this.codes[index];
            this.isShow=!this.isShow;
        },

      //清除内容
      clearInput: function() {
          this.search = {merged_name:""};
          this.isShow=false;
      },
      //li hover
      selectHover: function(index) {
            this.now = index;
      },
      // //向下
      // selectDown: function() {
      //     this.now++;
      //     if(this.now == this.codes.length) {
      //         this.now = 0;
      //     }
      //     this.search = this.codes[this.now].merged_name;
      // },
      // //向上
      // selectUp: function() {
      //     this.now--;
      //     if(this.now == -1) {
      //         this.now = this.codes.length - 1;
      //     }
      //     this.search = this.codes[this.now].merged_name;
      // }
  }
}
</script>

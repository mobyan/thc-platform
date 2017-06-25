<template>
  <div class="search-input">
    <input v-model="search.merged_name" @keydown.enter="searchInput()"/>
      <span @click="clearInput()" class="search-reset">&times;</span>
      <button @click.prevent="searchInput()" class="search-btn">确定</button>
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
  prop: ['code'],
  data: function(){
    return{
      search:{"merged_name":""},
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
          this.$http.get('/api/code/search?content='+this.search.merged_name).then(function(res) {
              this.codes = res.body.items;
              this.isShow = !this.isShow;
          });
      },
      searchInput: function(){
        this.get();
      },
      searchThis: function(index) {
            this.search = this.codes[index];
            console.log(this.search.code);
            this.$emit("codeChangedEvent", this.search);
            this.isShow=!this.isShow;
        },

      //清除内容
      clearInput: function() {
          this.search = {'merged_name':''};
          this.isShow=false;
      },
      //li hover
      selectHover: function(index) {
            this.now = index;
      },
      //向下
      selectDown: function() {
          this.now++;
          if(this.now == this.codes.length) {
              this.now = 0;
          }
          this.search = this.codes[this.now];
      },
      //向上
      selectUp: function() {
          this.now--;
          if(this.now == -1) {
              this.now = this.codes.length - 1;
          }
          this.search = this.codes[this.now];
      }
  }
}
</script>

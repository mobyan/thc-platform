<template>
  <div class="input-group">
    <!-- <input disabled="true" v-model="code.merged_name"> -->
    <div>
      <select v-model="province_code">
        <option v-for="prc in province_codes" :value="prc">{{prc.name}}</option>
      </select>
      <select v-model="city_code" v-if="city_codes.length>0">
        <option v-for="cic in city_codes" :value="cic">{{cic.name}}</option>
      </select>
      <select v-model="country_code" v-if="country_codes.length>0">
        <option v-for="coc in country_codes" :value="cc">{{coc.name}}</option>
      </select>
      <select v-model="town_code" v-if="town_codes.length>0">
        <option v-for="toc in town_codes" :value="toc">{{toc.name}}</option>
      </select>
      <select v-model="village_code" v-if="village_codes.length>0">
        <option v-for="vic in village_codes" :value="vic">{{vic.name}}</option>
      </select>
    </div>
  </div>
</template>
<script>
export default{
  props: {
    code:{
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
      province_code: {"merged_name":""},
      city_code:{"merged_name":""},
      country_code:{"merged_name":""},
      town_code:{"merged_name":""},
      village_code:{"merged_name":""},
      province_codes:[],
      city_codes:[],
      country_codes:[],
      town_codes:[],
      village_codes:[],


    }
  },
  watch:{
   province_code: function(){
     this.code = this.province_code;
     this.city_codes = get_children(this.provine_code.code);
   },
   city_code: function(){
     this.code = this.city_code;
     this.country_codes = get_children(this.city_code.code);
   },
   country_code: function(){
     this.code = this.country_code;
     this.town_codes = get_children(this.country_code.code);
   },
   town_code: function(){
     this.code = this.town_code;
     this.village_codes = get_children(this.town_code.code);
   },
   village_code: function(){
     this.code = this.village_code;
   }
  },
  created: function(){
      this.province_codes = this.get_children_bylevel("1");
  },
  methods:{
      get_children: function(parent_code){
        var codes = [];
        this.$http.get('/api/code?parent_code='+parent_code).then(function(res){
          codes = res.body;
        });
        return codes;
      },
      get_children_bylevel: function(level){
        var codes = [];
        this.$http.get('/api/code?level='+level).then(function(res){
          codes = res.body;
        });
        return codes;
      },
  }
}
</script>

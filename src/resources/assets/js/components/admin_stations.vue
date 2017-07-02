<template>
<div class="">
    <!--search part-->
    <div class="row">
        <div class="col-md-7 form-inline">
          <div class="form-inline form-group">
            <label>产品线</label>
            <select v-model="currentApp" class="form-control" style="z-index: 9999;"><option v-for="(app, index) in apps" :value="app.id">{{app.id}} - {{app.name}}</option></select>
          </div>
        </div>
        <div class="col-md-5 form-inline">
          <div class="form-inline form-group">
            <label>搜索</label>
            <input v-model="searchFor" class="form-control" @keyup.enter="setFilter">
            <button class="btn btn-white btn-primary" @click="setFilter"><i class="fa fa-search"></i></button>
            <button class="btn btn-white btn-default" @click="resetFilter"><i class="fa fa-refresh"></i></button>
          </div>
        </div>
    </div>
    <div v-if="editable" class="row">
      <div class="table-responsive">
        <vuetable
          ref="vuetable"
          api-url="/api/station"
          :fields="columns"
          pagination-path=""
          data-path="data"
          :per-page="2"
          :css="css.table"
          :append-params="params"
          table-class="table table-bordered table-striped table-hover"
          @vuetable:loading="onLoading"
          @vuetable:loaded="onLoaded"
          @vuetable:pagination-data="onPaginationData"
          >
          <template slot="actions" scope="props">
              <div class="custom-actions">
                <button class="btn btn-white btn-primary"
                  @click="onAction(props.rowData, props.rowIndex)">
                  <i class="fa fa-pencil-square-o "></i>
                </button>
                <button class="btn btn-white btn-danger"
                  @click="remove(props.rowIndex)">
                  <i class="fa fa-trash-o "></i>
                </button>
              </div>
            </template>
        </vuetable>
        </div>
        <div class="vuetable-pagination">
            <vuetable-pagination-info ref="paginationInfo"
            info-class="pagination-info"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="pagination"
              :css="css.pagination"
              @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>

    </div>
  </div>
</template>

<script>
import bootbox from 'bootbox'
import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue'

  export default {
    components: {
      Vuetable,
      VuetablePagination,
      VuetablePaginationInfo
    },
    data: function () {
      return {
        editable: thc.can('sys_w', 0),
        stations: [],
        apps: [],
        currentApp: null,
        searchFor:'',
        params:{
          with: 'app,code',
          app_id: '',
          filter: ''
        },
        columns:[

          {
            name:'name',
            title:'名称',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'app.name',
            title:'所属公司',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'type',
            title:'类型',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'location',
            title:'地址',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'code.merged_name',
            title:'区划',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'status',
            title:'状态',
            titleClass:'text-center',
            dataClass: 'center aligned',
            callback: 'onStatus'
          },
          {
            name: '__slot:actions',
            title: '操作',
            titleClass: 'center aligned',
            dataClass: 'center aligned',
          }
        ],
        css: {
          table: {
            tableClass: 'table table-bordered table-striped table-hover table-condensed',
            ascendingIcon: 'glyphicon glyphicon-chevron-up',
            descendingIcon: 'glyphicon glyphicon-chevron-down'
          },
          pagination: {
            wrapperClass: 'pagination pull-right no-margin',
            activeClass: 'active',
            disabledClass: 'disabled',
            pageClass: 'page',
            linkClass: 'link',
            icons: {
              first: 'fa fa-angle-double-left ace-icon',
              prev: 'prev fa fa-angle-left ace-icon',
              next: 'next fa fa-angle-right ace-icon',
              last: 'fa fa-angle-double-right ace-icon',
            }
          },
        }
      }
    },
    created: function () {
      var self = this;
      this.$http.get('/api/app').then(function(res){
        self.apps = res.body;
        self.currentApp = self.apps[0].id;
      }).then(function(){
        this.$http.get('/api/station?with=app,code&app_id='+self.currentApp).then(function (res) {
          self.stations = res.body;
        });
      });

    },
    watch:{
      currentApp: function(){
        this.search();
      }
    },
    methods: {
        setFilter: function() {
          this.params.filter =this.searchFor;
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            })
        },
        resetFilter: function() {
            this.searchFor = '';
            this.setFilter();
        },
        onAction ( data, index) {
          //console.log('slot action: ', data.name, index);
          //this.$refs.vuetable.toggleDetailRow(index+1);
          this.$router.push("/admin/station/"+data.id);

        },
        onPaginationData (paginationData) {

          this.$refs.pagination.setPaginationData(paginationData);
          this.$refs.paginationInfo.setPaginationData(paginationData);
        },
        onChangePage (page) {
          this.$refs.vuetable.changePage(page);
        },
        onLoading(){
          window.app.loading = true;
        },
        onLoaded(){
          window.app.loading = false;
        },
        onStatus: function(value){
          return '<img height="20" src="/image/'+ value+'.png" class="signal">';
        },
        go: function () {
            this.$router.push({name:'admin-station', params:{station:0}, query: {op:'create'}})
        },
        remove: function (index) {
            var self = this;
            bootbox.confirm('确认删除？', function (result) {
                if (result) {
                    self.$http.delete('/api/station/'+self.stations[index].id).then(function () {
                        self.stations.splice(index, 1);
                    })
                }
          })
        },
        search: function(){
            var self = this;
            this.$http.get('/api/station?with=app,code&app_id='+this.currentApp).then(function(res){
              self.stations = res.body;
            })
        }
    }
  }
</script>

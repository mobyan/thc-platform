<template>
<div>
  <div class="row">
    <div class="col-md-5 col-sm-5 form-inline">
      <div class="form-inline form-group">
        <label>产品线</label>
        <select v-model="currentApp" class="form-control input-sm" style="z-index: 9999;"><option v-for="(app, index) in apps" :value="app.id">{{app.id}} - {{app.name}}</option></select>
      </div>
      <div class="form-inline form-group">
        <label>搜索</label>
        <input v-model="searchFor" class="form-control input-sm" @keyup.enter="setFilter">
        <button class="btn btn-white btn-primary btn-xs" @click="setFilter"><i class="fa fa-search"></i></button>
        <button class="btn btn-white btn-default btn-xs" @click="resetFilter"><i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="form-inline pull-right">
      <button class="btn btn-primary btn-xs" @click="go">添加</button>
    </div>
  </div>
  <div v-if="editable" class="row">
    <div class="table-responsive">
      <vuetable
        ref="vuetable"
        api-url="/api/user"
        :fields="columns"
        pagination-path=""
        data-path="data"
        :per-page="10"
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
                @click="remove(props.rowData, props.rowIndex)">
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
        editable: thc.can('sys_w',0),
        users: [],
        apps:[],
        currentApp: null,
        params:{
          with: 'bcode',
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
            name:'email',
            title:'邮箱',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'phone',
            title:'手机',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'bcode.merged_name',
            title:'区划',
            titleClass:'text-center',
            dataClass:'text-center'
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
      });

    },
    methods: {
        go: function () {
            this.$router.push({name:'admin-user', params:{user:0}, query: {op:'create'}})
        },
        remove: function(usr, i){
            var self = this;
            bootbox.confirm('确认删除？', function (result) {
                if (result) {
                    self.$http.delete('/api/user/' + usr.id).then(function () {
                        self.users.splice(i, 1);
                    })
                }
          })
        },
        setFilter: function() {
          this.params.filter =this.searchFor;
            this.$refs.vuetable.refresh();
        },
        resetFilter: function() {
            this.searchFor = '';
            this.setFilter();
        },
        onAction ( data, index) {
          //console.log('slot action: ', data.name, index);
          //this.$refs.vuetable.toggleDetailRow(index+1);
          this.$router.push("/admin/user/"+data.id);

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
    }
  }
</script>

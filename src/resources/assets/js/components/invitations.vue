<template>
<div>
  <div class="row">
    <div class="form-inline pull-right">
      <label>邮箱</label>
      <input v-model="invitation.email" class="form-control input-sm"></input>
      <label>区划</label>
      <select v-model="invitation.regioncode"><option v-for="(rc, index) in subs" :value="rc.code">{{rc.merged_name}}</option></select>
      <button class="btn btn-primary btn-xs" @click="go">添加</button>
    </div>
  </div>
  <div v-if="editable" class="row">
    <div class="table-responsive">
      <vuetable
        ref="vuetable"
        api-url="/api/invitation"
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
              <button class="btn btn-white btn-success"
                @click="extend(props.rowData, props.rowIndex)">
                <i class="fa fa-trash-o "></i>
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
        editable: thc.can('app_w'),
        invitations: [],
        invitation: {email:"",regioncode:""},
        subs:[],
        params:{
          with: 'rcode',
          app_id: '',
          filter: ''
        },
        columns:[
          {
            name:'email',
            title:'邮箱',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'code',
            title:'邀请码',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'rcode.merged_name',
            title:'区划',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'valid_till',
            title:'有效期',
            titleClass:'text-center',
            dataClass:'text-center'
          },
          {
            name:'status',
            title:'状态',
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
      this.load();
    },
    watch: {
      '$route': 'load',
    },
    methods: {
      load: function(){
        this.$http.get('/api/code/subs').then(function(res){
          this.subs = res.body;
        });
      },
      go: function(){
        this.$http.post('/api/invitation', this.invitation, {params:{alert:"添加邀请码"}}).then(function(res){
          this.invitations.push(res.body);
        });

        //this.$router.push({name:'invitation', params:{invitation:0}, query: {op:'create'}});
      },
      onLoading: function(){
        window.app.loading = true;
      },
      onLoaded: function(){
        window.app.loading = false;
      },
      onPaginationData (paginationData) {

        this.$refs.pagination.setPaginationData(paginationData);
        this.$refs.paginationInfo.setPaginationData(paginationData);
      },
      onChangePage (page) {
        this.$refs.vuetable.changePage(page);
      },
      remove: function(data, i){
        var self = this;
        this.$http.delete('/api/invitation/'+data.id).then(function(res){
          self.invitations.splice(i, 1);
        })
      },
      extend: function(data, index){
        this.$http.get('/api/invitation/extend/'+data.id, {params:{alert:'延长有效期'}}).then(function(res){
          Vue.set(this.invitations, index, res.body);
        });

      }

    }
  }
</script>

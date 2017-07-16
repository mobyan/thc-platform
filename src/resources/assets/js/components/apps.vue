<template>
  <div class="">
    <div class="row">

      <div class="form-inline form-group">
        <label>名称</label>
        <input type="text" class="form-control input-sm" id="name" placeholder="输入公司名称" v-model="newApp.name"></input>
        <!-- <button type="button" v-if="!editing" @click.prevent="createApp" class="btn btn-sm btn-default btn-success">添加</button> -->
        <button type="button" @click.prevent="saveApp" class="btn btn-sm btn-default btn-success">保存</button>
      </div>
    </div>
    <div v-if="editable" class="row">
      <vuetable
        ref="vuetable"
        api-url="/api/app"
        :fields="columns"
        pagination-path=""
        data-path="data"
        :per-page="10"
        :css="css.table"
        detail-row-component="app-detail-row"
        @vuetable:loading="onLoading"
        @vuetable:loaded="onLoaded"
        table-class="table table-bordered table-striped table-hover"
        @vuetable:pagination-data="onPaginationData"
        >
        <template slot="actions" scope="props">
            <div class="custom-actions">
              <button class="btn btn-white btn-primary"
                @click="onAction(props.rowData, props.rowIndex)">
                <i class="fa fa-pencil-square-o "></i>
              </button>
              <button class="btn btn-white btn-danger"
                @click="removeApp(props.rowData, props.rowIndex)">
                <i class="fa fa-trash-o "></i>
              </button>
            </div>
          </template>
      </vuetable>
      <div class="vuetable-pagination  ui bottom attached segment grid">
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
  </div>

</template>

<script>
import utils from '../utils'
import bootbox from 'bootbox'
import Vue from 'vue'
import AppDetailRow from './detail_row.vue'
import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue'
Vue.component('app-detail-row', AppDetailRow)
  export default {
    components: {
      Vuetable,
      VuetablePagination,
      VuetablePaginationInfo,
    },
    data: function () {
      return {
        editable: thc.can('sys_w', 0),
        editing: true,
        fillable: ['name'],
        apps: [],
        newApp: null,
        columns:[
          {
            name:'id',
            title:'ID',
            dataClass:'text-center'
          },
          {
            name:'name',
            title:'名称',
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
    computed: {
      apiURI: function() {
          return '/api' + this.$route.path;
      },
    },
    created: function () {
      var self = this;
      this.createApp();
    },
    methods: {
        onAction ( data, index) {
          //console.log('slot action: ', data.name, index);
          this.$refs.vuetable.toggleDetailRow(index+1);

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
        go: function () {
            this.$router.push({name:'station', params:{station:0}, query: {op:'create'}})
        },
        createApp: function(){
          this.newApp = {};
          this.editing = !this.editing;
        },
        editApp: function(index){
          this.apps[index].editing = !this.apps[index].editing;
          Vue.set(this.apps, index, this.apps[index]);
          //alert(this.apps[index].editing);
        },
        onCellClicked (data, field, event) {
          console.log('cellClicked: ', data.id)
          this.$refs.vuetable.toggleDetailRow(data.id)
        },
        updateApp: function(index){
          var self = this;
          bootbox.confirm('确认更新？', function(result){
            if(result){
              self.$http.put('/api/app/'+self.apps[index].id, _.pick(self.apps[index], self.fillable), {params:{alert:'更新公司信息'}}).then(function() {
                self.editApp(index);
                });
            }
          });

        },
        removeApp: function(app, index){
          var self = this;
          bootbox.confirm('确认删除？', function(result) {
            if (result) {
                self.$http.delete('/api/app/'+app.id).then(function() {
                    self.apps.splice(index, 1);
                    //self.$router.go(0);
                })
            }
        })
        },
        saveApp: function(){
          var self = this;
          bootbox.confirm('确认添加？', function(result) {
            if (result) {
                self.$http.post('/api/app/', self.newApp, {params:{alert:"新建公司生产线"}}).then(function(res) {
                    //self.$router.go(0);
                    self.apps.push(res.body);
                })
            }
          })
          this.editing = !this.editing;
        }

    }
  }
</script>

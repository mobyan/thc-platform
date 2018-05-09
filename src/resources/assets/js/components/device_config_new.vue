<template>
<div class="panel panel-default panel-primary">
    <div class="panel-heading" >
        <h3 class="panel-title">配置(新)</h3>
    </div>
    <div class="panel-body">
        <form>
            <div class="form-group">
            </div>
            <div class="form-group">
                <label for="data">Data</label>
                <div style="overflow:auto">
                    <table class="table table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th>传感器类型</th>
                                <th>接口编号</th>
                                <th>数据配置</th>
                                <th>操作</th>
                            </tr>
                            <device-config-new-item
                                v-for="(config, config_k) in config_data.data"
                                :data="config"
                                :data_k="config_k"
                                :editing_config="editing_config"
                                @deviceConfigItemChange.capture="onDeviceConfigItemChange"
                                @deviceConfigItemDelete.capture="onDeviceConfigItemDelete(config_k)"
                            />
                            <tr><td colspan="8">
                                <div style="text-align: right;"><img v-if="editing_config" @click="addDataConfig()" width="16px" height="16px" src="/image/add.png"></div>
                            </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label for="control">Controller</label>
                <div style="overflow:auto">
                    <table class="table table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th>名称</th>
                                <th>分</th>
                                <th>时</th>
                                <th>日</th>
                                <th>月</th>
                                <th>周</th>
                                <th>操作</th>
                            </tr>
                            <tr v-for="(controls_val,controls_k) in config_data.control">
                                <td>{{controls_k}}</td>
                                <td v-for="(control_val, control_k) in config_data.control[controls_k]" ><input :disabled="!editing_config" type="text" class="form-control" name="" v-model="config_data.control[controls_k][control_k]"></td>
                                <td style="vertical-align: middle;width:33px;"><div v-if="editing_config" @click="removeControlItem(controls_k)"><img width="16px" height="16px" src="/image/remove.png"></div></td>
                            </tr>
                            <tr><td colspan="7">
                                <div style="text-align: right;" ><img v-if="editing_config" @click="addDataControl()" width="16px" height="16px" src="/image/add.png"></div>
                            </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <template v-if="editable">
                <button type="submit" v-if="editing_config" @click.prevent="updateConfig()" class="btn btn-default btn-primary">确认</button>
                <button type="submit" v-if="editing_config" @click.prevent="editing_config = !editing_config" class="btn btn-default btn-default">取消</button>
                <button type="submit" v-if="!editing_config" @click.prevent="editing_config = !editing_config" class="btn btn-default btn-primary">修改</button>
            </template>
        </form>
    </div>
</div>
</template>

<script>
import device_config_new_item from './device_config_new_item.vue'
import sensors from '../new_configs/sensor_types'
import bootbox from 'bootbox'
export default {
    props: [
        'editable',
        'ts',
        'data',
    ],
    components: {
        'device-config-new-item': device_config_new_item
    },
    data: function(){
        return {
            sensors,
            // config_data: {
            //     data: [
            //         {
            //             sensor_type: 'davis_rain',//传感器类型
            //             port: 'PI',//接口类型，AD, 485,选择sensor_type后就固定了
            //             port_num: 0,//接口编号,AD0-11, 485-0，485-1，根据port类型确定选择范围，比如AD，可以选0-11,485，可以选0-1，PI只能选0, image可以选0-1
            //             params:[
            //                 {
            //                     key: 'test0', //key,可配置，唯一
            //                     desc: '000',//接口描述，可配置
            //                     name: '000',//接口名称，可配置
            //                     type: 'rain',//数据类型，确定死的
            //                     unit: 'mm',//数据单位，确定死的
            //                     data_num: 0,//该传感器的数据编号
            //                 }
            //             ]
            //         },
            //         {
            //             sensor_type: 'mec10',//传感器类型
            //             port: '485',//接口类型，AD, 485,选择sensor_type后就固定了
            //             port_num: 0,//接口编号,AD0-11, 485-0，485-1，根据port类型确定选择范围，比如AD，可以选0-11,485，可以选0-1，PI只能选0, image可以选0-1
            //             params:[
            //                 {
            //                     key: 'test1', //key,可配置，唯一
            //                     desc: '111',//接口描述，可配置
            //                     name: '111',//接口名称，可配置
            //                     type: 'temperature',//数据类型，确定死的
            //                     unit: '℃',//数据单位，确定死的
            //                     data_num: 0,//该传感器的数据编号
            //                 },
            //                 {
            //                     key: 'test2', //key,可配置，唯一
            //                     desc: '222',//接口描述，可配置
            //                     name: '222',//接口名称，可配置
            //                     type: 'humdity',//数据类型，确定死的
            //                     unit: '%',//数据单位，确定死的
            //                     data_num: 1,//该传感器的数据编号
            //                 }
            //             ]
            //         },
            //    ],
            //    control: {
            //
            //    }
            // },
            config_data: _.cloneDeep(this.data),
            editing_config: false
        }
    },
    watch: {
        ts: function(val, oldVal){
            this.editing_config = !this.editing_config;
        },
    },
    methods: {
        addDataConfig: function(){
            Vue.set(this.config_data.data, this.config_data.data.length, {
                sensor_type: '',
                port: '',
                port_num: '',
                params:[],
            });
        },
        addDataControl: function(){
            var self = this;
            bootbox.prompt("输入配置项名称：", function(result) {
                if (!result || self.config_data.control[result]) return;
                Vue.set(self.config_data.control, result, {
                    minute: '*',
                    hour: '*',
                    day: '*',
                    month: '*',
                    week: '*'
                });
            });
        },
        checkUniqueKey: function(){
            var data = _.reduce(this.config_data.data, function(result, value, key){
                for(var param_index in value.params){
                    if (_.has(result, value.params[param_index].key)) {
                        result['unique'] = false;
                    }
                    result[value.params[param_index].key] = '';
                }
                return result;
            }, {'unique':true});
            return data.unique;
        },
        updateConfig: function(){
            if(!this.checkUniqueKey()){
                alert('存在重复的唯一索引，可能在不同的传感器之前使用了相同的唯一索引，请检查！');
                return;
            }
            var data = _.reduce(_.cloneDeep(this.config_data.data), function(result, value, key){
                result[key] = value;
                return result;
            }, []);
            var control = _.reduce(_.cloneDeep(this.config_data.control), function(res, v, k) {
                res[k] = _.join([v.minute || '*', v.hour || '*', v.day || '*', v.month || '*', v.week || '*'], ' ');
                return res;
            }, {});
            this.$emit('updateConfig', {'data':data, 'control':control});
            // this.editing_config = !this.editing_config;
        },
        removeControlItem: function(val){
            Vue.delete(this.config_data.control, val);
        },
        onDeviceConfigItemChange: function(val){
            Vue.set(this.config_data.data, val.data_k, val.data);
            // console.log(this.config_data.data);
        },
        onDeviceConfigItemDelete: function(val){
            // Vue.delete(this.config_data.data, val);
            var tmp_data = _.cloneDeep(this.config_data.data);
            _.pullAt(tmp_data, [val]);
            Vue.set(this.config_data, 'data', []);
            var self = this;
            Vue.nextTick(function(){
                Vue.set(self.config_data, 'data', tmp_data);
            });
        },
    },
}
</script>

<template>
<tr>
    <td><select class="form-control" :disabled="!editing_config" v-model="local_sensor_type">
        <option v-for="(sensor, sensor_type) in sensors" :value="sensor_type">{{sensor_type + ": " + sensor.desc}}</option>
    </select></td>
    <td><select class="form-control" :disabled="!editing_config" v-model="local_data.port_num">
        <option v-for="port_num in port_nums" :value="port_num">{{port_num}}</option>
    </select></td>
    <td>
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>数据类型</th>
                    <th>唯一索引(勿重复)</th>
                    <th>名称</th>
                    <th>备注</th>
                </tr>
                <tr v-for="(param,param_k) in local_data.params">
                    <td>{{sensors[local_data.sensor_type].data_nums[param_k].desc}}</td>
                    <td><input type="text" :disabled="!editing_config" v-model="local_data.params[param_k].key" class="form-control"></td>
                    <td><input type="text" :disabled="!editing_config" v-model="local_data.params[param_k].name" class="form-control"></td>
                    <td><input type="text" :disabled="!editing_config" v-model="local_data.params[param_k].desc" class="form-control"></td>
                </tr>
            </tbody>
        </table>
    </td>
    <td style="vertical-align: middle;"><div v-if="editing_config" @click="removeData()"><img width="16px" height="16px" src="/image/remove.png"></div></td>
</tr>
</template>

<script>
import sensors from '../new_configs/sensor_types'
export default {
    props: [
        'data',
        'data_k',
        'editing_config',
    ],
    data: function(){
        return {
            sensors,
            local_data: _.cloneDeep(this.data),
            port_nums: this.data.sensor_type==''?[]:sensors[this.data.sensor_type].port_nums,
            local_sensor_type: this.data.sensor_type==''?[]:this.data.sensor_type,
        };
    },
    methods: {
        removeData: function(){
            // this.$emit('deviceConfigItemDelete', this.data_k);
            this.$emit('deviceConfigItemDelete');
        },
    },
    watch: {
        local_data: {
            handler: function(val, oldVal){
                // console.log(this.local_data);
                this.$emit('deviceConfigItemChange', {'data_k': this.data_k, 'data': this.local_data});
            },
            deep: true
        },
        local_sensor_type: function(val, oldVal){
            if (val != oldVal) {
                this.port_nums = sensors[val].port_nums;
                var params = _.reduce(sensors[val].data_nums, function(result, value, key){
                    result[key] = {
                        key: '',
                        desc: '',
                        name: '',
                        type: value.type,
                        unit: value.unit,
                        data_num: value.data_num
                    }
                    return result
                }, []);
                // console.log(params);
                Vue.set(this.local_data, "sensor_type", val);
                Vue.set(this.local_data, "port", sensors[val].port);
                Vue.set(this.local_data, "port_num", 0);
                Vue.set(this.local_data, "params", params);
            }
        },
    },
}
</script>

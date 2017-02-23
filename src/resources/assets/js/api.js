import defaultOptions from './chartOptions'
export default {
    getDeviceData(uri, query, callback) {
        query = query || {}
        query.with = 'config';
        $.get('/api' + uri , query, function(data) {
            var keys = {};
            _.forIn(data.items, function(item) {
                var config = item.config ? item.config.data : {};
                _.forIn(item.data, function(value, key) {
                    item.data[key] = _.assign(item.data[key], config[key], {
                        ts: item.ts
                    });
                    if (!keys[key]) {
                        keys[key] = {data:[],name:key};
                    }
                    keys[key].data.push(item.data[key]);
                    keys[key].type = item.data[key].type || 'temp';
                });
            });
            return callback(null, keys);
        });
    },
    data2charts (data, type) {
        data = _.filter(data, {type: type})
        var charts = {};
        _.forIn(data, function (v) {
            var type = v.type;
            charts[type] = charts[type] || _.cloneDeep(defaultOptions[type]);
            charts[type].series.push({
                    name: v.name,
                    data: _.map(v.data, function (dd) {
                        return [new Date(dd.ts).getTime(), dd.value];
                    })
            });
        })
        return charts;
    },
    formatData(items, config) {
        var data = {};
        items.forEach(function(v) {
            _.forIn(v.data, function(value, key) {
                data[key] = data[key] || [];
                data[key].push([new Date(v.ts).getTime(), value.value]);
            })
        })
        return _.map(data, function(v, k) {
            return {
                name: k,
                data: v,
                _type: config.data[k] ? config.data[k].type : 'temp',
            }
        })
    }

}
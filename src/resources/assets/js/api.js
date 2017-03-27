import defaultOptions from './chartOptions'
export default {
    getDeviceData(uri, query, callback) {
        query = query || {}
        query.with = 'config';
        query.limit = 10000;
	var options = {
		params: query,
	}
        Vue.http.get('/api' + uri, options).then(function(res) {
            var data = res.body
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
            _.each(keys, (v)=> {
                if (v.type == 'image') {
                    v.data = _.orderBy(v.data, ['ts'], ['desc']);
                }
            })
            return callback(null, keys);
        });
    },
    data2charts (data) {
        self = this;
        var charts = {};
        _.forIn(data, function (v) {
            if (v.type == 'image') return;
            var type = v.type;
            charts[type] = charts[type] || _.cloneDeep(defaultOptions[type]);
            var serieData =  _.map(v.data, function (dd) {
                        return [moment(dd.ts).toDate().getTime(), parseFloat(dd.value)];
                    });
            var serie = {
                    name: v.name,
                    data: serieData,
            }
            if (type == 'rainfall') {
                serie.data = self.accumlateByTime(serie.data);
            }
            charts[type].series.push(serie);
        })
        return JSON.parse(JSON.stringify(charts));
    },
    accumlateByTime (data) {
        var res = _.reduce(data, function (result, v, k) {
            var t = moment(v[0]).format("YYYY-MM-DD HH:00:00");
            result[t] = result[t] || 0;
            result[t] += v[1];
            return result;
        }, {});
        return _.map(res, function (v,k) {return [moment(k).toDate().getTime(),v]});
    },
    formatData(items, config) {
        var data = {};
        items.forEach(function(v) {
            _.forIn(v.data, function(value, key) {
                data[key] = data[key] || [];
                data[key].push([moment(v.ts).toDate().getTime(), value.value]);
            })
        })
        return _.map(data, function(v, k) {
            return {
                name: k,
                data: v,
                _type: config.data[k] ? config.data[k].type : null ,
            }
        })
    }

}

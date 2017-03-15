import dashboard from './components/dashboard.vue'
import stations from './components/stations.vue'
import station from './components/station.vue'
import header from './components/header.vue'
import devices from './components/devices.vue'
import analyze from './components/analyze.vue'
import map from './components/map.vue'
import user from './components/user.vue'
import index from './components/index.vue'
var apply = require('./components/apply.vue');
var apply_audit = require('./components/apply_audit.vue');

const routes = [{
  path: '/',
  redirect: '/map'
}, {
  path: '/admin/:model',
  components: {
    // default: stations,
    default: index,
    header: header,
  },
  props: {
    header: {title: '站点列表'},
  }
}, {
  path: '/station',
  components: {
    default: stations,
    header: header,
  },
  props: {
    header: {title: '站点列表'},
  }
}, {
  path: '/map',
  components: {
    default: map,
    header: header,
  },
  props: {
    header: {title: '站点地图'},
  }
}, {
  path: '/station/:station',
  components: {
    default: station,
    header: header,
  },
  children: [
  {
    path: '',
    component: devices,
    props:  true,
  }
  ],
  props: {
    header: {title: '站点信息'}
  }
}, {
  path: '/station/:station/dashboard',
  components: {
    default: dashboard,
    header: header,
  },
  props: {
    header: {title: '控制面板'}
  }
}, {
  path: '/station/:station/device/:device',
  components: {
    default: require('./components/device.vue'),
    header: header,
  },
  props: {
    header: {title: '设备信息'}
  }
}, {
  path: '/admin/user/:user',
  components: {
    default: require('./components/user.vue'),
    header: header,
  },
  props: {
    header: {title: '用户管理'}
  }
}, {
  path: '/station/:station/device/:device/data',
  components: {
    default: require('./components/analyze.vue'),
    header: header,
  },
  props: {
    header: {title: '数据分析'}
  }
}, {
    path: '/apply',
    components: {
        default: apply,
        header: header,
    },
    props: {
        header: {
            title: 'apply'
        }
    }
}, {
    path: '/apply_audit',
    components: {
        default: apply_audit,
        header: header,
    },
    props: {
        header: {
            title: 'apply_audit'
        }
    }
}, ]
module.exports = routes
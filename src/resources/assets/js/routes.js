import dashboard from './components/dashboard.vue'
import stations from './components/stations.vue'
import station from './components/station.vue'
import header from './components/header.vue'
import header_none from './components/header_none.vue'
import devices from './components/devices.vue'
import analyze from './components/analyze.vue'
import map from './components/map.vue'
import user from './components/user.vue'
import user_profile from './components/user_profile.vue'
import index from './components/index.vue'
var apply = require('./components/apply.vue');
var apply_audit = require('./components/apply_audit.vue');
var data_download = require('./components/download.vue')

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
  name: 'stations',
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
  name: 'station',
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
  name: 'device',
  path: '/station/:station/device/:device',
  components: {
    default: require('./components/device.vue'),
    header: header,
  },
  props: {
    header: {title: '设备信息'}
  }
}, {
  path: '/admin/user',
  components:{
    default: require('./components/users.vue'),
    header: header,
  },
  props:{
    header:{ title: '用户管理'}
  }
},{
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
},
{
  path: '/station/:station/detail',
  components: {
    default: require('./components/analyze.vue'),
    header: header,
  },
  props: {
    header: {title: '数据分析'}
  }
},
{
  path: '/download',
  components:{
    default: require('./components/download.vue'),
    header: header,
  },
  props: {
    header: {title: '数据下载'}
  }
},{
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
            title: '权限审核'
        }
    }
}, {
    path: '/data_download',
    components: {
        default: data_download,
        header: header,
    },
    props: {
        header: {
            title: '数据下载'
        }
    }
}, {
  path: '/user_profile',
    components: {
        default: user_profile,
        header: header_none,
    },
    props: {
        header: {
            title: '个人资料'
        }
    }

},]
module.exports = routes

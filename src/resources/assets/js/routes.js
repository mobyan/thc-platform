
import dashboard from './components/dashboard.vue'
import stations from './components/stations.vue'
import station from './components/station.vue'
import header from './components/header.vue'
import admin_header from './components/admin_header.vue'
import header_none from './components/header_none.vue'
import devices from './components/devices.vue'
import code_view from './components/code_view.vue'
import analyze from './components/analyze.vue'
import map from './components/map.vue'
import user from './components/user.vue'
import user_profile from './components/user_profile.vue'
import index from './components/index.vue'
import invitations from './components/invitations.vue'
var apply = require('./components/apply.vue');
var apply_audit = require('./components/apply_audit.vue');
var data_download = require('./components/download.vue')

const routes = [{
  path: '/',
  redirect: '/map'
},{
  name: 'dashboard',
  path: '/dashboard',
  components:{
    default: index,
    header: header,
  },
  props:{
    header:{title: '控制面板'},
  }
},{
  name: 'admin-users',
  path: '/admin/user',
  components:{
    default: require('./components/admin_users.vue'),
    header: admin_header,
  },
  props:{
    header:{ title: '用户管理'}
  }
},{
  name: 'admin-user',
  path: '/admin/user/:user',
  components: {
    default: require('./components/admin_user.vue'),
    header: admin_header,
  },
  props: {
    header: {title: '用户管理'}
  }
},{
  name: 'admin-stations',
  path: '/admin/station',
  components: {
    default: require('./components/admin_stations.vue'),
    header: admin_header,
  },
  props: {
    header: {title: '站点管理'}
  }
},
{
  name: 'admin-station',
  path: '/admin/station/:station',
  components: {
    default: require('./components/admin_station.vue'),
    header: admin_header,
  },
  children: [
  {
    path: '',
    component: require('./components/admin_devices.vue'),
    props:  true,
  }
  ],
  props: {
    header: {title: '站点管理'}
  }
},
{
  name: 'admin-app',
  path: '/admin/app',
  components: {
    default: require('./components/apps.vue'),
    header: admin_header,
  },
  props: {
    header: {title: '生产线管理'}
  }
},
{
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
},
{
  name: 'admin-device',
  path: '/admin/station/:station/device/:device',
  components: {
    default: require('./components/admin_device.vue'),
    header: header,
  },
  props: {
    header: {title: '设备信息'}
  }
},
{
  name: 'users',
  path: '/user',
  components:{
    default: require('./components/users.vue'),
    header: header,
  },
  props:{
    header:{ title: '用户管理'}
  }
},
{
  name: 'user',
  path: '/user/:user',
  components: {
    default: require('./components/user.vue'),
    header: header,
  },
  props: {
    header: {title: '用户管理'}
  }
},{
  name: 'admin-stations',
  path: '/admin/station',
  components: {
    default: require('./components/admin_stations.vue'),
    header: admin_header,
  },
  props: {
    header: {title: '站点管理'}
  }
},
{
  name: 'admin-station',
  path: '/admin/station/:station',
  components: {
    default: require('./components/admin_station.vue'),
    header: admin_header,
  },
  children: [
  {
    path: '',
    component: devices,
    props:  true,
  }
  ],
  props: {
    header: {title: '站点管理'}
  }
},
{
  name: 'admin-app',
  path: '/admin/app',
  components: {
    default: require('./components/apps.vue'),
    header: admin_header,
  },
  props: {
    header: {title: '生产线管理'}
  }
},
{
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

},{
  name: 'invitations',
  path: '/invitation',
  components: {
    default: invitations,
    header: header,
  },
  props: {
    header: {title: '邀请码列表'},
  }
},  ]
module.exports = routes

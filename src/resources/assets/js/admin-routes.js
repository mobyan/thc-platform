import dashboard from './components/dashboard.vue'
import stations from './components/stations.vue'
import station from './components/station.vue'
import header from './components/header.vue'
import admin_header from './components/admin_header.vue'
import header_none from './components/header_none.vue'
import devices from './components/devices.vue'
import analyze from './components/analyze.vue'
import user from './components/user.vue'


const routes = [{
  path: '/',
  redirect: '/admin/app'
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
} ]
module.exports = routes

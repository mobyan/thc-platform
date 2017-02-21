import dashboard from './components/dashboard.vue'
import stations from './components/stations.vue'
import station from './components/station.vue'
import header from './components/header.vue'
import devices from './components/devices.vue'
import analyze from './components/analyze.vue'

const routes = [{
  path: '/station',
  components: {
    default: stations,
    header: header,
  },
  props: {
    header: {title: '站点列表'},
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
  path: '/station/:station/device/:device/data',
  components: {
    default: require('./components/analyze.vue'),
    header: header,
  },
  props: {
    header: {title: '数据分析'}
  }
}, ]
module.exports = routes
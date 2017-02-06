@extends('layouts.app')

@section('content')
<div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
<div id="header" style="width: 90%;margin: auto;">
  <div id="title">
    <h3>Station 列表</h3>
    <!-- <h3>xxxxxx</h3> -->
  </div>
</div>
</div>
<pre id="csv" style="display:none">Year,Annual mean,5 year mean
1880,-0.31,
1881,-0.22,
1882,-0.28,-0.29
1883,-0.3,-0.29
1884,-0.33,-0.3
1885,-0.32,-0.32
1886,-0.29,-0.32
1887,-0.35,-0.28
1888,-0.28,-0.3
1889,-0.18,-0.3
1890,-0.4,-0.3
1891,-0.29,-0.31
1892,-0.33,-0.34
1893,-0.34,-0.32
1894,-0.35,-0.3
1895,-0.27,-0.26
1896,-0.19,-0.26
1897,-0.16,-0.22
1898,-0.3,-0.19
1899,-0.19,-0.19
1900,-0.11,-0.21
1901,-0.18,-0.22
1902,-0.28,-0.25
1903,-0.32,-0.28
1904,-0.36,-0.29
1905,-0.27,-0.32
1906,-0.22,-0.33
1907,-0.42,-0.33
1908,-0.36,-0.35
1909,-0.37,-0.38
1910,-0.36,-0.36
1911,-0.37,-0.36
1912,-0.34,-0.32
1913,-0.34,-0.27
1914,-0.17,-0.25
1915,-0.11,-0.26
1916,-0.31,-0.27
1917,-0.39,-0.28
1918,-0.35,-0.3
1919,-0.22,-0.27
1920,-0.22,-0.24
1921,-0.16,-0.22
1922,-0.27,-0.22
1923,-0.23,-0.22
1924,-0.24,-0.2
1925,-0.19,-0.18
1926,-0.04,-0.16
1927,-0.17,-0.17
1928,-0.15,-0.15
1929,-0.29,-0.15
1930,-0.11,-0.14
1931,-0.04,-0.15
1932,-0.1,-0.12
1933,-0.22,-0.12
1934,-0.1,-0.13
1935,-0.15,-0.1
1936,-0.07,-0.04
1937,0.04,-0.02
1938,0.08,0.01
1939,-0.01,0.04
1940,0.02,0.04
1941,0.08,0.04
1942,0.01,0.07
1943,0.08,0.08
1944,0.18,0.05
1945,0.05,0.05
1946,-0.07,0.02
1947,-0.01,-0.03
1948,-0.05,-0.07
1949,-0.07,-0.07
1950,-0.17,-0.07
1951,-0.05,-0.04
1952,0.01,-0.05
1953,0.09,-0.04
1954,-0.11,-0.06
1955,-0.12,-0.05
1956,-0.19,-0.05
1957,0.08,-0.02
1958,0.08,0
1959,0.05,0.05
1960,-0.01,0.05
1961,0.07,0.04
1962,0.03,-0.01
1963,0.07,-0.03
1964,-0.21,-0.05
1965,-0.12,-0.06
1966,-0.03,-0.08
1967,0,-0.02
1968,-0.04,0.01
1969,0.08,-0.01
1970,0.03,-0.01
1971,-0.1,0.03
1972,0,0
1973,0.15,-0.01
1974,-0.07,-0.02
1975,-0.03,0.01
1976,-0.15,-0.02
1977,0.14,0.02
1978,0.03,0.07
1979,0.1,0.15
1980,0.2,0.14
1981,0.27,0.18
1982,0.06,0.18
1983,0.27,0.15
1984,0.1,0.13
1985,0.06,0.17
1986,0.13,0.18
1987,0.28,0.2
1988,0.33,0.26
1989,0.21,0.31
1990,0.37,0.28
1991,0.36,0.24
1992,0.13,0.25
1993,0.14,0.26
1994,0.24,0.25
1995,0.4,0.3
1996,0.31,0.39
1997,0.42,0.41
1998,0.59,0.4
1999,0.34,0.44
2000,0.36,0.47
2001,0.5,0.47
2002,0.58,0.5
2003,0.57,0.55
2004,0.49,0.56
2005,0.63,0.57
2006,0.56,0.54
2007,0.59,0.56
2008,0.44,0.56
2009,0.57,0.55
2010,0.64,0.54
2011,0.52,0.59
2012,0.57,0.61
2013,0.62,
2014,0.69,</pre>
<div class="" style="width: 90%;margin: auto;">
  <script type="text/javascript">
    var tplData = {!! json_encode($tplData) !!};
  </script>

<!--   <select v-bind:value="currentDataKey" @change="selectDataKey()">
    <option v-for="dataKey in dataKeys">
      @{{ dataKey }}
    </option>
  </select> -->
  <ul id="example-1">
  total keys: @{{ checkedKeys.length }}
  <li v-for="device in devices" >
    @{{ device.name }}：
    <span  v-for="(v,k) in device.configs[0].data">
      <input type="checkbox" :id="k" name="" :value="k" v-model="checkedKeys"><label> @{{ k }}</label>
    </span>
  </li>
</ul>
    <highcharts v-for="i in checkedKeys" :options="options" ref="highcharts"></highcharts>

</div>
@endsection

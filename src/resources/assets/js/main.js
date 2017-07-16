/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

 window._ = require('lodash');

 /**
  * We'll load jQuery and the Bootstrap jQuery plugin which provides support
  * for JavaScript based Bootstrap features such as modals and tabs. This
  * code may be modified to fit the specific needs of your application.
  */

 window.$ = window.jQuery = require('jquery');

 require('bootstrap-sass');



import { Slider, SliderItem } from 'vue-easy-slider'
 window.sm = new Vue({
   el: '#slider',
   data: function(){
     return {
       list: [
         { url:"/image/tianon/co2.jpg", style:{width: '100%', height: 'auto'} },
         { url:"/image/tianon/banner2.jpg", style:{width: '100%', height: 'auto'} },
         { url:"/image/tianon/banner3.jpg", style:{width: '100%', height: 'auto'} },
       ],
        }
      },
      components: {
        Slider,
        SliderItem
    }

 })

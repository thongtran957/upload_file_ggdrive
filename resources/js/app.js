
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/App.vue'
import Dashboard from './components/Dashboard.vue'
import UploadFile from './components/modules/uploadfile/Index.vue'
import Tutorial from './components/modules/uploadfile/Tutorial.vue'

const router = new VueRouter({
    routes: [ 
        {
            path:'/',
            name:'Dashboard',
            component:Dashboard,
            children : [	
				{
		            path:'/uploadfile',
		            name: 'UploadFile',
		            component: UploadFile,
		        }, 
		        {
		            path:'/tutorial',
		            name: 'Tutorial',
		            component: Tutorial,
		        }, 
		
			]
        },
    ],
});


const app = new Vue({
    el: '#app',
   	template: '<app></app>',
    components: { App },
    router
});

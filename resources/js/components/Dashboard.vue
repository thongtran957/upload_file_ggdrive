<template>
	<div id="app">
	  	<v-app id="inspire">
		    <v-toolbar
		      color="pink"
		      dark
		      app
		      :clipped-left="$vuetify.breakpoint.mdAndUp"
		      fixed
		      class="transparent"
		      flat
		    >
			    <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
			        <span class="hidden-sm-and-down">HKT BLog</span>

			    </v-toolbar-title>
			    <v-toolbar-items class="hidden-sm-and-down">
			    	<v-tab>
				    	<v-list-tile
					        v-for="item in items"
					        :key="item.title"
					        :to="item.link"
					        :exact="item.exact" 
					        class="black--text"
					        active-class="white--text"
					    >     
					        <v-list-tile-content>
					            <v-list-tile-title color="red">{{ item.title }}</v-list-tile-title>
					        </v-list-tile-content>
					    </v-list-tile>
					</v-tab>
			    </v-toolbar-items>
	    	</v-toolbar>
	    	<v-content>
              	<v-container>
                  	<router-view></router-view>
              	</v-container>
            </v-content>
  		</v-app>
	</div>
</template>

<script>
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

 
 Vue.use(Vuetify,{
    iconfont: 'md'
 })
export default {

  	name: 'Dashboard',

	data () {
	    return {
	    	height: $(window).height(),
        	hidden: 'auto',
	    	drawer: null,
	    	items: [
	          { title: 'Tutorial',  link: 'tutorial' },
	          { title: 'Upload File Demo',  link: 'uploadfile' },
	        ]
	    }
	},

	components: {
      	
    },

    methods:{
    	
    }
}
</script>

<style lang="css" scoped>
</style>
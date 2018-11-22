<template>
	<div>
		<v-card>
          	<v-toolbar dark color="pink">
	            <v-toolbar-title>DEMO</v-toolbar-title>
	            <v-spacer></v-spacer>
	            <v-toolbar-items>
	              <v-btn dark flat @click.native="save(item)" :disabled="!item.title ">Save</v-btn>
            	</v-toolbar-items>
      		</v-toolbar>
      		<v-card-text>
	            <v-container grid-list-md>
	                <v-layout wrap>
	                  	<v-flex xs12 class="row">
		                       <v-text-field  label="Title" v-model="item.title" ></v-text-field>
	                  	</v-flex>
	                  	
	                  	<v-flex xs12 class="row">
	                  		<v-flex xs1>
		                      	<label>Image</label>
		                    </v-flex>
		                    <v-flex xs5>
		                    	<input type="file" id="file" ref="myFiles" @change="previewFiles">
		                	  </v-flex>
                      	<v-flex xs3>
                          	<img v-if="preview_url" v-bind:src="preview_url"  class="size-img"/>
                      	</v-flex>
			                	<v-flex xs3 >
			                    	<img v-bind:src="item.link_file" class="size-img" v-if="item.link_file != '' ">
			                	</v-flex>
	                    </v-flex> 
	                  	
	                </v-layout>
	            </v-container>
	        </v-card-text>
            
        </v-card>
        <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" right bottom>
	        {{ snackText }}
	        <v-btn flat @click="snack = false">Close</v-btn>
	    </v-snackbar>
	</div>
</template>

<script>
export default {

  name: 'Index',

  data () {
    return {
    	item:{
        	title : '',
        	link_file: '',
        	name_file:''    
        },
        preview_url:'',
         snack: false,
        snackColor: '',
        snackText: '',
    }
  },
  methods:{
  	previewFiles(){
  		this.item.name_file = this.$refs.myFiles.files[0]
      	this.preview_url =  URL.createObjectURL(this.$refs.myFiles.files[0])
  	},
  	save(item){
  		let formData = new FormData();
        formData.append('file_name', this.item.name_file);
        formData.append('title', this.item.title);
        axios.post('api/add/upload_files', formData)
        .then(response => { 
        	this.preview_url = ''
        	this.item.title = ''
        	this.item.link_file=''
        	this.item.name_file=''
	          this.snack = true,
	          this.snackColor = 'success',
	          this.snackText = 'Data saved'
        })
        .catch(
          error => console.log(error)
        )
  	}
  }
}
</script>

<style lang="css" scoped>
</style>
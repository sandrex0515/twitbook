
<style>

  .imgCircle{
    height:340px;
    width:310px;
    border:none;
    outline:none;
  }
  .user img, h5:hover{
    color:blue;
    cursor:pointer
  }
  
@media only screen and (max-width: 991px) {
.imgRes {
      text-align: center;

}
.imgRes img{
    width:200px;
    height: 200px;
    }

}
.imgRes h5{
  margin-bottom:60px;
}

</style>


<template>
 <div id="todo-list">
<div>
  <b-navbar toggleable="lg" type="dark" variant="primary">
    <b-navbar-brand href="#">TwitBook</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item href="#">Home</b-nav-item>
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        

       

        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template slot="button-content"><em>User</em></template>
          <b-dropdown-item href="#">Profile</b-dropdown-item>
          <b-dropdown-item v-on:click="signOut">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</div>
<br>
  <div class="container col-lg-6">
        <form v-on:submit.prevent="addNewTask"> 
 <div class="form-group">
    <input type="file" class="form-control-file" accept=".png,.jpeg,.jpg" @change="imageChanged" id="exampleFormControlFile1">
  </div>
  <div class="form-group">
    <textarea v-model="post" class="form-control" id="exampleFormControlTextarea1" placeholder="Write your thoughts..." rows="5"></textarea>
  </div>
  <div class="form-group text-right">

    <button type="submit" class="btn btn-light btn-lg text-right">Write</button>
    
  </div>
  <br>
  <p id="errs" class="text-danger" style="font-size:20px;"></p>
  
   

</form>

  </div>
   <div class="container col-lg-8" v-for="(todos) in todos" v-bind:key="todos.id" >
          <hr>
        <div class="row">
          <div class="col-lg-2 user imgRes">
            <img class="img-thumbnail rounded-circle"  :src="todos.user.profilepath">
          </div>
          <div class="col-lg-10 user imgRes" >
            <br>
            <h5>{{todos.user.name}}


                  <h2 class="text-right" v-if="todos.id == auth_id" style="cursor:pointer">
              <button class="btn btn-white">
              <i class="fas fa-user-edit text-success" v-on:click="editPost" title="Edit"></i>  
              </button>
              <button class="btn btn-white">
              <i class="fas fa-trash text-danger" title="Delete" v-on:click="deleteTask(todos.post_id)"></i>
              </button>
              </h2>
            </h5>

          </div>
        </div>
       
        <div class="row imgRes" >
          <div class="col-lg-2">
          </div>
          <div class="col-lg-8" style="margin-top:-50px;">
            <p v-if="!erroredit">{{todos.post}}</p>

             <form v-on:submit.prevent="editTask(todos.post_id ,todos.post)" v-if="erroredit"> 
        
          <div class="form-group" v-if="todos.id == auth_id">
          <textarea v-model="todos.post" class="form-control" id="exampleFormControlTextarea1" placeholder="Write your thoughts..." rows="5"></textarea>
          </div>
            <div class="form-group text-right"  v-if="todos.id == auth_id">

           <button type="submit" class="btn btn-light btn-lg text-right">Save</button>
    
          </div>
            <br>
          <p id="errs" class="text-danger" style="font-size:20px;"></p>
  
   

</form>


          </div>

        </div>
        <div class="row">
          <div class="col-lg-2">
            
          </div>
          <div class="col-lg-8 text-center imgRes1" style="cursor:pointer"  >
              <img class="img-thumbnail " v-if="todos.path" :src="todos.path" style="margin-bottom:10px;">

                <button type="button" v-on:click="likeTask(todos.post_id)" class="btn btn-white rounded-circle">
                <i class="fas fa-heart fa-2x text-white text-danger" v-if="todos.like_user.status == 1"></i>
                <i class="fas fa-heart fa-2x text-white text-danger" v-if="todos.like_user.status == 0"></i>

                  <p>{{todos.like_user.count_like}}</p>

                </button>
         
    

                <button type="button" class="btn btn-white " data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-feather-alt fa-2x text-white"></i>
                        <!-- <p>{{todos.comment_user.count}}</p> -->
                        <p>{{todos.like_user.count_comment}}</p>

                  </button>

         
          </div>
        
          <div class="col-lg-2">
           


          </div>
        </div>
        <br>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
              <div class="col-lg-2">
                <img class="img-thumbnail rounded-circle"  src="1U49D92VSX3pXHNZ.jpg">

              </div>
              <div class="col-lg-8">
                Sandrex Cabrales
              </div>
            </div>
            <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                Sorry i run out of time to do this :(
              <hr>

            </div>
            </div>

      </div>
        <div class="modal-footer">
            <textarea v-model="post" class="form-control" id="exampleFormControlTextarea1" placeholder="Comment..." rows="3"></textarea>
            <button type="submit" class="btn btn-primary">Say</button>

      </div>
   
    </div>
  </div>
</div>
 </div>



</template>

<script>

import axios from 'axios'


export default {
    data() {
        return {
            todos: [],
            liketodos: [],
            auth_id: '',
            id: '',
            names: '',
            email: '',
            password: '',
            bday: '',
            gender: '',
            error: '',
            erroredit: false,
            file: {
                name: '',
                image: ''
            },
            post: ''
        


        }
    },
    mounted() {
        this.getTask()
    },
    methods: {
        getTask() {
            axios({method: 'GET', url: '/api/home'}).then(
                result => {
                    // console.log(result.data)
                    this.todos = result.data[0]
                    this.auth_id = result.data[1];
                    this.liketodos = result.data[2];
                    this.todos.count_like = this.liketodos;
                    // console.log(this.todos);
                    for(var i = 0; i < this.liketodos.length;i++){
                     this.todos.count_like = this.liketodos[i];
                      this.todos.count_like.count_like = this.liketodos[i].count_like;

                    }
                },
                error => {
                    console.error(error)
                }
            )
        },
        addNewTask(){
          
            axios.post('/api/home', {
                
                post: this.post,
                profilepath: this.file
                
                
            }).then(res => {
                this.post = '',
                this.profilepath = ''
                this.getTask();

            })
            .catch(er => {
                console.log(err);
              
                
            })
        },
         imageChanged(e) {
            this.file.name  = e.target.files[0].name;
             var fileReader = new FileReader()

             fileReader.readAsDataURL(e.target.files[0]);

             fileReader.onload = (e) => {   
                 this.file.image = e.target.result;   
             }
         
      },
          deleteTask(post_id){
             if(confirm('Are you sure?')){
                axios.post('api/home/delete', {
                  id : post_id
              }).then(res => {
                this.getTask();
              })  
              .catch(er => {
                console.log(err);
            })
             }
            
          },
          editPost(){
              this.erroredit = true;
          },
          signOut(){
              axios.post('api/home/logout',{

              }).then(res => {
                  alert('See you later Pal');
                   window.location.href = "/";


              }).catch(er => {
                alert('Server Error!');
              })
          },
          editTask(post_id, post){
           
            if(confirm('Are you sure you want to change this?')){
              axios.post('api/home/update', {
                  id : post_id,
                  post: post,
                  profilepath: this.file
            }).then(res => {
                this.erroredit = false;
                this.getTask();

            }).catch(er => {
              alert('Server Error');
            })
          }
    
      
    },
        likeTask(post_id){
            axios.post('api/home/like',{
              id: post_id
            }).then(res => {
              this.getTask();

            }).catch(er=>{
              alert('Server Error');
            })
        }
       
    }
}
</script>
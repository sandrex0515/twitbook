
<style>

  .imgCircle{
    height:340px;
    width:310px;
    border:none;
    outline:none;
  }
</style>
<template>
 <div id="todo-list">
<nav class="navbar navbar-dark bg-primary">
    <a class="navbar-brand" href="#">TwitBook</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#">Profile</a>
   
    </div>
  </div>
</nav>
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
  
   

</form>

  </div>
   <div class="container col-lg-8">
          <hr>
        <div class="row">
          <div class="col-lg-2">
            <img class="img-thumbnail rounded-circle" src="https://static1.squarespace.com/static/5918773d46c3c45c5c7ff4d5/t/5d0291391e38b30001a76196/1566004246555/?format=1500w">
          </div>
          <div class="col-lg-8">
            dwadas
          </div>
          
        </div>
        <div class="row">
          <div class="col-lg-2">

          </div>
          <div class="col-lg-8">
            <p>hi guys i am sandrex</p>
          </div>

        </div>
        <div class="row">
          <div class="col-lg-2">

          </div>
          <div class="col-lg-8">
              <img class="img-thumbnail" src="https://blog.hubspot.com/hubfs/types-of-image-files-extensions.jpg">
          </div>
        
          <div class="col-lg-2">
              <br><br><br><br>  <br><br>
            <div class="row">
                          <i class="fas fa-heart fa-2x text-light"></i>

            </div>
            <br>
              <div class="row">

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-feather-alt fa-2x text-light"></i>
                  </button>

                       

            </div>
         


          </div>
        </div>
        <hr>
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
                <img class="img-thumbnail rounded-circle" src="https://static1.squarespace.com/static/5918773d46c3c45c5c7ff4d5/t/5d0291391e38b30001a76196/1566004246555/?format=1500w">

              </div>
              <div class="col-lg-8">
               sandrex cabrales
              </div>
            </div>
            <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
              i think sooo
              <hr>
            </div>
            </div>

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
            id: '',
            names: '',
            email: '',
            password: '',
            bday: '',
            gender: '',
            error: '',
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
                    console.log(result.data)
                    this.todos = result.data
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
         
      }
    
      
    }
}
</script>
<style>

input[type="text"],input[type="email"],input[type="password"],input[type="date"]
{
    background: #d5e1f5;
     border: none;
    outline: none;
}
.center{
    left: 30%;
    transform: translate(-50%,-50%);
    padding-top:28%;
    margin-top: 10%;
}

@media only screen and (max-width: 1180px) {
.center{
    margin-top:15%;
    }
}
@media only screen and (max-width: 991px) {
.center{
    left: 29%;
    width:60%;
    margin:auto;
    padding:auto;
    }
}

@media only screen and (max-width: 767px) {
    input[type="text"],input[type="email"],input[type="password"],input[type="date"]
    {
    margin: auto;
    }

.center{ 
    width:63%;
    margin-bottom:30%;
}
}
@media only screen and (max-width: 650px) {
 

.center{
    width:60%;
}
}

</style>
<template>
    <div id="todo-list" style="background: radial-gradient(#4287f5, #5576ab);">
        <!-- <h2 class="text-center">Articles</h2> -->
             
    <div class="row">
        <div class="col-md-12 text-center text-white">
            <br>
            <h1>Welcome to TwitBook</h1>
        </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-5 center">
               <br><br><br><br><br><br>
               
                <form v-on:submit.prevent="signIn"> 

                 <div class="form-group">
                     <label for="exampleInputEmail">Email address</label>
                     <input v-model="email" type="email"  style="" class="form-control col-lg-8 text-center" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword">Password</label>
                     <input v-model="password" type="password" class="form-control text-center col-lg-8" id="exampleInputPassword" placeholder="Password" required>
                </div>
              <p id="errs" class="text-danger" style="font-size:20px;"></p>
                <button type="submit" class="btn btn-primary centerbtn">Sign-in</button>
                </form>

            </div>
            <div class="col-lg-1"  style="border-right:1px solid skyblue">
                
            </div>
            <div class="col-lg-6 center">
           <br><br>
                <h3 class="text-dark">Sign up</h3>
            <br>
                <form v-on:submit.prevent="addNewTask"> 
                 <div class="form-group">
                     <label for="exampleInputName">Name</label>
                     <input v-model="names" type="text" style="" class="form-control col-lg-8 text-center" id="exampleInputName" aria-describedby="emailHelp" placeholder="Enter name" required>
                </div>

                 <div class="form-group">
                     <label for="exampleInputEmail1">Email address</label>
                     <input v-model="email" type="email" style="" class="form-control col-lg-8 text-center" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                     <input v-model="password" type="password" class="form-control text-center col-lg-8" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputBirthdate">Birthdate</label>

                    <input v-model="bday" type="date" class="form-control col-lg-8">

                </div>
                   <div class="form-group">
                     <label for="inputState">Gender</label>
                      <select v-model="gender" id="inputState" class="form-control text-center col-lg-5">
                     <option selected disabled>Choose...</option>
                     <option>Male</option>
                     <option>Female</option>
                     </select>
                    </div>
                 <div class="form-group">
                  <div id="app">
                        <div v-if="!image">
                                <h2>Select an image</h2>
                                <input type="file" @change="imageChanged" accept=".png,.jpeg,.jpg">
                        </div>
                        <div v-else>
                                <img :src="image" />
                                 <button @click="removeImage">Remove image</button>
                         </div>
                 </div>
                 </div>
            
                <button type="submit" class="btn btn-primary centerbtn">Sign-up</button>
                </form>
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
            }


        }
    },
    mounted() {
        this.getTask()
    },
    methods: {
        getTask() {
            axios({method: 'GET', url: '/api/tasks'}).then(
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
            axios.post('/api/tasks', {
                names: this.names,
                email: this.email,
                password: this.password,
                bday: this.bday,
                gender: this.gender,
                profilepath: this.file
            }).then(res => {
                this.names = '',
                this.email = '',
                this.password = '',
                this.bday = '',
                this.gender = '',
                this.profilepath = ''
                alert('Success you may now login');
            })
            .catch(er => {
                console.log(err);
            })
        },
        signIn(){
            axios.post('/api/tasks/login', {
                email: this.email,
                password: this.password
            }).then(res => {
                this.email = '',
                this.password = ''
            window.location.href = "home"
            })
            .catch(er => {
                this.error = 'Email or/and password is incorrect'
                $('#errs').empty().show().append(this.error);

                 setTimeout(function(){
                $('#errs').empty().hide();
            }, 3500);

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
<template>
  <v-row justify="center">
    <v-dialog
      v-model="addEmployeeDialog"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add New'}} Employee</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="12"
                    sm="12"
                    md="12"
                >
                    <v-row>
                        <v-col>
                            <v-text-field
                                label="*First Name"
                                required
                                v-model="form.firstname"
                            ></v-text-field> 
                            <v-text-field
                                label="*Last Name"
                                required
                                v-model="form.lastname"
                            ></v-text-field>
                            <v-text-field
                                label="*Phone Number"
                                required
                                v-model="form.phone_number"
                                type="number"
                            ></v-text-field>
                            <v-select
                              :items="['Male', 'Female']"
                              label="*Gender"
                              v-model="form.gender"
                              
                            >
                            </v-select>
                             <v-text-field
                                label="*Age"
                                required
                                v-model="form.age"
                                type="number"
                            ></v-text-field>
                            <v-text-field
                                label="*Email"
                                required
                                v-model="form.email"
                                type="email"
                            ></v-text-field>
                            <v-text-field
                                label="*Password"
                                required
                                v-model="form.password"
                                :type="show_pass ? 'text' : 'password'"
                                :append-icon="show_pass ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="show_pass = !show_pass"
                            ></v-text-field>
                            <p>*indicates required field</p>

                        </v-col>
                    </v-row>
                </v-col>
            
            </v-row>
          </v-container>
       
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            @click="$emit('close')"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('save')"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
  export default {
    props: {
        dialogState: {
            type: Boolean,
            required: true
        },
        form: {
            type: Object,
            required: true,
            default: {
                id:null,
                firstname: '',
                lastname: '',
                phone_number: '',
                gender: '',
                age: '',
                email: '',
                password: '',
                type:2
                // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
            }
        }
    },
    data: () => ({
      dialog: false,
      show_pass: false,
    }),
    methods : {
        // processImage(e){
      
        //   var fileReader = new FileReader()
        //   fileReader.readAsDataURL(e.target.files[0])
        //   fileReader.onload = (e) => {
        //     this.form.image = e.target.result
        //   }
        // },
    },
    mouted(){
        
    },
    computed : {
        addEmployeeDialog(){
            return this.dialogState
        }
    }
    
  }
</script>
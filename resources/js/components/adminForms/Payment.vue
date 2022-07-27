<template>
  <v-row justify="center">
    <v-dialog
      v-model="addPaymentDialog"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add New'}} Payment</span>
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
                            <v-autocomplete
                                :items="items"
                                item-value= "id"
                                :filter="userFilter"
                                label="Search Customer"
                                hide-no-data
                                v-model="form.customer_id"

                            >
                                <template v-slot:item ="{item}">
                                    {{item.firstname}} {{item.lastname}}
                                </template>
                                <template v-slot:selection ="{item}">
                                    {{item.firstname}} {{item.lastname}}
                                </template>
                            </v-autocomplete>
                            <v-text-field
                                label="*Payment For"
                                required
                                v-model="form.payment_for"
                            ></v-text-field>
                            <v-text-field
                                label="*Amount" 
                                required
                                v-model="form.amount"
                            ></v-text-field>
                            <v-menu
                              v-model="date_pick"
                              :close-on-content-click="false"
                              :nudge-right="40"
                              transition="scale-transition"
                              offset-y
                              min-width="auto"
                            >
                              <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                  v-model="form.date"
                                  label="*Date"
                                  prepend-icon="mdi-calendar"
                                  readonly
                                  color="light-blue"
                                  v-bind="attrs"
                                  v-on="on"
                                ></v-text-field>
                              </template>
                              <v-date-picker
                                color="light-blue"
                                v-model="form.date"
                                @input="date_pick = false"
                              ></v-date-picker>
                            </v-menu>  
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
                customer_id:'',
                payment_for: '',
                amount: '',
                date: '',
                // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
            }
        }
    },
    data: () => ({
      items:[],
      dialog: false,
      show_pass: false,
      date_pick: false,
    }),
    methods : {
        // processImage(e){
      
        //   var fileReader = new FileReader()
        //   fileReader.readAsDataURL(e.target.files[0])
        //   fileReader.onload = (e) => {
        //     this.form.image = e.target.result
        //   }
        // },

        initialize(){
            this.$admin.get('api/customer/index').then(({data})=> {
                this.items = data
          
            })
        },
        userFilter (item, queryText, itemText) {
            const textOne = item.firstname.toLowerCase()
            const textTwo = item.lastname.toLowerCase()
            const searchText = queryText.toLowerCase()

            return textOne.indexOf(searchText) > -1 ||
            textTwo.indexOf(searchText) > -1
        },       
    },
    mounted(){
        this.initialize()
    },
    computed : {
        addPaymentDialog(){
            return this.dialogState
        }
    }
    
  }
</script>
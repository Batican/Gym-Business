<template>
  <v-row justify="center">
    <v-dialog
      v-model="addSubscriptionDialog"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add New'}} Subscription</span>
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
                                v-if="!form.id"

                            >
                                <template v-slot:item ="{item}">
                                    {{item.firstname}} {{item.lastname}}
                                </template>
                                <template v-slot:selection ="{item}">
                                    {{item.firstname}} {{item.lastname}}
                                </template>
                            </v-autocomplete>

                            <v-autocomplete
                                :items="plans"
                                :filter="membershipFilter"
                                item-text="name"
                                label="Search Membership Plan"
                                hide-no-data
                                return-object
                                @change="(event)=>change(event)"
                                v-model="form.name"

                            >
                            </v-autocomplete>

                            <v-text-field
                                label="Subscription Fee (Per Day)" 
                                required
                                v-model="form.subscription_fee"
                                disabled
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
                                  v-model="form.start_date"
                                  label="*Start Date"
                                  prepend-icon="mdi-calendar"
                                  readonly
                                  color="light-blue"
                                  v-bind="attrs"
                                  v-on="on"
                                ></v-text-field>
                              </template>
                              <v-date-picker
                                color="light-blue"
                                v-model="form.start_date"
                                @input="date_pick = false"
                              ></v-date-picker>
                            </v-menu>  

                            <v-menu
                              v-model="date_pick2"
                              :close-on-content-click="false"
                              :nudge-right="40"
                              transition="scale-transition"
                              offset-y
                              min-width="auto"
                            >
                              <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                  v-model="form.end_date"
                                  label="*End Date"
                                  prepend-icon="mdi-calendar"
                                  readonly
                                  color="light-blue"
                                  v-bind="attrs"
                                  v-on="on"
                                ></v-text-field>
                              </template>
                              <v-date-picker
                                color="light-blue"
                                v-model="form.end_date"
                                @input="date_pick2 = false"
                              ></v-date-picker>
                            </v-menu>

                             <v-select
                              :items="status"
                              item-text="text"
                              item-value="id"
                              label="*Status"
                              v-model="form.status"
                            >
                            </v-select>  
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
              customer_id:'',
              membership_id:'',
              start_date: '',
              end_date: '',
              status:'',  
                // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
            }
        }
    },
    data: () => ({
      items:[],
      plans:[],
      dialog: false,
      date_pick: false,
      date_pick2: false,
      show_pass: false,
      subscription_fee:'',

      status:[
        { 
          id: 1,
          text: 'Paid'
        },
        { 
          id: 2,
          text: 'Unpaid'
        },
      ]

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

            this.$admin.get('api/membership/index').then(({data})=> {
                this.plans = data
          
            })
        },

        userFilter (item, queryText, itemText) {
            const textOne = item.firstname.toLowerCase()
            const textTwo = item.lastname.toLowerCase()
            const searchText = queryText.toLowerCase()

            return textOne.indexOf(searchText) > -1 ||
            textTwo.indexOf(searchText) > -1
        },
        
        membershipFilter (item, queryText, itemText) {
          const textOne = item.name.toLowerCase()
          const searchText = queryText.toLowerCase()

          return textOne.indexOf(searchText) > -1 
        },
        
        change(item){
          this.form.membership_id = item.id
          this.form.subscription_fee = item.fee
        },
    },
    mounted(){
        this.initialize()
    },
    computed : {
        addSubscriptionDialog(){
            return this.dialogState
        }
    }
    
  }
</script>
<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Customers
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addCustomer"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="customers"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.name="{item}">
          {{item.firstname}} {{item.lastname}}
        </template>
        <template v-slot:item.actions="{item}">
          <v-icon
            class="mr-2"
            @click="editCustomer(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteCustomer(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <CustomerForm :form="customerForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveCustomer()" />

</div>
</template>
<script>
  import CustomerForm from '../../components/adminForms/Customer.vue'
  export default {
    components: {
      CustomerForm
    },
    data() {
      return {
        customers: [],
        loading: true,
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          {
            text: 'ID',
            align: 'center',
            sortable: false,
            value: 'id',
          },
          { text: "Name", value: "name", align: 'center', },
          { text: "Phone Number", value: "phone_number", align: 'center', },
          { text: "Gender", value: "gender", align: 'center', },
          { text: "Age", value: "age", align: 'center', },
          { text: "Email", value: "email", align: 'center', },
          { text: "Actions", value: "actions", sortable: false, align: 'center', },
        ],
        addition_edition_dailog: false,
        customerForm: {
          id:null,
          firstname: '',
          lastname: '',
          phone_number: '',
          gender: '',
          age: '',
          email: '',
          password: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
      };
  },
  //this one will populate new data set when user changes current page. 
  watch: {
    options: {
      handler(val) {
        this.initialize() 
      },
    },
    deep: true,
  },

  //this will trigger in the onReady State
  mounted() {
    this.initialize();
  },

  methods: {
    //Reading data from API method. 
    initialize() {
        this.customerForm = {
          id:null,
          firstname: '',
          lastname: '',
          phone_number: '',
          gender: '',
          age: '',
          email: '',
          password: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/customer/index').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.customers = data;
          });
    },
    addCustomer(){
      this.customerForm = {
        id:null,
        firstname: '',
        lastname: '',
        phone_number: '',
        gender: '',
        age: '',
        email: '',
        password: '',
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editCustomer(customer){
      this.customerForm = {
        id: customer.id,
        firstname:  customer.firstname ,
        lastname:  customer.lastname ,
        phone_number:  customer.phone_number ,
        gender:  customer.gender ,
        age:  customer.age ,
        email:  customer.email ,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveCustomer(){
      // return;
      if(this.customerForm.id){
        this.$admin.post('api/customer/update/'+this.customerForm.id,this.customerForm).then(({data}) => {
          this.initialize()
          this.successNotify('Updated Customer');
        })
      }
      else{
        this.$admin.post('api/customer/create',this.customerForm).then(({data}) =>{
          this.initialize()
          this.successNotify('Created Customer');
        })
      }
    },
    async deleteCustomer(customer){
      let confirm = await this.deleteRecord(customer.firstname);

      this.$admin.delete('api/customer/delete/'+ customer.id).then(({data}) => {
        if(data.error){
          this.errorNotify(data.error)
          return
        }
        this.initialize()
        this.successNotify('Deleted Customer');

      })
    }
  },
  
 
  }
</script>
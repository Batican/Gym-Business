<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Employees
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addEmployee"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="employees"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.name="{item}">
          {{item.firstname}} {{item.lastname}}
        </template>

        <template v-slot:item.actions="{item}">
          <v-icon
            class="mr-2"
            @click="editEmployee(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteEmployee(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <EmployeeForm :form="employeeForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveEmployee()" />

</div>
</template>
<script>
  import EmployeeForm from '../../components/adminForms/Employee.vue'
  export default {
    components: {
      EmployeeForm
    },
    data() {
      return {
        employees: [],
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
        employeeForm: {
          id:null,
          firstname: '',
          lastname: '',
          phone_number: '',
          gender: '',
          age: '',
          email: '',
          password: '',
          type:2,
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
        this.employeeForm = {
          id:null,
          firstname: '',
          lastname: '',
          phone_number: '',
          gender: '',
          age: '',
          email: '',
          password: '',
          type:2,
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/user/employeeIndex').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.employees = data;
          });
    },
    addEmployee(){
      this.employeeForm = {
        id:null,
        firstname: '',
        lastname: '',
        phone_number: '',
        gender: '',
        age: '',
        email: '',
        password: '',
        type:2,
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editEmployee(employee){
      this.employeeForm = {
        id: employee.id,
        firstname:  employee.firstname ,
        lastname:  employee.lastname ,
        phone_number:  employee.phone_number ,
        gender:  employee.gender ,
        age:  employee.age ,
        email:  employee.email ,
        type:2,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveEmployee(){
      // return;
      if(this.employeeForm.id){
        this.$admin.post('api/user/update/'+this.employeeForm.id,this.employeeForm).then(({data}) => {
          this.initialize()
          this.successNotify('Updated Employee');
        })
      }
      else{
        this.$admin.post('api/user/create',this.employeeForm).then(({data}) =>{
          this.initialize()
          this.successNotify('Created Employee');
        })
      }
    },
    async deleteEmployee(employee){
      let confirm = await this.deleteRecord(employee.firstname);

      this.$admin.delete('api/user/delete/'+ employee.id).then(({data}) => {
        if(data.error){
          this.errorNotify(data.error)
          return
        }
        this.initialize() 
        this.successNotify('Deleted Employee');

      })
    }
  },
  
 
  }
</script>
<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Administrators
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addAdmin"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="admins"
        :loading="loading"
        class="elevation-1"
      >
         <template v-slot:item.name="{item}">
          {{item.firstname}} {{item.lastname}}
        </template>

        <template v-slot:item.actions="{item}">
          <v-icon
            class="mr-2"
            @click="editAdmin(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteAdmin(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <AdminForm :form="adminForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveAdmin()" />

</div>
</template>
<script>
  import AdminForm from '../../components/adminForms/Admin.vue'
  export default {
    components: {
      AdminForm
    },
    data() {
      return {
        admins: [],
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
        adminForm: {
          id:null,
          firstname: '',
          lastname: '',
          phone_number: '',
          gender: '',
          age: '',
          email: '',
          password: '',
          type:1,
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
        this.adminForm = {
          id:null,
          firstname: '',
          lastname: '',
          phone_number: '',
          gender: '',
          age: '',
          email: '',
          password: '',
          type:1,
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/user/adminIndex').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.admins = data;
          });
    },
    addAdmin(){
      this.adminForm = {
          id:null,
          firstname: '',
          lastname: '',
          phone_number: '',
          gender: '',
          age: '',
          email: '',
          password: '',
          type:1,
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editAdmin(admin){
      this.adminForm = {
        id: admin.id,
        firstname:  admin.firstname ,
        lastname:  admin.lastname ,
        phone_number:  admin.phone_number ,
        gender:  admin.gender ,
        age:  admin.age ,
        email:  admin.email ,
        type:1,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveAdmin(){
      // console.log(this.adminForm)
      // return;
      if(this.adminForm.id){
        this.$admin.post('api/user/update/'+this.adminForm.id,this.adminForm).then(({data}) => {
          this.initialize()
          this.successNotify('Updated Admin');
        })
      }
      else{
        this.$admin.post('api/user/create',this.adminForm).then(({data}) =>{
          this.initialize()
          this.successNotify('Created Admin');
        })
      }
    },
    async deleteAdmin(admin){
      let confirm = await this.deleteRecord(admin.name);
      
      if(data.error){
        this.errorNotify(data.error)
        return
      }
      this.$admin.delete('api/user/delete/'+ admin.id).then(({data}) => {
        this.initialize() 
        this.successNotify('Deleted Admin');
      })
    }
  },
  
 
  }
</script>
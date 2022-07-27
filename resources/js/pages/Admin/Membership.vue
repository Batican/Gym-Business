<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Memberships
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addMembership"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="memberships"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.actions="{item}">
          
          <v-icon
            class="mr-2"
            @click="editMembership(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteMembership(item)"
          >
            mdi-delete
          </v-icon>
          
        </template>
      </v-data-table>
    </v-card>
    <MembershipForm :form="membershipForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveMembership()" />
</div>
</template>
<script>
  import MembershipForm from '../../components/adminForms/Membership.vue'
  export default {
    components: {
      MembershipForm
    },
    data() {
      return {
        memberships: [],
        qr_code:{},
        loading: true,
        showDialog: false,
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
          { text: "Membership Plan", value: "name", align: 'center', },
          { text: "Membership Fee (Per Day)", value: "fee", align: 'center', },
          { text: "Actions", value: "actions", sortable: false, align: 'center', },
        ],
        addition_edition_dailog: false,
        membershipForm: {
            id:null,
            name: '',
            fee: '',
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
        this.membershipForm = {
            id:null,
            name: '',
            fee: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/membership/index').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.memberships = data;
          });
    },
    addMembership(){
      this.membershipForm = {
        id:null,
        name: '',
        fee:''
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editMembership(membership){
      this.membershipForm = {
        id: membership.id,
        name:  membership.name ,
        fee:  membership.fee ,
       
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },

    saveMembership(){
      // return;
      if(this.membershipForm.id){
        this.$admin.post('api/membership/update/'+this.membershipForm.id,this.membershipForm).then(({data}) => {
          this.initialize()
          this.successNotify('Updated Membership');
        })
      }
      else{
        this.$admin.post('api/membership/create',this.membershipForm).then(({data}) =>{
          this.initialize()
          this.successNotify('Created Membership');
        })
      }
    },

    async deleteMembership(membership){
      let confirm = await this.deleteRecord(membership.name);

      this.$admin.delete('api/membership/delete/'+ membership.id).then(({data}) => {
         if(data.error){
          this.errorNotify(data.error)
          return
        }
        this.initialize() 
        this.successNotify('Deleted Membership');

      })
    }
  },
  
 
  }
</script>
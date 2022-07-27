<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Subscriptions
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addSubscription"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="subscriptions"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.name ="{ item }">
            {{item.customer.firstname}} {{item.customer.lastname}}
        </template>

        <template v-slot:item.status ="{ item }">
            {{item.status == 1 ? 'Paid' : 'Unpaid'}}
        </template>

        <template v-slot:item.actions="{item}">
          <v-btn v-if="item.status == 2" class="mr-2" x-small color="success" @click="showDialog = true, payment(item)">
            Pay
          </v-btn>
          <v-icon
            class="mr-2"
            @click="editSubscription(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteSubscription(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <SubscriptionForm :form="subscriptionForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveSubscription()" />
</div>
</template>
<script>
  import SubscriptionForm from '../../components/adminForms/Subscription.vue'
  export default {
    components: {
      SubscriptionForm
    },
    data() {
      return {
        subscriptions: [],
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
          { text: "Customer Name", value: "name", align: 'center', },
          { text: "Membership Plan", value: "membership.name", align: 'center', },
          { text: "Subscription Fee (Per Day)", value: "membership.fee", align: 'center', },
          { text: "Start Date", value: "start_date", align: 'center', },
          { text: "Expires On", value: "end_date", align: 'center', },
          { text: "Total Fee", value: "total", align: 'center', },
          { text: "Status", value: "status", align: 'center', },
          { text: "Actions", value: "actions", sortable: false, align: 'center', },
        ],
        addition_edition_dailog: false,
        subscriptionForm: {
            id:null,
            customer_id:'',
            membership_id:'',
            start_date: '',
            end_date: '',
            status:''
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        },

        paymentForm: {
          id:null,
          customer_id:'',
          amount:''
          
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
        this.subscriptionForm = {
            id:null,
            customer_id:'',
            membership_id:'',
            start_date: '',
            end_date: '',
            status:'',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/subscription/index').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.subscriptions = data;
          });
    },
    addSubscription(){
      this.subscriptionForm = {
        id:null,
        customer_id:'',
        membership_id:'',
        start_date: '',
        end_date: '',
        status:'',
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editSubscription(subscription){
      this.subscriptionForm = {
        id: subscription.id,
        customer_id:subscription.customer.id,
        name:  subscription.membership.name ,
        subscription_fee:  subscription.membership.fee ,
        start_date:  subscription.start_date ,
        end_date:  subscription.end_date,
        status: subscription.status,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
        console.log(subscription);
    },
    saveSubscription(){
      // return;
      if(this.subscriptionForm.id){
        this.$admin.post('api/subscription/update/'+this.subscriptionForm.id,this.subscriptionForm).then(({data}) => {
          this.initialize()
          this.successNotify('Updated Subscription');
        })
      }
      else{
        this.$admin.post('api/subscription/create',this.subscriptionForm).then(({data}) =>{
          this.initialize()
          this.successNotify('Created Subscription');
        })
      }
    },
    async deleteSubscription(subscription){
      let confirm = await this.deleteRecord(subscription.customer.firstname);

      this.$admin.delete('api/subscription/delete/'+ subscription.id).then(({data}) => {
        if(data.error){
          this.errorNotify(data.error)
          return
        }
        this.initialize() 
        this.successNotify('Deleted Subscription');

      })
     

    },

    payment(subscription){
      this.paymentForm = {
        id: subscription.id,
        customer_id:subscription.customer.id,
        amount:  subscription.total ,
      }

      this.$admin.post('api/payment/subscription_payment',this.paymentForm).then(({data}) =>{
        this.initialize()
        this.successNotify('Paid');
      })

    }
  },
  
 
  }
</script>
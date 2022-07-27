<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Payments
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addPayment"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="payments"
        :loading="loading"
        class="elevation-1"
      >
         <template v-slot:item.name ="{ item }">
            {{item.customer.firstname}} {{item.customer.lastname}}
        </template>

        <template v-slot:item.actions="{item}">
          
          <v-icon
            class="mr-2"
            @click="editPayment(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deletePayment(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <PaymentForm :form="paymentForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,savePayment()" />
</div>
</template>
<script>
  import PaymentForm from '../../components/adminForms/Payment.vue'
  export default {
    components: {
      PaymentForm
    },
    data() {
      return {
        payments: [],
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
          { text: "Payment for", value: "payment_for", align: 'center', },
          { text: "Amount", value: "amount", align: 'center', },
          { text: "Name of Customer", value: "name", align: 'center', },
          { text: "Date", value: "date", align: 'center', },
          { text: "Actions", value: "actions", sortable: false, align: 'center', },
        ],
        addition_edition_dailog: false,
        paymentForm: {
            id:null,
            customer_id:'',
            payment_for: '',
            amount: '',
            date: '',
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
        this.paymentForm = {
            id:null,
            customer_id:'',
            payment_for: '',
            amount: '',
            date: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/payment/index').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.payments = data;
          });
    },
    addPayment(){
      this.paymentForm = {
        id:null,
        customer_id:' ',
        payment_for: '',
        amount: '',
        date: '',
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editPayment(payment){
      this.paymentForm = {
        id: payment.id,
        customer_id:  payment.customer_id ,
        payment_for:  payment.payment_for ,
        amount:  payment.amount ,
        date:  payment.date,
       
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    savePayment(){
      // return;
      if(this.paymentForm.id){
        this.$admin.post('api/payment/update/'+this.paymentForm.id,this.paymentForm).then(({data}) => {
          this.initialize()
          this.successNotify('Updated Payment');
        })
      }
      else{
        this.$admin.post('api/payment/create',this.paymentForm).then(({data}) =>{
          this.initialize()
          this.successNotify('Created Payment');
        })
      }
    },
    async deletePayment(payment){
      let confirm = await this.deleteRecord(payment.payment_for);

      this.$admin.delete('api/payment/delete/'+ payment.id).then(({data}) => {
        if(data.error){
          this.errorNotify(data.error)
          return
        }
        this.initialize() 
        this.successNotify('Deleted Payment');

      })
    }
  },
  
 
  }
</script>
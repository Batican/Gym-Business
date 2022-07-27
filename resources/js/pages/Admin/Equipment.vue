<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Equipments
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addEquipment"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="equipments"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.actions="{item}">
          <v-btn class="mr-2" x-small color="success" @click="showDialog = true, generate(item)">
            View QR
          </v-btn>
          <v-icon
            class="mr-2"
            @click="editEquipment(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteEquipment(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <EquipmentForm :form="equipmentForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveEquipment()" />
    <v-row justify="center">
      <v-dialog
          v-model="showDialog"
          persistent
          max-width="290"
      >
        <v-card>
          <v-card-title class="primary headline" style="font-weight:bold; color:white;">
              QR Code
              <v-spacer></v-spacer>
                <v-icon color="white" @click="showDialog = false" >
                    mdi-close-circle-outline
                </v-icon>
          </v-card-title>
          <v-card-text class="mt-4">Please Take a Pic or Screenshot this.</v-card-text>
          <v-card-actions>
                <div class="mt-5 mb-5 mx-auto " v-html="qr_code"></div>
          </v-card-actions>
      </v-card>
      </v-dialog>
    </v-row>
</div>
</template>
<script>
  import EquipmentForm from '../../components/adminForms/Equipment.vue'
  export default {
    components: {
      EquipmentForm
    },
    data() {
      return {
        equipments: [],
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
          { text: "Name", value: "name", align: 'center', },
          { text: "Date for Checking", value: "date_for_checking", align: 'center', },
          { text: "Actions", value: "actions", sortable: false, align: 'center', },
        ],
        addition_edition_dailog: false,
        equipmentForm: {
            id:null,
            name: '',
            description: '',
            date_for_checking: '',
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
        this.equipmentForm = {
            id:null,
            name: '',
            description: '',
            date_for_checking: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/equipment/index').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.equipments = data;
          });
    },
    addEquipment(){
      this.equipmentForm = {
        id:null,
        name: '',
        description: '',
        date_for_checking: '',
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editEquipment(equipment){
      this.equipmentForm = {
        id: equipment.id,
        name:  equipment.name ,
        description:  equipment.description ,
        date_for_checking:  equipment.date_for_checking ,
       
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveEquipment(){
      // return;
      if(this.equipmentForm.id){
        this.$admin.post('api/equipment/update/'+this.equipmentForm.id,this.equipmentForm).then(({data}) => {
          this.initialize()
          this.successNotify('Updated Equuipment');
        })
      }
      else{
        this.$admin.post('api/equipment/create',this.equipmentForm).then(({data}) =>{
          this.initialize()
          this.successNotify('Created Equipment');
        })
      }
    },
    generate(equipment){
      this.$admin.get('api/equipment/generate/'+ equipment.id).then(({data}) => {
        this.qr_code =  data
      })
    },

    async deleteEquipment(equipment){
      let confirm = await this.deleteRecord(equipment.name);

      this.$admin.delete('api/equipment/delete/'+ equipment.id).then(({data}) => {
          if(data.error){
          this.errorNotify(data.error)
          return
        }
        this.initialize() 
        this.successNotify('Deleted Equipment');

      })
    }
  },
  
 
  }
</script>
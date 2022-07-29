<template>
      <div class="m-2">
        <v-card
            class="mx-auto px-5 py-5"
            outlined
        >
            <v-card-text>
                <v-row> 
                    <v-col cols=4>
                        <v-card elevation="3" @click="goTo('/employees')">
                            <v-card-text>
                                <div class="d-flex justify-space-between mx-2">
                                    <div >
                                        <v-icon color="#428C47" style="font-size:100px">
                                            mdi-account-multiple
                                        </v-icon>
                                    </div>
                                    <div class="mt-3">
                                        <div class="text-right text-subtitle-1">
                                            Employees
                                        </div>
                                        <p class="text-right text-h4">
                                           {{statistics.employees}}
                                        </p>
                                    </div>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols=4>
                        <v-card elevation="3" @click="goTo('/students')">
                            <v-card-text>
                                <div class="d-flex justify-space-between mx-2">
                                    <div >
                                        <v-icon color="secondary" style="font-size:100px">
                                            mdi-account
                                        </v-icon>
                                    </div>
                                    <div class="mt-3">
                                        <div class="text-right text-subtitle-1">
                                            Customers
                                        </div>
                                        <p class="text-right text-h4">
                                            {{statistics.customers}}
                                        </p>
                                    </div>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols=4>
                        <v-card elevation="3" @click="goTo('/class-details')">
                            <v-card-text>
                                <div class="d-flex justify-space-between mx-2">
                                    <div >
                                        <v-icon color="accent" style="font-size:100px">
                                            mdi-dumbbell
                                        </v-icon>
                                    </div>
                                    <div class="mt-3">
                                        <div class="text-right text-subtitle-1">
                                            Equipments
                                        </div>
                                        <p class="text-right text-h4">
                                           {{statistics.equipments}}
                                        </p>
                                    </div>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols=12>
                        <v-card elevation="5">
                            <v-card-text>
                                <h1 class="text-xl font-semibold">Sales</h1>
                                <apexchart 
                                    height="350" 
                                    type="line" 
                                    :options="chartOptions" 
                                    :series="series"
                                ></apexchart>    
                            </v-card-text>
                          
                        </v-card>
                    </v-col>
                    
                </v-row>
                <v-row>
                    <v-col cols=12>
                        <v-alert
                            class="mx-auto"
                            border="top"
                            colored-border
                            color="#304F8C"
                            elevation="2"
                        >
                            <p class="text-h5 text-center pt-2">Equipments Needs to Check Today</p>
                            <v-data-table
                                    :headers="equipmentsHeaders"
                                    :items="equipments"
                                    item-key="name"
                                    :items-per-page="5"
                                    class="elevation-1"
                                   
                                    >

                                    <template v-slot:item.actions="{item}">
                                        <v-btn class="mr-2" x-small color="success" @click="showDialog = true, generate(item)">
                                            View QR
                                        </v-btn>
                                    </template>

                                    
                            </v-data-table>
                        </v-alert>
                    </v-col>
                </v-row>    
            </v-card-text>
        </v-card>
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
export default {
    data : () => ({

        showDialog: false,
        qr_code:{},
        equipments:[],
        statistics: {
            employees: 0,
            customers:0,
            equipments:0,
        },
            
       chartOptions: {
          chart: {
                width: "100%",
                toolbar: {
                    show: false
                },
                height: 350,
                zoom: {
                    enabled: false
                },
                dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
              },
            },
            colors: ['#0d6efd'],
            dataLabels: {
                enabled: true
            },
              stroke: {
                curve: "smooth"
            },
            grid: {
              borderColor: '#e7e7e7',
              row: {
                colors: ['gray', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
                },
            },
            markers: {
              size: 1
            },
            xaxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec',
                ],
                title: {
                text: 'Month'
              }
            },
            yaxis: {
              title: {
                text: 'Sales'
              },
            },
            
      },
      series: [
        {
          name: "Sales",
          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        }
      ],

    }),
    mounted() {
        this.initialize()
    },
    computed: {
        years () {
            var years = [];
            var currentYear = new Date().getFullYear()
            let max = currentYear
            for (var year = 2020 ; year <= max; year++) {
                years.push(year);   
            }
            return years;
        },
      
      equipmentsHeaders () {
          return [
           
                { text: 'ID', value: 'id' },
                { text: 'Name of Equipment', value: 'name' },
                { text: 'Action', value: 'actions' },
          ]
      },
    },
    methods: {

        generate(equipment){
            this.$admin.get('api/equipment/generate/'+ equipment.id).then(({data}) => {
                this.qr_code =  data
            })
        },
      
      initialize() {
         this.$admin.get('api/equipment/checking').then(({data}) => {
              this.equipments = data
              this.loading = false;

            })

            this.$admin.get('api/dashboard/getData').then(({data})=> {
                    this.statistics.employees = data.employees
                    this.statistics.customers = data.customers
                    this.statistics.equipments = data.equipments

                    this.series = [
                        {
                            name: "Sales",
                            data: data.sales[0]
                        }
                    ]
                    

            })
      }


    },

};
</script>
<style scoped>
</style>
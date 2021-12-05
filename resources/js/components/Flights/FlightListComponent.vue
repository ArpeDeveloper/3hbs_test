<template>
        
        <v-data-table
            :headers="headers"
            :items="flights"
            item-key="id"
            :items-per-page="5"
            class=" elevation-1 pa-6">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Flights</v-toolbar-title>
                    <v-divider
                      class="mx-4"
                      inset
                      vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog
                      v-model="dialog"
                      max-width="500px" >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                              color="primary"
                              dark
                              class="mb-2"
                              v-bind="attrs"
                              v-on="on"
                              @click="newFlight">New flight</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                              <span class="text-h5">{{ formTitle }}</span>
                            </v-card-title>
                            <v-alert v-if="saveError" type="error">
                                {{saveError}}
                            </v-alert>
                            <v-card-text>
                              <v-container>
                                    <v-text-field
                                    v-model="flight.code"
                                    label="Code"></v-text-field>
                                    <v-select
                                        v-model="flight.type"
                                        :items="types"
                                        label="Type"
                                    ></v-select>
                                    <v-datetime-picker label="Departure time" v-model="flight.departure_time" > 
                                        <template v-slot:dateIcon>
                                            <v-icon>mdi-calendar</v-icon>
                                        </template>
                                        <template v-slot:timeIcon>
                                            <v-icon>mdi-clock</v-icon>
                                        </template>
                                    </v-datetime-picker>
                                    <v-datetime-picker label="Arrival time" v-model="flight.arrival_time" > 
                                        <template v-slot:dateIcon>
                                            <v-icon>mdi-calendar</v-icon>
                                        </template>
                                        <template v-slot:timeIcon>
                                            <v-icon>mdi-clock</v-icon>
                                        </template>
                                    </v-datetime-picker>
                                    <v-select
                                      v-model="flight.departure_id"
                                      :items="airports"
                                      item-text="name"
                                      item-value="id"
                                      label="Departure"
                                    ></v-select>
                                    <v-select
                                      v-model="flight.destination_id"
                                      :items="airports"
                                      item-text="name"
                                      item-value="id"
                                      label="Destination"
                                    ></v-select>
                                    <v-select
                                      v-model="flight.airline_id"
                                      :items="airlines"
                                      item-text="name"
                                      item-value="id"
                                      label="Airline"
                                    ></v-select>
                                    
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn
                                color="blue darken-1"
                                text
                                @click="close">Cancel</v-btn>
                              <v-btn
                                color="success"
                                text
                                @click="save">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                      <v-card>
                        <v-alert v-if="deleteError" type="error">
                                {{deleteError}}
                            </v-alert>
                        <v-card-title class="text-h5" style="word-break: break-word;">Are you sure you want to delete {{flight.code}} flight?</v-card-title>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                          <v-btn color="danger" text @click="deleteItemConfirm">OK</v-btn>
                          <v-spacer></v-spacer>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon
                class="mr-2"
                @click="editItem(item)">mdi-pencil</v-icon>
              <v-icon
                small
                @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>
              <p>There are no flights</p>
            </template>
        </v-data-table>
</template>

<script>
    import { api } from '../../api/api'
    export default {
        name: 'FlightListComponent',
        props:{},
        data() {
            return {
                formTitle:"New Flight",
                dialog:null,
                dialogDelete:null,
                flights:[],
                headers:[
                    {text:"Code",value:"code"},
                    {text:"Type",value:"type"},
                    {text:"Airline",value:"airline.name"},
                    {text:"Departure",value:"departure_airport.name"},
                    {text:"Time",value:"departure_time"},
                    {text:"Destination",value:"destination_airport.name"},
                    {text:"Time",value:"arrival_time"},
                    { value: 'actions', text: 'Actions', sortable: false }
                ],
                airlines:[],
                airports:[],
                types:["PASSENGER","FREIGHT"],
                editing: false,
                deleting: false,
                flight: {},
                saveError:null,
                deleteError:null
            }
        },
        mounted() {
            this.getFlights();
            //this.getAirlines();
            //this.getAirports();
        },
        methods:{
            getFlights(){
                const req = api().flights().all(localStorage.tokenAuth);
                req.then(this.successCallback.bind(this)).catch(this.errorCallback.bind(this));
            },
            getAirports(){
                const req = api().airports().all(localStorage.tokenAuth);
                req.then(this.successAirportsCallback.bind(this));
            },
            getAirlines(){
                const req = api().airlines().all(localStorage.tokenAuth);
                req.then(this.successAirlinesCallback.bind(this));
            },
            successCallback(e){
                if(!e.data.ok){
                    if(e.data.message){
                        //this.renderError(e.data.message);
                        console.error(e.data.message);
                    }
                }else{
                    this.flights = e.data.data;
                }
            },
            successAirportsCallback(e){
                if(!e.data.ok){
                    if(e.data.message){
                        //this.renderError(e.data.message);
                        console.error(e.data.message);
                    }
                }else{
                    this.airports = e.data.data;
                }
            },
            successAirlinesCallback(e){
                if(!e.data.ok){
                    if(e.data.message){
                        //this.renderError(e.data.message);
                        console.error(e.data.message);
                    }
                }else{
                    this.airlines = e.data.data;
                }
            },
            errorCallback(e){
                if(e.response.data.message){
                    //this.renderError(e.response.data.message);
                    console.error(e.response.data.message);
                    if(e.response.status == "403"){
                        this.$root.$emit("canFlights",false);
                        this.$router.push("/airports");
                    }
                }
            },
            close(){
                this.editing = false;
                this.dialog = false;
                this.flight = {};
            },
            save(){
                if(this.flight.departure_time){
                    const dt = this.flight.departure_time.toLocaleString();
                    const date = new Date( Date.parse(dt));
                    const fullDate = date.getFullYear() + "-" +date.getMonth() + "-" + date.getDate() + " " + date.getHours() + ":" + date. getMinutes();
                    this.flight.departure_time = fullDate;
                }
                if(this.flight.arrival_time){
                    const dt = this.flight.arrival_time.toLocaleString();
                    const date = new Date( Date.parse(dt));
                    const fullDate = date.getFullYear() + "-" +date.getMonth() + "-" + date.getDate() + " " + date.getHours() + ":" + date. getMinutes();
                    this.flight.arrival_time = fullDate;
                }
                if(!this.editing){
                    const req = api().flights().create(this.flight,localStorage.tokenAuth);
                    req.then(this.successSaveFlight.bind(this)).catch(this.errorSaveFlight.bind(this));
                }else{
                    const req = api().flights().update(this.flight,localStorage.tokenAuth);
                    req.then(this.successSaveFlight.bind(this)).catch(this.errorSaveFlight.bind(this));
                }
            },
            successSaveFlight(e){
                if(!e.data.ok){
                    if(e.data.message){
                        this.saveError = e.data.message;
                    }
                }else{
                    this.close();
                    this.getFlights();
                }
            },
            errorSaveFlight(e){
                if(e.response.data.message){
                    this.saveError = e.response.data.message;
                }
            },
            deleteItemConfirm(){
                if(this.deleting){
                    const req = api().flights().delete(this.flight,localStorage.tokenAuth);
                    req.then(this.successDeleteFlight.bind(this)).catch(this.errorDeleteFlight.bind(this));
                }
            },
            successDeleteFlight(e){
                if(!e.data.ok){
                    if(e.data.message){
                        this.deleteError = e.data.message;
                    }
                }else{
                    this.deleting = false;
                    this.dialogDelete = false;
                    this.flight = {};
                    this.getFlights();
                }
            },
            errorDeleteFlight(e){
                if(e.response.data.message){
                    this.deleteError = e.response.data.message;
                }
            },
            editItem(item){
                this.openDialog("Edit flight",item,true);
            },
            deleteItem(item){
                this.editing = false;
                this.deleting = true;
                this.flight = item;
                this.dialogDelete = true;
            },
            closeDelete(){
                this.editing = false;
                this.deleting = false;
                this.flight = {};
                this.dialogDelete = false;
            },
            newFlight(){
                this.openDialog("New flight",{},false);
            },
            openDialog(title,item,editing){
                this.formTitle =title;
                this.editing = editing;
                this.deleting = false;
                this.flight = item;
                this.dialog = true;
                if(this.airports.length <= 0)
                    this.getAirports();
                if(this.airlines.length <= 0)
                    this.getAirlines();
            }
        }
    }
</script>

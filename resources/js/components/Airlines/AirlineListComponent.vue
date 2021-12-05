<template>
        
        <v-data-table
            :headers="headers"
            :items="airlines"
            item-key="id"
            :items-per-page="5"
            class=" elevation-1 pa-6">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Airlines</v-toolbar-title>
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
                              @click="newAirline">New airline</v-btn>
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
                                    v-model="airline.code"
                                    label="Code"></v-text-field>
                                    <v-text-field
                                    v-model="airline.name"
                                    label="Name"></v-text-field>
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
                        <v-card-title class="text-h5" style="word-break: break-word;">Are you sure you want to delete {{airline.name}} airline?</v-card-title>
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
              <p>There are no airlines</p>
            </template>
        </v-data-table>
</template>

<script>
    import { api } from '../../api/api'
    export default {
        name: 'AirlineListComponent',
        props:{},
        data() {
            return {
                formTitle:"New airline",
                dialog:null,
                dialogDelete:null,
                airlines:[],
                headers:[
                    {text:"Code",value:"code"},
                    {text:"Name",value:"name"},
                    { value: 'actions', text: 'Actions', sortable: false }
                ],
                editing: false,
                deleting: false,
                airline: {},
                saveError:null,
                deleteError:null
            }
        },
        mounted() {
            this.getAirlines();
        },
        methods:{
            getAirlines(){
                const req = api().airlines().all(localStorage.tokenAuth);
                req.then(this.successCallback.bind(this));
            },
            successCallback(e){
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
                }
            },
            close(){
                this.dialog = false;
            },
            save(){
                if(!this.editing){
                    const req = api().airlines().create(this.airline,localStorage.tokenAuth);
                    req.then(this.successSaveFlight.bind(this)).catch(this.errorSaveFlight.bind(this));
                }else{
                    const req = api().airlines().update(this.airline,localStorage.tokenAuth);
                    req.then(this.successSaveFlight.bind(this)).catch(this.errorSaveFlight.bind(this));
                }
            },
            successSaveFlight(e){
                if(!e.data.ok){
                    if(e.data.message){
                        this.saveError = e.data.message;
                    }
                }else{
                    this.editing = false;
                    this.dialog = false;
                    this.airline = {};
                    this.getAirlines();
                }
            },
            errorSaveFlight(e){
                if(e.response.data.message){
                    this.saveError = e.response.data.message;
                }
            },
            deleteItemConfirm(){
                if(this.deleting){
                    const req = api().airlines().delete(this.airline,localStorage.tokenAuth);
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
                    this.airline = {};
                    this.getAirlines();
                }
            },
            errorDeleteFlight(e){
                if(e.response.data.message){
                    this.deleteError = e.response.data.message;
                }
            },
            editItem(item){
                this.formTitle ="Edit airline";
                this.editing = true;
                this.deleting = false;
                this.airline = item;
                this.dialog = true;
            },
            deleteItem(item){
                this.editing = false;
                this.deleting = true;
                this.airline = item;
                this.dialogDelete = true;
            },
            closeDelete(){
                this.editing = false;
                this.deleting = false;
                this.airline = {};
                this.dialogDelete = false;
            },
            newAirline(){
                this.formTitle ="New airline";
                this.editing = false;
                this.deleting = false;
                this.airline = {};
                this.dialog = true;
            }
        }
    }
</script>

<template>
  <div>
    <v-card v-if="isLogged"
    class="mx-auto overflow-hidden"
    height="100%"
    width="100%"
  >
    <v-app-bar
      color="deep-purple accent-4"
      dark
      style="border-radius:0;"
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-spacer></v-spacer>

      <v-btn icon @click="logout">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>

    <v-navigation-drawer
      v-model="drawer"
      absolute
      bottom
      temporary
    >
      <v-list
        nav
        dense
      >
        <v-list-item-group
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item v-if="canFlights">
            <router-link to="/flights" style="text-decoration: none;">Flights</router-link>
          </v-list-item>

          <v-list-item>
            <router-link to="/airports" style="text-decoration: none;">Airports</router-link>
          </v-list-item>

          <v-list-item>
            <router-link to="/airlines" style="text-decoration: none;">Airlines</router-link>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-card-text>
      <router-view />
    </v-card-text>
  </v-card>
  <router-view v-else="isLogged"/>
</div>
</template>

<script>
    import { api } from '../../api/api';

    export default {
        name: 'NavbarComponent',
        props:{},
        data() {
            return {
                canFlights:true,
                isLogged:false,
                drawer:false
            }
        },
        mounted() {
          this.isLogged = this.$router.currentRoute.name != "login"
          this.$root.$on("login",function(login){
              this.isLogged = login;
            
          }.bind(this));
          this.$root.$on("canFlights",function(canFlights){
            this.canFlights = canFlights;
          }.bind(this));
          
        },
        updated() {
          const isLogged = localStorage.tokenAuth && this.$router.currentRoute.name != "login"
          if(!isLogged)
            this.deleteSession()
          
        },
        methods:{
          logout(){
            const req = api().logout(localStorage.tokenAuth);
            req.then(this.successCallback.bind(this));
          },
          successCallback(e){
            if(!e.data.ok){
              if(e.data.message){
                  //this.renderError(e.data.message);
                  console.error(e.data.message);
              }
            }else{
              this.deleteSession();
            }
          },
          deleteSession(){
            if(this.$router.currentRoute.name != "login"){
              this.isLogged = false;
              delete localStorage.tokenAuth;
              this.$router.push("/")
            }
          }
        }
    }
</script>
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const NotFound = Vue.component('notfound-component', require('../components/NotFoundComponent.vue').default);
const Forbidden = { template: '<p>Page forbidden</p>' }
const Login = Vue.component('login-component', require('../components/LoginComponent.vue').default);
const Flights = Vue.component('flightlist-component', require('../components/Flights/FlightListComponent.vue').default);
const Airports = Vue.component('airportlist-component', require('../components/Airports/AirportListComponent.vue').default);
const Airlines = Vue.component('airlinelist-component', require('../components/Airlines/AirlineListComponent.vue').default);


const routes = [
	{ path: '/', component: Login, name:"login" },
	{ path: '/flights', component: Flights },
	{ path: '/airports', component: Airports },
	{ path: '/airlines', component: Airlines },
 	{ path: '/404', component: NotFound },
 	{ path: '/403', component: Forbidden },
 	{ path: '*', redirect: '/404' },
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new Router({
  routes // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
	if (to.name != "login" && !localStorage.tokenAuth){
   		next({ name: 'login' })
	}
  else next()
})

export default router;
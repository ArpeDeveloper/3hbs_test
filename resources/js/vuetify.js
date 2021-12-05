import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors'

Vue.use(Vuetify)

export default new Vuetify({
	icons: {
   		iconfont: 'mdi', // default - only for display purposes
 	},
	theme: {
		themes: {
			light: {
				primary: colors.indigo.darken3,
				secondary: colors.purple.darken3,
				accent: colors.blue.accent2,
				error: colors.red.darken1,
				success: colors.green.darken1,
				warning: colors.amber.darken1,
			},
		},
	},
})
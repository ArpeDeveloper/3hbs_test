const apiUrl = 'http://localhost/3hbs_test/public/api';
export function api(){
	return {
		login: function(data) {
			return axios.post(apiUrl +'/login',data)
		},
		flights: function() {
			return { 
				all: function(token){
					return axios.get(apiUrl +'/flights',
						{
							headers:{'Authorization':'Bearer ' + token
						}
					})
				},
				update: function(data,token) {
					return axios.put(apiUrl +'/flights/'+data.id,
						data,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
				create: function(data,token) {
					return axios.post(apiUrl +'/flights',
						data,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
				delete: function(data,token) {
					return axios.delete(apiUrl +'/flights/'+data.id,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
			}
		},
		airlines: function() {
			return { 
				all: function(token){
					return axios.get(apiUrl +'/airlines',
						{
							headers:{'Authorization':'Bearer ' + token
						}
					})
				},
				update: function(data,token) {
					return axios.put(apiUrl +'/airlines/'+data.id,
						data,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
				create: function(data,token) {
					return axios.post(apiUrl +'/airlines',
						data,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
				delete: function(data,token) {
					return axios.delete(apiUrl +'/airlines/'+data.id,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
			}
		},
		airports: function() {
			return { 
				all: function(token){
					return axios.get(apiUrl +'/airports',
						{
							headers:{'Authorization':'Bearer ' + token
						}
					})
				},
				update: function(data,token) {
					return axios.put(apiUrl +'/airports/'+data.id,
						data,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
				create: function(data,token) {
					return axios.post(apiUrl +'/airports',
						data,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
				delete: function(data,token) {
					return axios.delete(apiUrl +'/airports/'+data.id,
						{
							headers:{'Authorization':'Bearer ' + token}
						})
				},
			}
		}
	}
};
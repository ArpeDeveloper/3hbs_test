const apiUrl = process.env.MIX_API_HOST;
export function api(){
	return {
		login: function(data) {
			return axios.post(apiUrl +'/login',data)
		},
		logout: function(token) {
			return axios.post(apiUrl +'/logout',{},{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
		},
		flights: function() {
			return { 
				all: function(token){
					return axios.get(apiUrl +'/flights',
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
					})
				},
				update: function(data,token) {
					return axios.put(apiUrl +'/flights/'+data.id,
						data,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
				create: function(data,token) {
					return axios.post(apiUrl +'/flights',
						data,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
				delete: function(data,token) {
					return axios.delete(apiUrl +'/flights/'+data.id,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
			}
		},
		airlines: function() {
			return { 
				all: function(token){
					return axios.get(apiUrl +'/airlines',
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
					})
				},
				update: function(data,token) {
					return axios.put(apiUrl +'/airlines/'+data.id,
						data,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
				create: function(data,token) {
					return axios.post(apiUrl +'/airlines',
						data,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
				delete: function(data,token) {
					return axios.delete(apiUrl +'/airlines/'+data.id,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
			}
		},
		airports: function() {
			return { 
				all: function(token){
					return axios.get(apiUrl +'/airports',
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
					})
				},
				update: function(data,token) {
					return axios.put(apiUrl +'/airports/'+data.id,
						data,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
				create: function(data,token) {
					return axios.post(apiUrl +'/airports',
						data,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
				delete: function(data,token) {
					return axios.delete(apiUrl +'/airports/'+data.id,
						{
							headers:{'Authorization':'Bearer ' + token},
							validateStatus: function (status) {
								if(status==401)
									delete localStorage.tokenAuth;
								return status >= 200 && status < 300; // default
							},
						})
				},
			}
		}
	}
};
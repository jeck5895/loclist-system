export default {
    state: {
        nationality: {},
        nationalities: []
    },
    getters: {
        getNationality:state => {
            return state.nationality;
        },
        getNationalities: state => {
            return state.nationalities;
        }
    },
    mutations: {
        clearNationality: state => {
            state.nationality = {};
        },
        setNationality: (state, payload) => {
            state.nationality = payload.data;
        },
        setNationalities: (state, payload) => {
            state.nationalities = payload.data;
        }   
    },
    actions: {
        clearNationality: context => {
            var {commit} = context; //destructuring object
            commit('clearNationality');
        },
        loadNationality: (context, payload) => {
            axios.get('api/nationalities/' + payload.id)
            .then(response => {
                context.commit('setNationality', response);
            })
            .catch(error => {
                console.log(error.response.data)
            });
        },
        loadNationalities: (context, payload) => {
            axios.get(payload)
            .then(response => {
                context.commit('setNationalities', response);
            })
            .catch(error => {
                console(error)
            });
        },
        storeNationality : (context, payload) => {
            axios.post('api/nationalities', payload)
            .then(response => {
                context.commit('setServerResponse', response);
                $("#createUserModal").modal('hide');
                toastr.success('Success', response.data.message);
                document.getElementById('nationalityForm').reset();
            })
            .catch(error => {
                let errors = error.response;
                context.commit('setServerResponse', errors);
                //toastr.error('Error', 'Oops! something went wrong');
                console.log(errors);
            });
        },
        updateNationality: (context, payload) => {
            axios.patch('api/nationalities/' + payload.id, payload)
            .then(response => {
                context.commit('setServerResponse', response);
                $("#createUserModal").modal('hide');
                toastr.success('Success', response.data.message);
                document.getElementById('nationalityForm').reset();
            })
            .catch(error => {
                context.commit('setServerResponse', error.response);
                console.log(error.response)
            });
        },
        deleteNationality: (context, payload) => {

        }
    }
}
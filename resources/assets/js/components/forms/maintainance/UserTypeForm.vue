<template>
    <form id="userTypeForm" @submit.prevent="submitForm('userTypeForm')" data-vv-scope="userTypeForm">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert" v-if="serverResponse.status == 422">
                    <strong>Errors</strong> :{{ serverResponse.data.message }}
                    <ul v-if="serverResponse.data.errors.userType">
                        <li v-for="e in serverResponse.data.errors.userType" :key="e">{{ e }}</li>
                    </ul>
                </div>

                <div class="alert alert-danger" role="alert" v-if="serverResponse.status == 403">
                    <strong>You are not authorized to perform this action</strong>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label for="">User type</label>
                <input name="userType" data-vv-validate-on="'blur'" v-validate="{rules:{required:true}}" type="text" class="uppercase form-control form-control-sm"
                    v-model="user_type.userType">
                <small class="form-text has-danger" v-show="errors.has('userTypeForm.userType')">{{ errors.first('userTypeForm.userType') }}</small>
            </div>

            <div class="form-group col">
                <button type="submit" class="btn btn-success btn-sm" :disabled="isSubmitting">
                    <span v-if="isSubmitting">
                        Saving... <div class="loading"></div>
                    </span>
                    <span v-else>
                        Save
                    </span>
                </button>
                <button type="button" @click="closeModal('userTypeForm')" class="btn btn-sm btn-danger">
                    Close
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        created() {

        },
        computed: {
            isSubmitting() {
                return this.$store.getters.getSubmitState;
            },
            user_type() {
                return this.$store.getters.getUserType;
            },
            formType() {
                return this.$store.getters.getModalFormType;
            },
            modalFormValidation() {
                return this.$store.getters.getModalFormValidation;
            },
            serverResponse() {
                return this.$store.getters.getServerResponse;
            }
        },
        methods: {
            closeModal(scope) {
                let payload = {
                    scope: scope,
                    errors: this.errors
                };
                this.$store.dispatch('setModalFormValidation', payload).then(() => {
                    this.$store.dispatch('closeModal', this.modalFormValidation);
                });

            },
            submitForm(scope) {

                this.$validator.validateAll(scope).then((result) => {
                    
                    if (result) { // if true submit form else set serverResponse error
                        let user_type = {
                            id: this.user_type.id,
                            userType: this.user_type.userType.toUpperCase(),
                            // add_clients : this.user_type.add_clients,
                            // edit_clients : this.user_type.edit_clients,
                            // delete_clients : this.user_type.delete_clients,
                            // add_client_calls : this.user_type.add_client_calls,
                            // edit_client_calls : this.user_type.edit_client_calls,
                            // delete_client_calls : this.user_type.delete_client_calls,
                            // add_client_saturations : this.user_type.add_client_saturations,
                            // edit_client_saturations : this.user_type.edit_client_saturations,
                            // delete_client_saturations :  this.user_type.delete_client_saturations,
                            // add_client_presentations : this.user_type.add_client_presentations,
                            // edit_client_presentations :  this.user_type.edit_client_presentations,
                            // delete_client_presentations : this.user_type.delete_client_presentations,
                            // add_client_acquisitions : this.user_type.add_client_acquisitions,
                            // edit_client_acquisitions : this.user_type.edit_client_acquisitions,
                            // delete_client_acquisitions : this.user_type.delete_client_acquisitions,
                            // add_user : this.user_type.add_user,                          
                            // edit_user : this.user_type.edit_user,                           
                            // delete_user : this.user_type.delete_user                         
                        };

                        if (this.formType == 'CREATE_USERTYPE') {
                            this.$store.dispatch('storeUserType', user_type).then(() => {
                                this.$store.dispatch('loadUserTypes', 'api/maintenance/user_types');
                            });
                        } else if (this.formType == 'EDIT_USERTYPE') {
                            this.$store.dispatch('updateUserType', user_type)
                            .then(() => {
                                this.$store.dispatch('loadUserTypes', 'api/maintenance/user_types');
                            });
                        } else {
                            toastr.error('Error', 'Unknown Command');
                        }
                    } else {

                    }
                });
            }
        }
    }
</script>

<style>

</style>

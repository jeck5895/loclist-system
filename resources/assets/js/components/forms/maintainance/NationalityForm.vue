<template>
    <form id="nationalityForm" @submit.prevent="submitForm('nationalityForm')" data-vv-scope="nationalityForm">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert" v-if="serverResponse.status == 422">
                    <strong>Errors</strong> :{{ serverResponse.data.message }}
                    <ul v-if="serverResponse.data.errors.nationality">
                        <li v-for="e in serverResponse.data.errors.nationality" :key="e">{{ e }}</li>
                    </ul>
                </div>

                <div class="alert alert-danger" role="alert" v-if="serverResponse.status == 403">
                    <strong>You are not authorized to perform this action</strong>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label for="">Nationality</label>
                <input name="nationality" data-vv-validate-on="'blur'" v-validate="{rules:{required:true}}" type="text" class="uppercase form-control form-control-sm"
                    v-model="nationality.nationality">
                <small class="form-text has-danger" v-show="errors.has('nationalityForm.nationality')">{{ errors.first('nationalityForm.nationality') }}</small>
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
                <button type="button" @click="closeModal('nationalityForm')" class="btn btn-sm btn-danger">
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
            nationality() {
                return this.$store.getters.getNationality;
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
                        let nationality = {
                            id: this.nationality.id,
                            nationality: this.nationality.nationality.toUpperCase()
                        };
                        
                        if (this.formType == 'CREATE_NATIONALITY') {
                            this.$store.dispatch('storeNationality', nationality).then(() => {
                                this.$store.dispatch('loadNationalities', 'api/maintenance/nationalities');
                            });
                        } else if (this.formType == 'EDIT_NATIONALITY') {
                            this.$store.dispatch('updateNationality', nationality)
                            .then(() => {
                                this.$store.dispatch('loadNationalities', 'api/maintenance/nationalities');
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

<template>
    <div id="client-details" class="card card-default">
        <div class="card-header clearfix">
            <h5 class="mb-0 float-left">
                Client Details
            </h5>
        </div>
        <!-- <div v-show="isLoading" class="card-body">
            <div class="row">
                <div class="img-loading-container">
                    <img src="/images/spinner.gif">
                </div>   
            </div>
        </div> -->
        <div class="collapse show card-body" id="detailsCollapse">
            <form id="clientDetailsForm" @submit.prevent="submitDetailsForm('clientDetailsForm')" data-vv-scope="clientDetailsForm">
                <form-errors :serverResponse="serverResponse"></form-errors>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="companyName" class="control-label">Company Name
                            <span class="required-field">*</span>
                        </label>
                        <input v-model="client.client_name" v-validate="{rules:{required:true}}" type="text" class="form-control form-control-sm" name="company_name" style="text-transform: uppercase;">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.company_name')">{{ errors.first('clientDetailsForm.company_name') }}</small>
                    </div>
                    <div class="col-md-3">
                        <label for="companyIndustry">Industry
                            <span class="required-field">*</span>
                        </label>
                        <select v-model="client.industry" v-validate="{rules:{required:true}}" name="client_industry" class="form-control form-control-sm" id="companyIndustry">
                            <option value="">--Select Industry--</option>
                            <option v-for="(industry, index) in industries" :key="index" :value="industry.id">
                                {{ industry.industry_name }}
                            </option>
                        </select>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.client_industry')">{{ errors.first('clientDetailsForm.client_industry') }}</small>
                    </div>
                    <div class="col-md-3">
                        <label for="companyIndustry">Nationality</label>
                        <select v-model="client.nationality" v-validate="{rules:{required:true}}" name="nationality" class="form-control form-control-sm">
                            <option value="">--Select Nationality--</option>
                            <option v-for="(nationality, index) in nationalities" :key="index" :value="nationality.id"> {{ nationality.nationality }}</option>
                        </select>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.nationality')">{{ errors.first('clientDetailsForm.nationality') }}</small>
                    </div>
                    <div class="col-md-3">
                        <label for="companyIndustry">ISO Certifacation</label>
                        <select v-model="client.iso_certf" v-validate="{rules:{required:true}}" name="client_isocertificate" class="form-control form-control-sm" id="companyIndustry">
                            <option value="">--Select Certificate--</option>
                            <option v-for="(certificate, index) in certificates" :key="index" :value="certificate.id">
                                {{ certificate.iso_name }}
                            </option>
                        </select>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.client_isocertificate')">{{ errors.first('clientDetailsForm.client_isocertificate') }}</small>
                    </div>
                </div>
                <!-- 2nd row -->
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="mailingAddress" class="control-label">Mailing Address</label>
                        <input v-model="client.complete_mailing_address" v-validate="{rules:{required:true}}" type="text" class="form-control form-control-sm" name="mailing_address">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.mailing_address')">{{ errors.first('clientDetailsForm.mailing_address') }}</small>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Techno Park</label>
                        <input v-model="client.techno_park" v-validate="{rules:{required:true}}" name="techno_park" type="text" class="form-control form-control-sm">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.techno_park')">{{ errors.first('clientDetailsForm.techno_park') }}</small>
                    </div>
                </div>

                <!-- 3rd row -->

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="streetAddress">Lot/Block No./Brgy/Town</label>
                        <input v-model="client.street_address" v-validate="{rules:{required:true}}" type="text" class="form-control form-control-sm" name="street_number">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.street_number')">{{ errors.first('clientDetailsForm.street_number') }}</small>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="streetAddress">City/Province</label>
                        <input v-model="client.province" v-validate="{rules:{required:true}}" @keypress="autoComplete" ref="address" type="text" name="province" id="province" class="form-control form-control-sm" placeholder="Enter location">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.province')">{{ errors.first('clientDetailsForm.province') }}</small>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="companyIndustry">Area</label>
                        <input v-model="client.administrative_area_level_1" v-validate="{rules:{required:true}}" id="administrative_area_level_1" type="text" name="administrative_area_level_1" class="form-control form-control-sm">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.administrative_area_level_1')">{{ errors.first('clientDetailsForm.administrative_area_level_1') }}</small>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="companyIndustry">Zip Code</label>
                        <input v-model="client.postal_code" v-validate="{rules:{required:true}}" id="postal_code" name="postal_code" type="text" class="form-control form-control-sm">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.postal_code')">{{ errors.first('clientDetailsForm.postal_code') }}</small>
                    </div>
                </div>

                <!-- 4th row -->
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Official Website</label>
                        <input v-model="client.website" type="text"  v-validate="'required'" name="company_website" class="form-control form-control-sm" placeholder="http://example.com">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.company_website')">{{ errors.first('clientDetailsForm.company_website') }}</small>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Primary Landline</label>
                        <input v-model="client.primary_landline" v-validate="{rules:{required:true}}" name="primary_landline" type="text" class="form-control form-control-sm">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.primary_landline')">{{ errors.first('clientDetailsForm.primary_landline') }}</small>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Other Landline</label>
                        <input v-model="client.other_landline" v-validate="{rules:{required:true}}" name="other_landline" type="text" class="form-control form-control-sm">
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.other_landline')">{{ errors.first('clientDetailsForm.other_landline') }}</small>
                    </div>
                </div>
                <hr>
                <!-- 8th row -->
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Proposal</label>
                        <select v-model="client.proposal" v-validate="{rules:{required:true}}" name="proposal" id="" class="form-control form-control-sm">
                            <option value="">--Select Proposal--</option>
                            <option value="DIRECT">DIRECT</option>
                            <option value="OUTSOURCE">OUTSOURCED</option>
                        </select>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.proposal')">{{ errors.first('clientDetailsForm.proposal') }}</small>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Company (CSI/SRI)</label>
                        <select v-model="client.company" v-validate="{rules:{required:true}}" name="company"  class="form-control form-control-sm">
                            <option value="">--Select Company--</option>
                            <option v-for="(company, index) in companies" :key="index" :value="company.id">
                                {{ company.company_name }}
                            </option>
                        </select>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.company')">{{ errors.first('clientDetailsForm.company') }}</small>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="">Manpower</label>
                        <select v-model="client.manpower" v-validate="{rules:{required:true}}" name="manpower_type" id="" class="form-control form-control-sm">
                            <option value="">--Select Manpower Type--</option>
                            <option v-for="(manpower, index) in manpowers" :key="index" :value="manpower.id">
                                {{ manpower.type }}
                            </option>
                        </select>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.manpower_type')">{{ errors.first('clientDetailsForm.manpower_type') }}</small>
                    </div> 
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="mr-1">Task Status</label>
                        <select v-model="client.task_status" v-validate="{rules:{required:true}}" name="task_status" data-vv-as="Task Status" class="form-control form-control-sm mr-sm-2" :disabled="disabled">
                            <option value="">--Select Overall Status--</option>
                            <option v-for="(status, index) in task_statuses" :key="index" :value="status.id">{{ status.status }}</option>
                        </select>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.task_status')">{{ errors.first('clientDetailsForm.task_status') }}</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="mr-1">Negotiation Status {{ disabled }}</label>
                        <select @change="notifyUserIfAcquired" v-model="client.negotiation_status" v-validate="{rules:{required:true}}" name="negotiation_status" data-vv-as="Negotiation Status" class="form-control form-control-sm mr-sm-2" :disabled="disabled">
                            <option value="">--Select Overall Status--</option>
                            <option v-for="(status, index) in negotiation_statuses" :key="index" :value="status.id">{{ status.status }}</option>
                        </select>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.negotiation_status')">{{ errors.first('clientDetailsForm.negotiation_status') }}</small>
                    </div>
                </div>
                
                <div v-if="client.negotiation_status == 9" class="row">
                    <div class="form-group col-md-12">
                        <label class="mr-1">Reason for Closing</label>
                        <textarea v-model="client.reasons_for_closing" v-validate="{rules:{required:true}}" data-vv-as="Reason for closing" name="reason_for_closing" id="" cols="30" rows="5" class="form-control"></textarea>
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.reason_for_closing')">{{ errors.first('clientDetailsForm.reason_for_closing') }}</small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Sourcing Practice</label>
                        <select2-multiple :options="options" v-model="selected">
                            <option disabled value="0">--Select Practices--</option>
                        </select2-multiple>
                        
                        <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.sourcing_practice')">{{ errors.first('clientDetailsForm.sourcing_practice') }}</small>
                    </div>
                </div>
                <!-- 5th row -->
                <hr>
                <div class="row">
                    <div class="col-md-12 clearfix">
                        <h6 class="lead float-left">Contact Persons</h6>
                        <button @click.prevent="showFormModal" class="btn btn-default btn-sm float-right"><i class="fa fa-plus"></i> New Contact Person</button>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-md-12">
                        <contact-persons-table :displayOptions="true"></contact-persons-table>
                    </div>
                </div>
                
                <!-- 7th row -->
                <hr>

                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <label for="">Manpower Provider</label>
                        <div class="input-group">
                            <input  v-model="client_manpower_provider.manpower_provider" 
                                    ref="manpower_provider_field"
                                    name="client_manpower_provider" 
                                    type="text" 
                                    class="form-control form-control-sm"
                                    placeholder="Add manpower provider here...">
                            <button @click.prevent="addProvider" class="btn btn-default btn-sm ml-1">Add Provider</button>
                        </div>
                        <!-- <small class="form-text has-danger" v-show="errors.has('clientDetailsForm.manpower_provider')">{{ errors.first('clientDetailsForm.manpower_provider') }}</small> -->
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="width:80%;">Provider</th>
                                    <th scope="col" style="width:20%;">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="client_manpower_providers == 0">
                                    <td colspan="11" class="text-center">
                                        <i class="text-muted"><small>No provider(s) to show...</small></i>
                                    </td>
                                </tr>
                                <tr v-else v-for="(m, index) in client_manpower_providers" :key="index">
                                    <td style="vertical-align: middle;">
                                        {{ m }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button @click.prevent="removeProvider(m)" class="btn btn-sm btn-danger">
                                            <span class="fa fa-times-circle"></span>
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <button type="submit" class="btn btn-success btn-sm" :disabled="isSubmitting">
                            <span v-if="isSubmitting" >
                                Saving...  <div class="loading"></div>
                            </span>
                            <span v-else>
                                Save Client Details
                            </span>
                        </button>
                        
                    </div>
                </div>
            </form>
        </div>
        <modal>
            <template slot="header">{{ modalTitle }}</template>
            <div>
                <contact-person-form></contact-person-form>
            </div>
        </modal>
    </div>
</template>


<script>
import formErrors from '../../errors/clientForm/clientFormError';
import Modal from '../../modal/modal';
import ContactPersonForm from '../../forms/client/ContactPersonForm';
import ContactPersonsTable from '../../tables/client/ContactPersonsTable';

export default {
    created() {
        let user = Vue.auth.getter();
        if(typeof this.clientId != "undefined"){
            Echo.private(`update-client-channel-${this.clientId}`).listen("UpdateClientEvent", e => {
                console.log(e);
                toastr.info('', e.message.response);
                let payload = {
                        id: this.clientId
                    };
                this.$store.dispatch('loadClient', payload);
            });
        }

        Echo.private('maintenance-channel')
            .listen('MaintenanceEvent', (e) => {
                console.log(e);
                if(e.scope == "industries"){
                    this.$store.dispatch('loadIndustries','api/maintenance/industries?type=all');
                }
                if(e.scope == "nationalities"){
                    this.$store.dispatch('loadNationalities', 'api/maintenance/nationalities?type=all');
                }
                if(e.scope == "certificates"){
                    this.$store.dispatch('loadCertificates', 'api/maintenance/certificates?type=all');
                }
                if(e.scope == "sourcing_practices"){
                    this.$store.dispatch('loadSourcingPractices','api/maintenance/sourcing_practices?type=all');
                }
                if(e.scope == "companies"){
                    this.$store.dispatch('loadCompanies', 'api/companies?type=all');
                }
                if(e.scope == "manpowers"){
                    this.$store.dispatch('loadManpowers', 'api/maintenance/manpowers?type=all');
                }
                if(e.scope == "statuses"){
                    this.$store.dispatch('loadStatuses', 'api/maintenance/statuses?type=all');
                }
            });
    },
    mounted() {
        
    },
    data() {
        return {
            selected: [],
            clientId: this.$route.params.clientId,
            action: localStorage.getItem('f_type'),
            negotiation_statuses:[],
            task_statuses: [],
        }
    },
    computed: {
        disabled() {
            return this.$store.getters.getDisableStatus;
        },
        contact_persons() {
            return this.$store.getters.getClientContactPersons;
        },
        modalTitle() {
            return this.$store.getters.getModalTitle;
        },
        modalFormType() {
            return this.$store.getters.getModalFormType;
        },
        isSubmitting() {
            return this.$store.getters.getSubmitState;
        },
        isLoading() {
            return this.$store.getters.getLoadingState;
        },
        client() {
            return this.$store.getters.getClient;
        },
        client_manpower_providers() {
            return this.$store.getters.getClientManpowerProviders;
        },
        client_manpower_provider() {
            return this.$store.getters.getClientManpowerProvider;
        },
        companies() {
            return this.$store.getters.getCompanies;
        },
        industries() {
            return this.$store.getters.getIndustries;
        },
        nationalities() {
            return this.$store.getters.getNationalities;
        },
        certificates() {
            return this.$store.getters.getIsoCertificates;
        },
        sourcing_practices() {
           return this.$store.getters.getSourcingPratices;
        },
        manpowers() {
            return this.$store.getters.getManpowers;
        },
        statuses() {
            return this.$store.getters.getStatuses;
        },
        formType() {
            return localStorage.getItem('f_type');
        },
        serverResponse() {
            return this.$store.getters.getServerResponse;
        },
        options() {
            var sp = this.sourcing_practices;
            var op = [];
            
            $.each(sp, (index, item) => {
                var obj = {
                        id: item.id,
                        text: item.name
                    }
                op.push(obj);
            });

            return op;
        },
        // selected() {
        //     //array of id's of selected sourcing practices e.g. return [1,2,3] - use push to insert
        // }
    },
    watch: {
        //watch for computed property changes then loadClietSP to transfer computed property to array
        client:'loadClientSP',
        statuses: function() {
            if(this.statuses){
                this.task_statuses = [];
                this.negotiation_statuses = [];
                
                this.statuses.forEach(element => {
                    if(element.status_category_id == 1){
                        // this.task_statuses.push(element);
                        this.task_statuses.push(element);
                    }
                    else{
                        this.negotiation_statuses.push(element);
                    }
                });
            }
        }
        //client:'reloadPositions'
    },
    methods: {
        showFormModal() {
            this.$store.dispatch('setModalFormType', 'CREATE_CONTACT_PERSON');
            // this.$store.dispatch('setForm', document.getElementById('confirmationForm'));
            this.$store.dispatch('setModalTitle', "Contact Person Details");
            //this.$store.dispatch('clearConfirmation');
            this.$store.dispatch('showModal', document.getElementById('contactPersonForm'));
        },
        loadClientSP(){
            let sp = this.client.sourcing_practices;
            console.log(sp)
            
            if(sp && sp.length != 0){
                sp.map((item) => {
                    this.selected.push(item.id);
                });
            }
            // console.log(this.selected)
        },
        addProvider() {
            let provider = this.client_manpower_provider.manpower_provider;

            if(!this.client_manpower_provider.manpower_provider == ''){
                this.$store.dispatch('storeClientManpowerProviders', provider)
                .then(() => {
                    this.$refs.manpower_provider_field.value = '';
                    this.client_manpower_provider.manpower_provider = '';
                });
            }
        },
        removeProvider(provider){
            this.$store.dispatch('removeClientManpowerProvider', provider)
            .then(() => {
                this.$refs.manpower_provider_field.value = '';
            });
        },
        submitDetailsForm(scope) {
            let user = Vue.auth.getter();
           
            this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    let client = {
                        id: this.client.id,
                        entry_by: user.uid,
                        client_name: this.client.client_name.toUpperCase().trim(),
                        industry: this.client.industry,
                        nationality: this.client.nationality,
                        iso_certf: this.client.iso_certf,
                        complete_mailing_address: this.client.complete_mailing_address.trim(),
                        techno_park: this.client.techno_park.trim(),
                        street_address: this.client.street_address.trim(),
                        province: this.client.province.trim(),
                        administrative_area_level_1: this.client.administrative_area_level_1.trim(),
                        postal_code: this.client.postal_code,
                        website: this.client.website.trim(),
                        primary_landline: this.client.primary_landline.trim(),
                        other_landline: this.client.other_landline.trim(),
                        // mobile_number: this.client.mobile_number.trim(),
                        // email_address: this.client.email_address.trim(),
                        // contact_person: this.client.contact_person.trim(),
                        // first_name: this.client.first_name,
                        // last_name: this.client.last_name,
                        // gender: this.client.gender,
                        // department: this.client.department,
                        // position: this.client.position,
                        proposal: this.client.proposal,
                        company: this.client.company,
                        manpower: this.client.manpower,
                        sourcing_practices: this.selected,
                        manpower_providers: this.client_manpower_providers,
                        overall_status: this.client.overall_status,
                        contact_persons: this.contact_persons,
                        negotiation_status: this.client.negotiation_status,
                        task_status: this.client.task_status
                    };
                   
                    if (this.formType == 'CREATE_CLIENT') {
                        this.$store.dispatch('storeClient', client)
                        .then(response => {
                            console.log(response)
                            //document.getElementById('clientDetailsForm').reset();
                            this.$store.dispatch('clearClient');
                            this.$store.dispatch('clearClientManpowerProviders');
                            this.$store.dispatch('clearContactPersons');
                            this.selected = [];
                        })
                        .catch(error => {
                            console.log(error)
                        });
                       
                    }
                    else if (this.formType == 'EDIT_CLIENT') {
                        this.$store.dispatch('updateClient', client);
                        // this.$store.dispatch('loadUsers','/api/users');
                    }
                    else {
                        toastr.error('Error', 'Invalid Operation');
                    }
                }
                else {
                    toastr.error('Warning', 'Please fix errors to submit');
                    console.log(result)
                    console.log(this.errors)
                    let payload = {
                        scope: scope,
                        errors: this.errors
                    };
                    //this.$store.dispatch('setModalFormValidation', payload);
                }
            });
        },
        autoComplete() {
            var self = this;
            var refs = this.$refs;
            var input = refs.address;
            var autocomplete = new google.maps.places.Autocomplete(input);
            // var autocomplete = new google.maps.places.Autocomplete(input,{types:['(regions)']});
            autocomplete.addListener('place_changed', () => {
                console.log(autocomplete.getPlace());
                var place = autocomplete.getPlace();
                var componentForm = {
                    street_number: 'short_name',
                    route: 'long_name',
                    locality: 'long_name',
                    administrative_area_level_1: 'short_name',
                    country: 'long_name',
                    postal_code: 'short_name'
                };
                
                for(var element in componentForm){
                    if(document.getElementById(element))
                        document.getElementById(element).value = ''; //reset value
                }

                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        
                        if(document.getElementById(addressType)){
                            document.getElementById(addressType).value = val;
                            this.client[addressType] = val;
                            this.client.province = input.value;
                        }
                    }
                }
            });
        },
        notifyUserIfAcquired() {
            if(this.client.negotiation_status == 6) {
                toastr.info('Reminder',"Don't forget to set the acquisition date on client profile.");
            }
        }
    },
    components: {
        formErrors,
        Modal,
        ContactPersonForm,
        ContactPersonsTable
    },
    destroyed() {
        Echo.leave('maintenance-channel');
        if(typeof this.clientId != "undefined"){
            Echo.leave(`update-client-channel-${this.clientId}`);
        }
    }
}

</script>


<style>
    .btn-danger{
        background-color: #BD362F !important;
        border-color: #BD362F !important;
    }
    .select2.select2-container.select2-container--default{
        width:100%!important;
    }
    .select2-container--default .select2-selection--multiple {
        padding: 0 0.5rem;
        border-radius: 0!important;
        border: 1px solid rgba(0, 0, 0, 0.15)!important;
        min-height: 28.38px !important;
    }

    .select2-container .select2-search--inline .select2-search__field{
        font-size: 85% !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color: #ffc107;
        color: antiquewhite;
    }
</style>



<template>
    <div>
        <table class="table table-borderless table-striped m-b-none">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Certificate</th>
                    <th>Date Created</th>
                    <th>Status</th>
                    <th>OPTIONS</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr v-if="isLoading">
                    <td colspan="11" class="text-center">
                    <div v-if="isLoading" class="card-body">
                            <div class="img-loading-container">
                                <img src="/images/spinner.gif" class="img-sm">
                            </div>   
                        </div>
                    </td>
                </tr> -->

                <tr v-if="certificates.data == 0">
                    <td colspan="7" class="text-center">
                        No data to show...
                    </td>
                </tr>
                <tr v-else v-for="certificate in certificates.data" :key="certificate.id">
                   <td style="vertical-align: middle;">
                        {{ certificate.id }}
                    </td>
                    <td style="vertical-align: middle;">
                        {{ certificate.iso_name }}
                    </td>
                    <td style="vertical-align: middle;">
                        {{ certificate.created_at | humanReadableFormat}}
                    </td>
                    <td style="vertical-align: middle;">
                        <span v-if="certificate.is_active == 1" class="bg-success p-1 text-white"> <strong><small>Active</small></strong></span>
                        <span v-if="certificate.is_active == 0" class="bg-danger p-1 text-white"> <strong><small>Inactive</small></strong></span>
                    </td>
                    <td style="vertical-align: middle;">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" title="Edit" class="btn btn-sm btn-default" @click="edit(certificate)">
                                <span class="fa fa-edit"></span>
                            </button>

                            <button @click="destroy(certificate)" type="button" class="btn btn-sm btn-default">
                                <span class="fa fa-trash"></span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination scope="certificates" :object="certificates" url="api/maintenance/certificates" classSize="pagination-sm"></pagination>
    </div>
</template>

<script>
    import Pagination from '../pagination/Pagination';

    export default {
        created() {
            this.$store.dispatch('loadCertificates','api/maintenance/certificates');
        },
        computed: {
            certificates() {
                return this.$store.getters.getIsoCertificates;
            },
            isLoading() {
                return this.$store.getters.getLoadingState;
            }
        },
        methods: {
            edit(certificate) {
                this.$store.dispatch('setModalFormType', 'EDIT_ISO').then(() => {
                    this.$store.dispatch('setModalTitle', 'Edit Certificate');
                    this.$store.dispatch('loadCertificate', certificate);  
                    $("#createUserModal").modal("show");
                    this.$store.dispatch('setLoadingState', true);
                });
            },
            destroy(certificate) {
                let deletionType = {
                    scope: "certificates",
                    certificate: certificate
                };

                this.$store.dispatch('setModalTitle', "Delete " + certificate.iso_name + " ?");
                this.$store.dispatch('setDeletionType', deletionType);
                this.$store.dispatch('showConfirmationModal');
            }
        },
        components: {
            Pagination
        }
    }
</script>

<style>

</style>

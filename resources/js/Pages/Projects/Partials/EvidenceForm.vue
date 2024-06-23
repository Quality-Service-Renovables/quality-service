<template>
    <v-card class="mx-auto">
        <file-pond name="evidence" ref="pond"
            label-idle="Arrastra y suelta tu archivo o <span class='filepond--label-action'>selecciona</span>"
            :allow-multiple="false" accepted-file-types="image/jpeg, image/png" :files="myFiles"
            @init="handleFilePondInit" :server="serverConfig" instantUpload="false" allowProcess="true"
            labelButtonProcessItem="Subir" />

        <v-card-title>
            <v-text-field label="Título" v-model="form.title" variant="outlined" hide-details
                density="compact"></v-text-field>
        </v-card-title>
        <v-card-title>
            <v-text-field label="Título secundario" v-model="form.titleSecondary" variant="outlined" hide-details
                density="compact"></v-text-field>
        </v-card-title>
        <v-card-title>
            <v-textarea label="Descripción" v-model="form.description" variant="outlined" rows="2" hide-details
                density="compact"></v-textarea>
        </v-card-title>
        <v-card-title>
            <v-textarea label="Descripción secundaría" v-model="form.descriptionSecondary" variant="outlined" rows="2"
                hide-details density="compact"></v-textarea>
        </v-card-title>
    </v-card>
</template>

<script>
import { Toaster, toast } from 'vue-sonner'
// Import Vue FilePond
import vueFilePond from "vue-filepond";
import axios from 'axios';
// Import FilePond styles
import "filepond/dist/filepond.min.css";
// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageEdit from "filepond-plugin-image-edit";

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageEdit
);
export default {
    props: {
        inspection_uuid: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            myFiles: [],
            form: {
                inspection_uuid: this.inspection_uuid,
                evidence_store: null,
                evidence_store_secondary: null,
                title: 'Título',
                titleSecondary: 'Título secundario',
                description: 'Descripción',
                descriptionSecondary: 'Descripción secundaría',
                inspection_evidence_secondary: null,
            },
            formDefault: {
                inspection_uuid: this.inspection_uuid,
                evidence_store: null,
                evidence_store_secondary: null,
                title: 'Título',
                titleSecondary: 'Título secundario',
                description: 'Descripción',
                descriptionSecondary: 'Descripción secundaría',
                inspection_evidence_secondary: null,
            },
            serverConfig: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    // Create FormData to send the file
                    /*const formData = new FormData();
                    formData.append(fieldName, file, file.name);*/
                    this.form.evidence_store = file;
                    this.form.inspection_evidence_secondary = this.form.evidence_store;

                    // Create a CancelToken source
                    const CancelToken = axios.CancelToken;
                    const source = CancelToken.source();

                    if (!this.form.title) {
                        toast.error("El campo título es requerido");
                        abort();
                    }

                    // Send the file to the backend using axios
                    axios.post('api/inspection/evidences', this.form, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        cancelToken: source.token,
                        onUploadProgress: (e) => {
                            // Update the progress indicator, can call the progress method multiple times
                            progress(e.lengthComputable, e.loaded, e.total);
                        }
                    })
                        .then(response => {
                            // Pass the file id to FilePond so it can be used later
                            load(response.data.fileId);
                            setTimeout(() => {
                                this.myFiles = [];
                                this.form = this.formDefault;
                            }, 2000);
                        })
                        .catch(thrown => {
                            if (axios.isCancel(thrown)) {
                                console.log('Request canceled', thrown.message);
                                // Let FilePond know the request has been cancelled
                                abort();
                            } else {
                                console.error('Error uploading file to the server', thrown);
                                // Pass error to FilePond
                                error('Error uploading file to the server');
                                this.handleErrors(thrown);
                            }
                        });

                    // Should expose an abort method so the request can be cancelled
                    return {
                        abort: () => {
                            // Cancel the request
                            source.cancel('Operation canceled by the user.');
                        }
                    };
                }
            }
        };
    },
    methods: {
        handleFilePondInit() {
            console.log("FilePond has initialized");
            // FilePond instance methods are available on `this.$refs.pond`
        }
    },
    components: {
        FilePond,
        Toaster
    },
};
</script>



<style scoped></style>
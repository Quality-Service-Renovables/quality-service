<template>
    <v-card class="pb-0" border="dashed thin dark md">
        <file-pond name="evidence" ref="pond"
            label-idle="Arrastra y suelta tu archivo o <span class='filepond--label-action'>selecciona</span>"
            :allow-multiple="false" accepted-file-types="image/jpeg, image/png" :files="myFiles"
            @init="handleFilePondInit" :server="serverConfig" instantUpload="false" allowProcess="true"
            allowReplace="true" allowImagePreview="true" labelInvalidField="Tipo de archivo no permitido"
            labelFileLoading="Cargando" labelFileLoadError="Error al subir el archivo" labelFileProcessing="Procesando"
            labelFileProcessingComplete="Proceso completado" labelFileProcessingAborted="Proceso abortado"
            labelFileProcessingError="Error al procesar" labelTapToCancel="Toca para cancelar"
            labelTapToRetry="Toca para reintentar" labelTapToUndo="Toca para deshacer"
            labelButtonAbortItemLoad="Cancelar" labelButtonRetryItemLoad="Reintentar"
            labelButtonAbortItemProcessing="Cancelar" labelButtonProcessItem="Subir"
            :class="evidence ? 'min-height' : ''" 
            />

        <v-card-title>
            <v-text-field label="Título" v-model="form.title" variant="outlined" hide-details
                density="compact"></v-text-field>
        </v-card-title>
        <!--<v-card-title>
            <v-text-field label="Título secundario" v-model="form.title_secondary" variant="outlined" hide-details
                density="compact"></v-text-field>
        </v-card-title>-->
        <v-card-title class="pb-0">
            <v-textarea label="Descripción" v-model="form.description" variant="outlined" rows="2" hide-details
                density="compact"></v-textarea>
        </v-card-title>
        <!--<v-card-title>
            <v-textarea label="Descripción secundaría" v-model="form.description_secondary" variant="outlined" rows="2"
                hide-details density="compact"></v-textarea>
        </v-card-title>-->
        <v-card-actions class="p-0 m-0">
            <!--Delete button-->
            <v-btn color="error" @click="dialogDelete = true" v-if="evidence" block @mouseover="isHoveredDelete = true"
                @mouseleave="isHoveredDelete = false">
                <v-icon left class="text-h5 primary-color">
                    {{ isHoveredDelete ? 'mdi-delete-empty-outline' : 'mdi-delete-outline' }}
                </v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
    <v-dialog v-model="dialogDelete" max-width="500px">
        <v-card>
            <v-card-title class="text-h5 text-center">¿Estás seguro de
                eliminar?</v-card-title>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue-darken-1" variant="text" @click="dialogDelete = false">Cancelar</v-btn>
                <v-btn color="blue-darken-1" variant="text" @click="deleteEvidence()">Si,
                    eliminar</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { Toaster, toast } from 'vue-sonner'
import Swal from "sweetalert2";

// Import Vue FilePond
import vueFilePond from "vue-filepond";
import axios from 'axios';
// Import FilePond styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.css";
// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";
import FilePondPluginImageTransform from "filepond-plugin-image-transform";

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFilePoster,
    FilePondPluginImageTransform
);
export default {
    props: {
        inspection_uuid: {
            type: String,
            required: true
        },
        evidence: {
            type: Object,
            required: false
        },
        position: {
            type: Number,
            required: false
        }
    },
    data() {
        return {
            myFiles: [],
            action: 'create',
            dialogDelete: false,
            isHoveredDelete: false,
            form: {
                inspection_uuid: this.inspection_uuid,
                evidence_store: null,
                evidence_store_secondary: null,
                title: 'Título',
                title_secondary: null,
                description: 'Descripción',
                description_secondary: null,
                inspection_evidence_secondary: null,
            },
            formDefault: {
                inspection_uuid: this.inspection_uuid,
                evidence_store: null,
                evidence_store_secondary: null,
                title: 'Título',
                title_secondary: null,
                description: 'Descripción',
                description_secondary: null,
                inspection_evidence_secondary: null,
            },
            serverConfig: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    this.form.evidence_store = file;

                    // Create a CancelToken source
                    const CancelToken = axios.CancelToken;
                    const source = CancelToken.source();

                    if (!this.form.title) {
                        toast.error("El título es requerido");
                        this.abort(source);
                    }

                    this.save(source, load, error, progress);
                }
            }
        };
    },
    mounted() {
        if (this.evidence) {
            this.action = 'update';
            this.form.evidence_store = this.evidence.inspection_evidence;
            //this.form.evidence_store_secondary = this.evidence.inspection_evidence_secondary;
            this.form.title = this.evidence.title;
            //this.form.title_secondary = this.evidence.title_secondary;
            this.form.description = this.evidence.description;
            //this.form.description_secondary = this.evidence.description_secondary;
            this.myFiles = [
                {
                    source: this.evidence.inspection_evidence,
                    options: {
                        type: 'remote',
                    },
                },
            ];
        }
    },
    methods: {
        handleFilePondInit() {
            // FilePond instance methods are available on `this.$refs.pond`
        },
        save(source, load, error, progress) {
            this.form.position = this.position;
            if (this.action === 'create') {
                axios.post('api/inspection/evidences', this.form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    cancelToken: source.token,
                    onUploadProgress: (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    }
                })
                    .then(response => {
                        load(response.data.fileId);
                        setTimeout(() => {
                            this.myFiles = [];
                            this.form = this.formDefault;
                            this.$emit('getEvidences');
                        }, 2000);
                    })
                    .catch(thrown => {
                        if (axios.isCancel(thrown)) {
                            this.abort(source);
                        } else {
                            error('Error al subir la información.');
                            this.handleErrors(thrown);
                        }
                    });
            } else if (this.action === 'update') {
                axios.post('api/inspection/evidences/update/' + this.evidence.inspection_evidence_uuid, this.form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    cancelToken: source.token,
                    onUploadProgress: (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    }
                })
                    .then(response => {
                        load(response.data.fileId);
                        setTimeout(() => {
                            console.log("Se actualizó la evidencia");
                            this.$emit('getEvidences');
                        }, 2000);
                    })
                    .catch(thrown => {
                        if (axios.isCancel(thrown)) {
                            this.abort(source);
                        } else {
                            error('Error al subir la información.');
                            this.handleErrors(thrown);
                        }
                    });
            }
        },
        abort() {
            source.cancel('Operación cancelada por el usuario.');
        },
        deleteEvidence() {
            console.log("Entro a eliminar");

            axios.delete('api/inspection/evidences/' + this.evidence.inspection_evidence_uuid)
                .then(response => {
                    toast.success("Evidencia eliminada");
                    this.$emit('getEvidences');
                })
                .catch(error => {
                    this.handleErrors(error);
                });

        },
    },
    components: {
        FilePond,
        Toaster,
    },
};
</script>



<style scoped>
.min-height {
    min-height: 300px;
}

/* bright / dark mode */
.pintura-editor {
  --color-background: 255, 255, 255;
  --color-foreground: 10, 10, 10;
  box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
}

@media (prefers-color-scheme: dark) {
  html {
    color: #fff;
    background: #111;
  }

  .pintura-editor {
    --color-background: 10, 10, 10;
    --color-foreground: 255, 255, 255;
    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.1);
  }
}
</style>
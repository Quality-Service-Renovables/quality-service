<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Usuarios" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="users" fixed-header :search="search">
                                    <template v-slot:item.active="{ value }">
                                        <v-icon :color="getColor(value)">mdi-circle-slice-8</v-icon>
                                    </template>
                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            <v-toolbar-title class="ml-1">
                                                <v-text-field v-model="search" label="Buscar" hide-details
                                                    variant="solo" append-inner-icon="mdi-magnify"
                                                    density="compact"></v-text-field>
                                            </v-toolbar-title>
                                            <v-divider class="mx-4" inset vertical></v-divider>
                                            <v-spacer></v-spacer>
                                            <v-dialog v-model="dialog" width="auto"
                                                v-if="hasPermissionTo('users.create') || hasPermissionTo('users.update')" scrollable>
                                                <template v-slot:activator="{ props }"
                                                    v-if="hasPermissionTo('users.create')">
                                                    <v-btn class="mb-2" color="primary" dark v-bind="props"
                                                        icon="mdi-plus"></v-btn>
                                                </template>
                                                <v-card max-width="100%">
                                                    <v-card-title>
                                                        <span class="text-h5">{{ formTitle }}</span>
                                                    </v-card-title>

                                                    <v-card-text>
                                                        <v-container>
                                                            <v-row class="justify-center align-center">
                                                                <v-col cols="12" lg="4">
                                                                    <file-pond name="evidence" ref="pond"
                                                                        label-idle="Arrastra y suelta tu archivo o <span class='filepond--label-action'>selecciona</span>"
                                                                        :allow-multiple="false"
                                                                        accepted-file-types="image/jpeg, image/png"
                                                                        :files="myFiles" @init="handleFilePondInit"
                                                                        :server="serverConfig" instantUpload="false"
                                                                        allowProcess="true" allowReplace="true"
                                                                        allowImagePreview="true" allowUndo="false"
                                                                        labelInvalidField="Tipo de archivo no permitido"
                                                                        labelFileLoading="Cargando"
                                                                        labelFileLoadError="Error al subir el archivo"
                                                                        labelFileProcessing="Procesando"
                                                                        labelFileProcessingComplete="Proceso completado"
                                                                        labelFileProcessingAborted="Proceso abortado"
                                                                        labelFileProcessingError="Error al procesar"
                                                                        labelTapToCancel="Toca para cancelar"
                                                                        labelTapToRetry="Toca para reintentar"
                                                                        labelTapToUndo=""
                                                                        labelButtonAbortItemLoad="Cancelar"
                                                                        labelButtonRetryItemLoad="Reintentar"
                                                                        labelButtonAbortItemProcessing="Cancelar"
                                                                        labelButtonProcessItem="Subir"
                                                                        imagePreviewHeight='170'
                                                                        imageCropAspectRatio="1:1"
                                                                        imageResizeTargetWidth='200'
                                                                        imageResizeTargetHeight='200'
                                                                        stylePanelLayout='compact circle'
                                                                        styleLoadIndicatorPosition='center bottom'
                                                                        styleButtonRemoveItemPosition='left bottom'
                                                                        styleButtonProcessItemPosition='right bottom'
                                                                        styleProgressIndicatorPosition='right bottom' max-width="200"/>
                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.name"
                                                                        label="Nombre" variant="outlined"
                                                                        :rules="[rules.required]"></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12" lg="6">
                                                                    <v-text-field v-model="editedItem.email"
                                                                        label="Email" variant="outlined"
                                                                        :rules="[rules.required, rules.email]"></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12" lg="6">
                                                                    <v-text-field v-model="editedItem.phone"
                                                                        label="Teléfono (opcional)" v-maska="options"
                                                                        data-maska-reversed variant="outlined"
                                                                        />
                                                                </v-col>
                                                                <v-col cols="12" lg="6">
                                                                    <v-select v-model="editedItem.client_uuid"
                                                                        :items="clients" label="Cliente"
                                                                        item-title="client" item-value="client_uuid"
                                                                        dense variant="outlined"
                                                                        :rules="[rules.required]"></v-select>
                                                                </v-col>
                                                                <v-col cols="12" lg="6">
                                                                    <v-select v-model="editedItem.rol" :items="roles"
                                                                        label="Rol" item-title="description"
                                                                        item-value="name" dense variant="outlined"
                                                                        :rules="[rules.required]"></v-select>
                                                                </v-col>
                                                                <v-col cols="12" lg="6" v-if="editedIndex == -1">
                                                                    <v-text-field v-model="editedItem.password"
                                                                        label="Contraseña" type="password"
                                                                        variant="outlined"
                                                                        :rules="[rules.required, rules.password]"
                                                                        required></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12" lg="6" v-if="editedIndex == -1">
                                                                    <v-text-field v-model="editedItem.password_confirm"
                                                                        label="Confirmar contraseña" type="password"
                                                                        variant="outlined"
                                                                        :rules="[rules.required, rules.password_confirm]"
                                                                        required></v-text-field>
                                                                </v-col>
                                                                <v-col cols="12" lg="3">
                                                                    <v-switch label="Activo" v-model="editedItem.active"
                                                                        color="primary"
                                                                        :readonly="editedItem.roles && editedItem.roles[0].name === 'admin'"></v-switch>
                                                                </v-col>
                                                            </v-row>
                                                        </v-container>
                                                    </v-card-text>

                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text" @click="close">
                                                            Cancelar
                                                        </v-btn>
                                                        <v-btn color="blue-darken-1" variant="text" @click="save">
                                                            Guardar
                                                        </v-btn>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                            <v-dialog v-model="dialogDelete" max-width="500px">
                                                <v-card>
                                                    <v-card-title class="text-h5 text-center">¿Estás seguro de
                                                        eliminar?</v-card-title>
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text"
                                                            @click="closeDelete">Cancel</v-btn>
                                                        <v-btn color="blue-darken-1" variant="text"
                                                            @click="deleteItemConfirm(editedItem.uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon class="me-2" size="small" @click="editItem(item)"
                                            v-if="hasPermissionTo('users.update')">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon size="small" @click="deleteItem(item)"
                                            v-if="hasPermissionTo('users.delete') && item.roles[0].name != 'admin'">
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
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

// Plugin Maska for phone number input
import { vMaska } from "maska/vue"

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
);
export default {
    directives: { maska: vMaska },
    components: {
        Toaster,
        FilePond,
    },
    props: {
        users: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            search: '',
            dialog: false,
            dialogDelete: false,
            headers: [
                { title: 'Usuario', key: 'name' },
                { title: 'Email', key: 'email' },
                { title: 'Teléfono', key: 'phone' },
                { title: 'Cliente', key: 'client.client' },
                { title: 'Rol', key: 'roles[0].description' },
                { title: 'Estado', key: 'active' },
                { title: 'Actions', key: 'actions', sortable: false }
            ],
            editedIndex: -1,
            editedItem: {
                uuid: '',
                name: '',
                email: '',
                image_profile: '',
                phone: '',
                password: '',
                password_confirm: '',
                client_uuid: '',
                rol: '',
                active: false,
            },
            defaultItem: {
                uuid: '',
                name: '',
                email: '',
                image_profile: '',
                phone: '',
                password: '',
                password_confirm: '',
                client_uuid: '',
                rol: '',
                active: false,
            },
            roles: [],
            clients: [],
            myFiles: [],
            serverConfig: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    this.editedItem.image_profile = file;
                    const CancelToken = axios.CancelToken;
                    const source = CancelToken.source();
                    this.updatePhoto(source, load, error, progress);
                }
            },
            options: {
                mask: "###-###-####",
                eager: true
            },
            rules: {
                required: value => !!value || 'Requerido.',
                email: value => {
                    if (!value) return 'Requerido.';
                    if (!/.+@.+\..+/.test(value)) return 'Email inválido.';
                    return true;
                },
                password: value => {
                    if (value.length < 8) {
                        return 'La contraseña debe tener al menos 8 caracteres.';
                    }
                    return true;
                },
                password_confirm: value => {
                    if (this.editedItem.password !== '' && (this.editedItem.password === this.editedItem.password_confirm)) {
                        return true;
                    }
                    return "Las contraseñas no coinciden.";
                },
            },
        }
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nuevo usuario' : 'Editar usuario'
        },
    },
    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },
    methods: {
        editItem(item) {
            this.editedIndex = this.users.indexOf(item)
            item.active = item.active == "1" ? true : false
            item.client_uuid = item.client.client_uuid;
            item.rol = item.roles[0].name;

            if (item.image_profile) {
                this.setImage(item.image_profile);
            }

            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        setImage(image_profile) {
            this.myFiles = [
                {
                    source: image_profile,
                    options: {
                        type: 'remote',
                    },
                },
            ];
        },
        deleteItem(item) {
            this.editedIndex = this.users.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(uuid) {
            const putRequest = () => {
                return axios.delete('api/users/' + uuid);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    this.$inertia.reload()
                    return 'Usuario eliminado correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
        },
        close() {
            this.dialog = false
            this.$nextTick(() => {
                console.log("Cambiando estatus en close");
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
                this.myFiles = [];
            })
        },
        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                console.log("Cambiando estatus en closeDelete");
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        save() {
            this.editedItem.phone = this.editedItem.phone ? this.editedItem.phone.replace(/-/g, '') : null;
            if (this.editedIndex > -1) {
                const request = () => {
                    return axios.post('api/users/update/' + this.editedItem.uuid, this.editedItem);
                };
                toast.promise(request(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Usuario actualizado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                const request = () => {
                    return axios.post('api/users', this.editedItem);
                };

                toast.promise(request(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Usuario creado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            }

        },
        getColor(value) {
            return value ? 'green' : 'red';
        },
        getRoles() {
            axios.get('api/auth-guard/roles')
                .then(response => {
                    this.roles = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al cargar los roles');
                });
        },
        getClients() {
            axios.get('api/clients')
                .then(response => {
                    this.clients = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al cargar los clientes');
                });
        },
        updatePhoto(source, load, error, progress) {
            return axios.post('api/users/update-picture/' + this.editedItem.uuid, this.editedItem, {
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
                        console.log("Se actualizó la foto de perfil");
                        this.$inertia.reload()
                        this.setImage(response.data.data.image_profile);
                    }, 1500);
                })
                .catch(thrown => {
                    if (axios.isCancel(thrown)) {
                        this.abort(source);
                    } else {
                        error('Error al subir la foto.');
                        this.handleErrors(thrown);
                    }
                });
        },
        checkPassword() {
            if (this.editedItem.password !== '' && (this.editedItem.password === this.editedItem.password_confirm)) {
                return true;
            }
            return false;
        },
    },
    mounted() {
        this.getRoles();
        this.getClients();
    }
}
</script>



<style scoped>
/*
 * FilePond Custom Styles
 */

.filepond--drop-label {
    color: #4c4e53;
}

.filepond--label-action {
    text-decoration-color: #babdc0;
}

.filepond--panel-root {
    background-color: #edf0f4;
}

.filepond--root {
    width: 170px;
    margin: 0 auto;
}
</style>
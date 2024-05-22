<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <v-row>
        <v-col cols="12" sm="12">
            <v-data-table :headers="headers" :items="roles" fixed-header :search="search" :loading="loadingRoles">
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title class="ml-1">
                            <v-text-field v-model="search" label="Buscar" hide-details variant="solo"
                                append-inner-icon="mdi-magnify" density="compact"></v-text-field>
                        </v-toolbar-title>
                        <v-divider class="mx-4" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="1000px">
                            <template v-slot:activator="{ props }">
                                <v-btn class="mb-2" color="primary" dark v-bind="props" icon="mdi-plus"></v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">{{ formTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field v-model="editedItem.name" label="Nombre" variant="solo"
                                                    hide-details></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-divider></v-divider>
                                            </v-col>
                                            <v-col cols="12">
                                                <h1 class="text-h5">Permisos</h1>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-row>
                                                    <v-col cols="6" md="6" v-for="permission in permissions"
                                                        :key="permission.id">
                                                        <h1 class="text-h6">{{ permission.name }}</h1>
                                                        <v-checkbox label="Ver" hide-details class="py-0"></v-checkbox>
                                                        <v-checkbox label="Crear" hide-details class="py-0"></v-checkbox>
                                                        <v-checkbox label="Editar" hide-details class="py-0"></v-checkbox>
                                                        <v-checkbox label="Eliminar" hide-details class="py-0"></v-checkbox>
                                                    </v-col>
                                                </v-row>
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
                                <v-card-title class="text-h5 text-center">¿Estás seguro
                                    de
                                    eliminar?</v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue-darken-1" variant="text" @click="closeDelete">Cancel</v-btn>
                                    <v-btn color="blue-darken-1" variant="text"
                                        @click="deleteItemConfirm(editedItem.id)">Si,
                                        eliminar</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon class="me-2" size="small" @click="editItem(item)">
                        mdi-pencil
                    </v-icon>
                    <v-icon size="small" @click="deleteItem(item)">
                        mdi-delete
                    </v-icon>
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>


<script>
import { Toaster, toast } from 'vue-sonner'

export default {
    components: {
        Toaster,
    },
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: 'Nombre', key: 'name' },
            { title: 'Usuarios', key: 'users' },
            { title: 'Actions', key: 'actions', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            id: '',
            name: '',
        },
        defaultItem: {
            id: '',
            name: '',
        },
        loadingRoles: false,
        roles: [],
        permissions: [],
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nuevo rol' : 'Editar rol'
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
            this.editedIndex = this.roles.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.roles.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            this.roles.splice(this.editedIndex, 1)
            const putRequest = () => {
                return axios.delete('api/auth-guard/roles/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    return 'Rol eliminada correctamente';
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
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
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
            if (this.editedIndex > -1) {
                const putRequest = () => {
                    return axios.put('api/auth-guard/roles/' + this.editedItem.id, {
                        name: this.editedItem.name,
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Rol actualizado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                this.roles.push(this.editedItem)
                const postRequest = () => {
                    return axios.post('api/auth-guard/roles', {
                        name: this.editedItem.name,
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.close()
                        return 'Rol creado correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            }

        },
        fetchRoles() {
            this.loadingRoles = true;
            return axios.get('api/auth-guard/roles').then(response => {
                this.roles = response.data.data;
                this.loadingRoles = false;
            }).catch(error => {
                this.loadingRoles = false;
                toast.error('Error al cargar el catálogo de roles');
            });
        },
        fetchPermissions() {
            return axios.get('api/auth-guard/permissions').then(response => {
                this.permissions = response.data.data;
            }).catch(error => {
                toast.error('Error al cargar el catálogo de permisos');
            });
        }
    },
    mounted() {
        this.fetchRoles();
        this.fetchPermissions();
    }
}
</script>

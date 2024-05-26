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
                        <v-dialog v-model="dialog" max-width="1200px">
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">{{ formTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field v-model="editedItem.name" label="Nombre del rol"
                                                    variant="solo" hide-details></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-divider></v-divider>
                                            </v-col>
                                            <v-col cols="12">
                                                <h1 class="text-h5">Permisos del rol "{{ editedItem.name }}"</h1>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-row>
                                                    <v-col cols="4" md="4" v-for="permission in permissions"
                                                        :key="permission.id">
                                                        <h1 class="text-h6">{{ permission.name }}</h1>
                                                        <v-checkbox v-for="perm in permission.permissions"
                                                            :key="perm.id" :label="perm.name" hide-details class="py-0"
                                                            v-model="perm.checked"></v-checkbox>
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
                    </v-toolbar>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon class="me-2" size="small" @click="editItem(item)">
                        mdi-pencil
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
        headers: [
            { title: 'Nombre', key: 'name' },
            { title: 'Acciones', key: 'actions', sortable: false }
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
    },
    methods: {
        editItem(item) {
            this.editedIndex = this.roles.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
            this.restorePermissions();
            this.checkPermissions();
        },
        checkPermissions() {
            this.editedItem.permissions.forEach(perm => {
                this.permissions.map(permission => {
                    permission.permissions.map(p => {
                        //console.log("Comparando " + p.id + " con " + perm.id + " " + (p.id == perm.id));
                        if (p.id == perm.id) {
                            p.checked = true;
                        }
                    });
                });
            });
        },
        restorePermissions() {
            this.permissions.forEach(permission => {
                permission.checked = false;
                permission.permissions.forEach(perm => {
                    perm.checked = false;
                });
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
        save() {
            console.log("Guardando...");
            let permissionsAux = this.extractPermissions();
            console.log(permissionsAux);
            if (this.editedIndex > -1) {
                const putRequest = () => {
                    return axios.put('api/auth-guard/role-permissions/' + this.editedItem.id, {
                        name: this.editedItem.name,
                        permissions: permissionsAux
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.$inertia.reload()
                        this.fetchRoles();
                        this.close()
                        return 'Rol actualizado correctamente';
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
            return axios.get('api/auth-guard/permissions-grouped').then(response => {
                this.permissions = response.data.data;
            }).catch(error => {
                toast.error('Error al cargar el catálogo de permisos');
            });
        },
        extractPermissions() {
            let permissionsSet = new Set();

            this.permissions.forEach(permission => {
                permission.permissions.forEach(perm => {
                    if (perm.checked) {
                        permissionsSet.add(perm.id);
                        permissionsSet.add(permission.id); // Se agrega el ID del permiso principal
                    }
                });
            });

            // Convertimos el conjunto a un array y lo retornamos
            return Array.from(permissionsSet);
        }

    },
    mounted() {
        this.fetchRoles();
        this.fetchPermissions();
    }
}
</script>

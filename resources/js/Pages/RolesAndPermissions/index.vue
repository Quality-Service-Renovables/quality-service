<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Head title="Roles y permisos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Roles y permisos</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-tabs v-model="tab" bg-color="light">
                            <v-tab value="roles">Roles</v-tab>
                            <v-tab value="permissions">Permisos</v-tab>
                        </v-tabs>
                        <v-card-text>
                            <v-tabs-window v-model="tab">
                                <v-tabs-window-item v-if="tab == 'roles'">
                                    <Roles />
                                </v-tabs-window-item>

                                <v-tabs-window-item v-if="tab == 'permissions'">
                                    <Permissions />
                                </v-tabs-window-item>
                            </v-tabs-window>
                        </v-card-text>
                    </v-card>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script>
import Roles from '@/Pages/RolesAndPermissions/Roles.vue'
import Permissions from '@/Pages/RolesAndPermissions/Permissions.vue'

export default {
    components: {
        Roles,
        Permissions
    },
    data: () => ({
        tab: null,
    }),

}
</script>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Recibimos los artistas desde el controlador de Laravel
defineProps({
    artistas: Array
});

const form = useForm({});

// Función para confirmar y eliminar un artista
const deleteArtista = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este artista? Se borrarán también sus pinturas.')) {
        form.delete(route('artistas.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Artistas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Artistas</h2>
                <Link :href="route('artistas.create')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition">
                    + Nuevo Artista
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombres</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nacionalidad</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="artista in artistas" :key="artista.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{ artista.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ artista.nombres }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ artista.nacionalidad }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium space-x-2">
                                        <Link :href="route('artistas.edit', artista.id)" class="text-amber-600 hover:text-amber-900 bg-amber-50 px-3 py-1 rounded-md border border-amber-200 transition">
                                            Editar
                                        </Link>
                                        <button @click="deleteArtista(artista.id)" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md border border-red-200 transition">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="artistas.length === 0">
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                                        No hay artistas registrados todavía. ¡Prueba agregando uno!
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
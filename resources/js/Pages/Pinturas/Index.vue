<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Recibimos las pinturas desde Laravel (ya traen la información del artista)
defineProps({
    pinturas: Array
});

const form = useForm({});

// Función para eliminar pintura de forma segura
const deletePintura = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar esta obra de arte?')) {
        form.delete(route('pinturas.destroy', id));
    }
};
</script>

<template>
    <Head title="Galería de Pinturas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Galería de Pinturas</h2>
                <Link :href="route('pinturas.create')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition">
                    + Registrar Obra
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obra</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artista</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Técnica</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="pintura in pinturas" :key="pintura.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img 
                                            v-if="pintura.imagen" 
                                            :src="pintura.imagen" 
                                            alt="Imagen de la obra" 
                                            class="w-16 h-16 object-cover rounded shadow border"
                                        />
                                        <div v-else class="w-16 h-16 bg-gray-100 flex items-center justify-center text-xs text-gray-400 rounded border border-dashed">
                                            Sin foto
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">{{ pintura.titulo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ pintura.artista ? pintura.artista.nombres : 'Artista no asignado' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 italic">{{ pintura.tecnica }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                        ${{ parseFloat(pintura.precio).toLocaleString('en-US', { minimumFractionDigits: 2 }) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium space-x-2">
                                        <Link :href="route('pinturas.edit', pintura.id)" class="text-amber-600 hover:text-amber-900 bg-amber-50 px-3 py-1 rounded-md border border-amber-200 transition">
                                            Editar
                                        </Link>
                                        <button @click="deletePintura(pintura.id)" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md border border-red-200 transition">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="pinturas.length === 0">
                                    <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                        No hay obras registradas en la galería en este momento.
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
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Recibimos la lista de artistas desde el controlador para poblar el <select>
defineProps({
    artistas: Array
});

// Inicializamos el formulario de la pintura
const form = useForm({
    artista_id: '',
    titulo: '',
    tecnica: '',
    precio: '',
    imagen: null // Aquí guardaremos el archivo de la foto
});

// Función para capturar el archivo cuando el usuario lo selecciona
const handleFileUpload = (event) => {
    form.imagen = event.target.files[0];
};

// Enviamos los datos a Laravel
const submit = () => {
    form.post(route('pinturas.store'));
};
</script>

<template>
    <Head title="Registrar Obra de Arte" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar Nueva Obra de Arte</h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
                        
                        <div>
                            <label for="artista_id" class="block text-sm font-medium text-gray-700">Artista / Autor</label>
                            <select 
                                id="artista_id" 
                                v-model="form.artista_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option value="" disabled>-- Selecciona el artista autor --</option>
                                <option v-for="artista in artistas" :key="artista.id" :value="artista.id">
                                    {{ artista.nombres }} ({{ artista.nacionalidad }})
                                </option>
                            </select>
                            <div v-if="form.errors.artista_id" class="text-red-600 text-sm mt-1">
                                {{ form.errors.artista_id }}
                            </div>
                        </div>

                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700">Título de la Obra</label>
                            <input 
                                type="text" 
                                id="titulo" 
                                v-model="form.titulo" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Ej. La noche estrellada"
                            />
                            <div v-if="form.errors.titulo" class="text-red-600 text-sm mt-1">
                                {{ form.errors.titulo }}
                            </div>
                        </div>

                        <div>
                            <label for="tecnica" class="block text-sm font-medium text-gray-700">Técnica</label>
                            <input 
                                type="text" 
                                id="tecnica" 
                                v-model="form.tecnica" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Ej. Óleo sobre lienzo, Acuarela, Escultura"
                            />
                            <div v-if="form.errors.tecnica" class="text-red-600 text-sm mt-1">
                                {{ form.errors.tecnica }}
                            </div>
                        </div>

                        <div>
                            <label for="precio" class="block text-sm font-medium text-gray-700">Precio Estimado ($)</label>
                            <input 
                                type="number" 
                                step="0.01"
                                id="precio" 
                                v-model="form.precio" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="0.00"
                            />
                            <div v-if="form.errors.precio" class="text-red-600 text-sm mt-1">
                                {{ form.errors.precio }}
                            </div>
                        </div>

                        <div>
                            <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen de la Obra</label>
                            <input 
                                type="file" 
                                id="imagen" 
                                @change="handleFileUpload"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                accept="image/*"
                            />
                            <div v-if="form.errors.imagen" class="text-red-600 text-sm mt-1">
                                {{ form.errors.imagen }}
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <Link :href="route('pinturas.index')" class="text-sm text-gray-600 hover:text-gray-900 px-3 py-2">
                                Cancelar
                            </Link>
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition disabled:opacity-50"
                            >
                                {{ form.processing ? 'Registrando...' : 'Registrar Pintura' }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
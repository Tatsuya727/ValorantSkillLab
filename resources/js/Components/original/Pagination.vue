<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({ links: Array });
</script>
<template>
    <div v-if="links.length > 3">
        <div class="flex justify-center flex-wrap -mb-1">
            <template v-for="(link, index) in links" :key="index">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-200 border border-gray-400 rounded" v-html="link.label" />
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-indigo-300 focus:border-indigo-500 focus:text-indigo-700"
                    :class="{ 'bg-indigo-500 text-white': link.active, 'bg-white text-neutral-700': !link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

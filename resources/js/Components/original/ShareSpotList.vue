<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    category: {
        type: Object,
        required: true,
    },
    selectedTag: {
        type: String,
        required: false,
    },
    // mapId: {
    //     type: Number,
    //     required: false,
    // },
    // characterId: {
    //     type: Number,
    //     required: false,
    // },
});

const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    selectedTag.value = tag;
    localStorage.setItem('selectedTag', tag);
    if (props.mapName && props.mapId && props.characterName && props.characterId) {
        Inertia.get(route('sharespots.index'), {
            tag: tag,
            mapName: props.mapName,
            mapId: props.mapId,
            characterName: props.characterName,
            characterId: props.characterId,
            selectedTag: selectedTag.value,
        });
    } else if (props.mapName && props.mapId) {
        Inertia.get(route('sharespots.index'), {
            tag: tag,
            mapName: props.mapName,
            mapId: props.mapId,
            selectedTag: selectedTag.value,
        });
    } else if (props.characterName && props.characterId) {
        Inertia.get(route('sharespots.index'), {
            tag: tag,
            characterName: props.characterName,
            characterId: props.characterId,
            selectedTag: selectedTag.value,
        });
    } else {
        Inertia.get(route('sharespots.index'), {
            tag: tag,
            selectedTag: selectedTag.value,
        });
    }
};
</script>

<template>
    <div v-for="spot in props.spots" :key="spot.id" class="bg-zinc-900 m-10 text-white rounded-lg shadow-lg">
        <Link :href="spot.show_url" class="flex">
            <div>
                <img :width="300" cover class="rounded-l-lg" :src="spot.images[0].image_path" alt="サムネイル画像" loading="lazy" />
            </div>

            <div class="p-4">
                <h1 class="text-2xl font-bold">{{ spot.title }}</h1>
                <div class="mt-2">
                    <p class="text-sm text-gray-400">
                        map: <span class="font-bold text-white">{{ spot.map.name }}</span>
                    </p>
                    <p class="text-sm text-gray-400">
                        character: <span class="font-bold text-white">{{ spot.character.name }}</span>
                    </p>
                </div>
                <!-- タグの名前をすべて表示 -->
                <div class="flex flex-wrap mt-4">
                    <div v-for="(tag, index) in spot.tags" :key="index">
                        <div
                            @click="
                                filterSpotsByTag(tag.name);
                                $event.stopPropagation();
                            "
                            :class="{
                                'border-2 border-cyan-500 rounded-lg px-3 py-1 text-sm font-semibold text-white mr-2 mb-2 cursor-pointer hover:text-white hover:bg-cyan-500': !selectedTag.value,
                                'bg-cyan-500 text-white': selectedTag && selectedTag === tag.name,
                            }"
                        >
                            {{ tag.name }}
                        </div>
                    </div>
                </div>
            </div>
        </Link>
    </div>
</template>

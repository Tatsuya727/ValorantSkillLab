import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import ShareSpotHeader from '../original/ShareSpotHeader.vue';

describe('ShareSpotHeader.vue', () => {
    const propsData = {
        maps: [],
        characters: [],
        tags: [],
        categories: [],
        search: '',
        selectedTag: 'testTag', // 'testTag' is not a valid value for prop 'selectedTag
        selectedMap: {
            name: 'testMap',
        },
        selectedCharacter: {
            name: 'testCharacter',
        },
        selectedCategory: {
            name: 'testCategory',
        },
    };

    const isMobile = false;

    const wrapper = mount(ShareSpotHeader, { propsData });

    it('検索ボタンが存在する', () => {
        expect(wrapper.find('.search-button').exists()).toBe(true);
    });

    it('リセットボタンが存在する', () => {
        expect(wrapper.find('v-btn[color="red"]').exists()).toBe(true);
    });

    it('検索フィールドが存在する', () => {
        expect(wrapper.find('v-text-field[data-test="search-input"]').exists()).toBe(true);
    });

    it('マップの絞り込みが正しく表示される', () => {
        expect(wrapper.find('v-chip.selected-map').text()).toBe(propsData.selectedMap.name);
    });

    it('キャラクターの絞り込みが正しく表示される', () => {
        expect(wrapper.find('v-chip.selected-character').text()).toBe(propsData.selectedCharacter.name);
    });

    it('タグの絞り込みが正しく表示される', () => {
        expect(wrapper.find('v-chip.selected-tag').text()).toBe(propsData.selectedTag);
    });

    it('カテゴリーの絞り込みが正しく表示される', () => {
        expect(wrapper.find('v-chip.selected-category').text()).toBe(propsData.selectedCategory.name);
    });

    it('絞り込みボタンが存在する', () => {
        expect(wrapper.find('v-btn.filtering-btn').exists()).toBe(true);
    });
});

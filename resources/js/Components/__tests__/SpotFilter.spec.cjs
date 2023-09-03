import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import SpotFilter from '../original/SpotFilter.vue';

describe('SpotFilter.vue', () => {
    const propsData = {
        maps: [],
        characters: [],
        tags: [],
        categories: [],
        selectedTag: {},
        selectedMap: {},
        selectedCharacter: {},
        selectedCategory: {},
        search: '',
        routeName: 'testRoute',
    };

    const wrapper = mount(SpotFilter, { propsData });

    it('絞り込みボタンが存在する', () => {
        expect(wrapper.find('.filtering-btn').exists()).toBe(true);
    });

    it('ダイアログが表示される', () => {
        expect(wrapper.find('v-dialog').exists()).toBe(true);
    });

    it('マップタブが存在する', () => {
        expect(wrapper.find('v-tab[value="1"]').text()).toBe('マップ');
    });

    it('キャラクタータブが存在する', () => {
        expect(wrapper.find('v-tab[value="2"]').text()).toBe('キャラクター');
    });

    it('タグタブが存在する', () => {
        expect(wrapper.find('v-tab[value="3"]').text()).toBe('タグ');
    });

    it('カテゴリータブが存在する', () => {
        expect(wrapper.find('v-tab[value="4"]').text()).toBe('カテゴリー');
    });

    it('マップのv-autocompleteが存在する', () => {
        expect(wrapper.find('.map-select').exists()).toBe(true);
    });

    it('キャラクターのv-autocompleteが存在する', () => {
        expect(wrapper.find('.character-select').exists()).toBe(true);
    });

    it('タグのv-autocompleteが存在する', () => {
        expect(wrapper.find('.tag-select').exists()).toBe(true);
    });

    it('カテゴリーのv-autocompleteが存在する', () => {
        expect(wrapper.find('.category-select').exists()).toBe(true);
    });

    it('検索ボタンが存在する', () => {
        expect(wrapper.find('v-btn[color="success"]').exists()).toBe(true);
    });

    it('リセットボタンが存在する', () => {
        expect(wrapper.find('v-btn[color="error"]').exists()).toBe(true);
    });

    it('閉じるボタンが存在する', () => {
        console.log(wrapper.html());
        expect(wrapper.find('v-btn[color="primary"]').exists()).toBe(true);
    });
});

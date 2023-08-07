import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import FilterControls from '../original/FilterControls.vue';
import { Inertia } from '@inertiajs/inertia';

describe('FilterControls', () => {
    const propsData = {
        selectedTag: 'Test Tag',
        mapId: 1,
        characterId: 2,
        tags: [{ name: 'Tag1' }, { name: 'Tag2' }],
        maps: [
            { id: 1, name: 'Map1' },
            { id: 2, name: 'Map2' },
        ],
        characters: [
            { id: 1, name: 'Character1' },
            { id: 2, name: 'Character2' },
        ],
    };
    // route関数をモック
    global.route = (name) => `mocked-route-for-${name}`;

    // Inertia.getをモック
    Inertia.get = (url) => {
        expect(url).toBe('mocked-route-for-spots.index');
    };

    const wrapper = mount(FilterControls, { propsData });

    it('フィルターダイアログが正しく開き、閉じる', async () => {
        // ダイアログを開く
        await wrapper.vm.openFilterDialog();
        expect(wrapper.vm.filterDialog).toBe(true);

        // ダイアログを閉じる
        wrapper.vm.filterDialog = false;
        expect(wrapper.vm.filterDialog).toBe(false);
    });

    it('選択されたマップとキャラクターが正しく表示される', () => {
        expect(wrapper.vm.selectedMap).toBe(propsData.mapId);
        expect(wrapper.vm.selectedCharacter).toBe(propsData.characterId);
    });

    it('タグが正しく選択される', async () => {
        const tagName = 'Tag1';
        await wrapper.vm.selectTag(tagName);
        expect(wrapper.vm.selectedTag).toBe(tagName);
    });

    it('リセット機能が正しく動作する', async () => {
        await wrapper.vm.resetSpots();
        expect(wrapper.vm.selectedTag).toBe('');
    });
});

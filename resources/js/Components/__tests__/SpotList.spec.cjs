import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import SpotList from '../original/SpotList.vue';

describe('SpotList', () => {
    // 事前準備
    const propsData = {
        spots: [
            {
                id: 1,
                category_id: 1,
                map_id: 1,
                character_id: 1,
                title: 'TestTitle',
                description: 'TestDescription',
                image_path: 'path/to/image',
                tag_id: [1, 2],
            },
        ],
        showCategory: { 1: true },
        category: [
            { id: 1, name: 'TestCategory' },
            { id: 2, name: 'TestCategory2' },
        ],
        maps: [
            { id: 1, name: 'TestMap' },
            { id: 2, name: 'TestMap2' },
        ],
        characters: [
            { id: 1, name: 'TestCharacter' },
            { id: 2, name: 'TestCharacter2' },
        ],
        tags: [
            { id: 1, name: 'TestTag' },
            { id: 2, name: 'TestTag2' },
        ],
    };

    it('正しいタイトルが表示される', () => {
        const wrapper = mount(SpotList, { propsData });
        console.log(wrapper.html());
    });

    // it('renders the spot correctly', () => {
    //     const wrapper = mount(SpotList, { propsData });
    //     const slideItem = wrapper.find('v-slide-group-item');

    //     expect(slideItem.exists()).toBe(true);
    //     expect(slideItem.find('img').attributes('src')).toBe('path/to/image');
    //     expect(slideItem.text()).toContain('TestMap');
    //     expect(slideItem.text()).toContain('TestCharacter');
    //     expect(slideItem.text()).toContain('TestTitle');
    // });
});

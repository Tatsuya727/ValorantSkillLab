import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import SpotList from '../original/SpotList.vue';
import SpotTags from '../original/SpotTags.vue';
import SpotMenu from '../original/SpotMenu.vue';
import { Inertia } from '@inertiajs/inertia';

describe('SpotList.vue', () => {
    const propsData = {
        spots: {
            data: [
                {
                    id: 1,
                    title: 'Test Title',
                    description: 'Test Description',
                    tags: [{ name: 'Tag1' }, { name: 'Tag2' }],
                    map: { name: 'Map1' },
                    character: { name: 'Character1' },
                    images: [
                        { image_path: 'test.jpg', description: 'test' },
                        { image_path: 'test2.jpg', description: 'test2' },
                    ],
                    category: { name: 'Category1' },
                    user_id: 1,

                    user: {
                        id: 1,
                        name: 'Test User',
                    },
                },
                {
                    id: 2,
                    title: 'Test Title2',
                    description: 'Test Description2',
                    tags: [{ name: 'Tag3' }, { name: 'Tag4' }],
                    map: { name: 'Map2' },
                    character: { name: 'Character2' },
                    images: [
                        { image_path: 'test.jpg', description: 'test' },
                        { image_path: 'test2.jpg', description: 'test2' },
                    ],
                    category: { name: 'Category2' },
                    user_id: 2,

                    user: {
                        id: 2,
                        name: 'Test User2',
                    },
                },
            ],
        },
    };
    // route関数をモック
    global.route = (name) => `mocked-route-for-${name}`;

    // Inertia.getをモック
    Inertia.get = (url) => {
        expect(url).toBe('mocked-route-for-spots.index');
    };

    const wrapper = mount(SpotList, { propsData });
    const tag_wrapper = mount(SpotTags);
    it('タグが表示される', () => {
        const tag = wrapper.find('.common-tag');

        expect(tag.exists()).toBeTruthy();
    });

    it('タグがクリックされたらそのタグを持つspotのみが表示される', async () => {
        const tag = wrapper.findAll('.common-tag');
        await tag[0].trigger('click');

        const selectedTag = wrapper.find('.selected-tag');

        console.log('-----------------');
        console.log(selectedTag.html());
        console.log('-----------------');
        expect(selectedTag).toBeTruthy();
        expect(selectedTag.text()).toBe('Tag1');
    });
});

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
        user: {
            id: 1,
            name: 'Test User',
        },
        currentUser: {
            id: 1,
            name: 'Test User',
        },
        flash: {
            message: 'Test Message',
            success: true,
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

    it('タグがクリックされたらそのタグの色が変わる', async () => {
        const tag = wrapper.findAll('.common-tag');
        await tag[0].trigger('click');

        const selectedTag = wrapper.find('.selected-tag');

        expect(selectedTag).toBeTruthy();
        expect(selectedTag.text()).toBe('Tag1');
    });

    it('マップが表示される', () => {
        const maps = wrapper.findAll('.map-name');

        expect(maps[0].exists()).toBeTruthy();
        expect(maps[0].text()).toBe('Map1');
    });

    it('キャラクターが表示される', () => {
        const characters = wrapper.findAll('.character-name');

        expect(characters[0].exists()).toBeTruthy();
        expect(characters[0].text()).toBe('Character1');
    });

    // it('タイトルが表示される', () => {
    //     const titles = wrapper.findAll('.spot-title');

    //     expect(titles[0].exists()).toBeTruthy();
    //     expect(titles[0].text()).toBe('Test Title');
    // });
});

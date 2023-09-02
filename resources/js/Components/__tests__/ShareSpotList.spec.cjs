import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import ShareSpotHeader from '../original/ShareSpotHeader.vue';
import ShareSpotList from '../original/ShareSpotList.vue';
import { Inertia } from '@inertiajs/inertia';

describe('ヘッダーとリストの組み合わせテスト', () => {
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
            links: [
                {
                    url: 'http://localhost/spots?page=1',
                    label: 1,
                    active: true,
                },
                {
                    url: 'http://localhost/spots?page=2',
                    label: 2,
                    active: false,
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
        allSpotsCount: 2,
    };

    const user = {
        id: 1,
        name: 'name',
        email: 'email',
        email_verified_at: 'email_verified_at',
        created_at: 'created_at',
        updated_at: 'updated_at',
    };

    // route関数をモック
    global.route = (name) => `mocked-route-for-${name}`;

    // Inertia.getをモック
    Inertia.get = (url) => {
        expect(url).toBe('mocked-route-for-sharespots.index');
    };

    const wrapper = mount(ShareSpotList, {
        propsData,
    });

    it('投稿があるときは「すべての投稿 何件」と表示されている', () => {
        const title = wrapper.find('.title');
        expect(title.text()).toBe('すべての投稿 ' + propsData.allSpotsCount + ' 件');
    });

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

    it('作成者が表示される', () => {
        console.log(wrapper.html());
        const users = wrapper.findAll('.user-name');

        expect(users[0].exists()).toBeTruthy();
        expect(users[0].text()).toBe('Test User');
    });

    it('いいねボタンが表示される', () => {
        const likeButtons = wrapper.findAll('.like-btn');

        expect(likeButtons[0].exists()).toBeTruthy();
    });
});

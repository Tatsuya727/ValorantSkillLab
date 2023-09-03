import { describe, it, expect, vi } from 'vitest';
import { mount } from '@vue/test-utils';
import ShowMenu from '../original/ShowMenu.vue';

const mockRoute = (name, params = {}) => {
    const paramString = Object.entries(params)
        .map(([key, val]) => `${key}=${val}`)
        .join('&');
    return `mocked-route-for-${name}${paramString ? '?' + paramString : ''}`;
};

const createWrapper = (user, is_public = true) => {
    return mount(ShowMenu, {
        global: {
            mocks: {
                $page: {
                    props: {
                        auth: { user },
                        NavCategories: [],
                    },
                },
                route: mockRoute,
            },
        },
        propsData: {
            spot: {
                id: 1,
                // title: 'テストタイトル',
                // description: 'テスト説明',
                // tags: [{ name: 'テストタグ1' }, { name: 'テストタグ2' }],
                // images: [{ image_path: 'path/to/image1', description: '画像説明1' }, { image_path: 'path/to/image2' }],
                // map: { name: 'テストマップ' },
                // character: { name: 'テストキャラクター' },
                // category: { name: 'テストカテゴリー' },
                // user_id: 1,
                is_public: is_public,
                user: {
                    id: 1,
                    name: 'テストユーザー',
                },
            },
        },
    });
};

describe('ShowMenu.vue', () => {
    const testUser = {
        id: 1,
        name: 'test',
    };

    it('公開中のダイアログのタイトルが正しい', () => {
        const wrapper = createWrapper(testUser, true);
        const title = wrapper.find('.open-dialog-title');
        expect(title.text()).toBe('公開設定:公開中');
    });

    it('非公開中のダイアログのタイトルが正しい', () => {
        const wrapper = createWrapper(testUser, false);
        const title = wrapper.find('.open-dialog-title');
        expect(title.text()).toBe('公開設定:非公開中');
    });

    // it('公開設定のダイアログが表示される', async () => {
    //     const wrapper = createWrapper(testUser, true);
    //     const dialog = wrapper.find('.public-dialog');
    //     expect(dialog.isVisible()).toBe(false);
    //     await dialog.trigger('click');
    //     expect(dialog.isVisible()).toBe(true);
    // });

    // it('保存ボタンのダイアログが正しく動作する', async () => {
    //     const wrapper = createWrapper(testUser, true);
    //     await wrapper.setData({ saveDialog: true });
    //     const saveDialogTitle = wrapper.find('.headline');
    //     expect(saveDialogTitle.text()).toBe('保存先');
    // });

    // it('削除確認のダイアログが表示される', async () => {
    //     await wrapper.setData({ dialog: true });
    //     const deleteDialog = wrapper.find('.delete-dialog');
    //     expect(deleteDialog.isVisible()).toBe(true);
    // });
});

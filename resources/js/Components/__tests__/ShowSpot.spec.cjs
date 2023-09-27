import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import ShowSpot from '../original/ShowSpot.vue';

describe('ShowSpot.vue', () => {
    const propsData = {
        spot: {
            title: 'テストタイトル',
            description: 'テスト説明',
            tags: [{ name: 'テストタグ1' }, { name: 'テストタグ2' }],
            images: [{ image_path: 'path/to/image1', description: '画像説明1' }, { image_path: 'path/to/image2' }],
            map: { name: 'テストマップ' },
            character: { name: 'テストキャラクター' },
            category: { name: 'テストカテゴリー' },
            user_id: 1,
            user: {
                id: 1,
                name: 'テストユーザー',
            },
        },
        userCategories: [],
        routeName: 'testRoute',
    };

    const isMobile = false;

    const wrapper = mount(ShowSpot, { propsData });

    it('スポットのタイトルと説明が正しく表示される', () => {
        console.log(wrapper.html());
        expect(wrapper.find('h1.font-bold.text-white.break-all').text()).toBe('テストタイトル');
        expect(wrapper.find('h3.text-white.my-4.break-all').text()).toBe('テスト説明');
    });

    it('スポットのタグが正しく表示される', () => {
        const tags = wrapper.findAll('v-chip');
        expect(tags.length).toBe(2);
        expect(tags[0].text()).toBe('テストタグ1');
        expect(tags[1].text()).toBe('テストタグ2');
    });

    it('画像の説明が正しく表示される', () => {
        const descriptions = wrapper.find('.img-description');
        const no_description = wrapper.find('.no-img-description');

        expect(descriptions.text()).toBe('画像説明1');
        expect(no_description.text()).toBe('説明なし');
    });
});

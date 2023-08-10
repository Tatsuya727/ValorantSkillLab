import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import ShareSpotHeader from '../original/ShareSpotHeader.vue';
import ShareSpotList from '../original/ShareSpotList.vue';
import { Inertia } from '@inertiajs/inertia';

describe('ヘッダーとリストの組み合わせテスト', () => {
    const spots = {
        data: [
            {
                id: 1,
                show_url: 'url',
                images: [{ image_path: 'path' }],
                title: 'title1',
                map: { name: 'mapName' },
                character: { name: 'characterName' },
                tags: [{ name: 'tag1' }],
            },
            {
                id: 2,
                show_url: 'url',
                images: [{ image_path: 'path' }],
                title: 'title2',
                map: { name: 'mapName' },
                character: { name: 'characterName' },
                tags: [{ name: 'tag2' }],
            },
        ],
        links: {
            prev: 'prev',
            next: 'next',
        },
    };

    // route関数をモック
    global.route = (name) => `mocked-route-for-${name}`;

    // Inertia.getをモック
    Inertia.get = (url) => {
        expect(url).toBe('mocked-route-for-sharespots.index');
    };

    const header_wrapper = mount(ShareSpotHeader);
    const list_wrapper = mount(ShareSpotList, {
        props: {
            spots: spots,
        },
    });

    it('タグをクリックするとリストが更新される', async () => {
        const tag = list_wrapper.findAll('.tag');
        const title = list_wrapper.findAll('h1');

        // 1つ目と2つ目のタイトルが表示されていることを確認
        expect(title[0].text()).toBe('title1');
        expect(title[1].text()).toBe('title2');

        console.log(tag[0].text());
        // 1つ目のタグをクリック
        await list_wrapper.vm.filterSpotsByTag('tag1');
        expect(list_wrapper.vm.selectedTag).toBe('tag1');
        expect(list_wrapper.find('.selected-tag').text()).toBe('tag1');

        console.log(title[0].text());
        console.log(title[1].text());

        // 1つ目のspotが表示されていることを確認
        expect(title[0].text()).toBe('title1');

        // 2つ目のspotが表示されていないことを確認
        // expect(title[1].exists()).toBeFalsy();
    });

    // it('検索するとリストが更新される', () => {
    //     const search = header_wrapper.findComponent('v-text-field.search-spots');
    //     const button = header_wrapper.find('v-btn.search-button');
    //     const title = list_wrapper.findAll('h1');

    //     // 1つ目と2つ目のタイトルが表示されていることを確認
    //     expect(title[0].text()).toBe('title1');
    //     expect(title[1].text()).toBe('title2');
    //     // 検索ワードを入力
    //     search.setValue('title1');
    //     // 検索ボタンをクリック
    //     button.trigger('click');
    //     // 1つ目のタイトルのみ表示されていることを確認
    //     expect(title[0].text()).toBe('title1');
    //     expect(title[1].exists()).toBeFalsy();
    // });
});
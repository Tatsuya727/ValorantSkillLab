import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import ShareSpotHeader from '../original/ShareSpotHeader.vue';

describe('ShareSpotHeader.vue', () => {
    const wrapper = mount(ShareSpotHeader);

    it('検索機能が表示される', () => {
        const search = wrapper.find('v-text-field.search-spots');

        expect(search.exists()).toBeTruthy();
    });

    it('検索ボタンが表示される', () => {
        const button = wrapper.find('v-btn.search-button');

        expect(button.exists()).toBeTruthy();
    });
});

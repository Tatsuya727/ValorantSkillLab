import { ref, onMounted, onUnmounted } from 'vue';

export function useMobileDetection() {
    const isMobile = ref(false);

    const updateIsMobile = () => {
        isMobile.value = window.innerWidth < 768;
    };

    onMounted(() => {
        window.addEventListener('resize', updateIsMobile);
        updateIsMobile();
    });

    onUnmounted(() => {
        window.removeEventListener('resize', updateIsMobile);
    });

    return {
        isMobile,
    };
}

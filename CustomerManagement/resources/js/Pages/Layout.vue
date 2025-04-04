<template>
    <div>
        <ExampleComponent />
        <slot />
    </div>
</template>
<script>
import ExampleComponent from './ExampleComponent.vue';
export default {
    name: 'Layout',
    components: {
        ExampleComponent,

    },

};
</script>

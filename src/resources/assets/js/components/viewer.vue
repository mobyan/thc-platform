<template>
    <div>
        <div id="mask">
            <div id="close-btn"></div>
            <div id="mask-content">
                <div id="mask-left"></div>
                <div id="mask-middle">                
                    <img :src="image.src">
                </div>
                <div id="mask-right"></div>
            </div>
        </div>
    </div>
</template>

<script >
    export default {
        props: ['images', 'index'],
        computed: {
            image: function () {
                return this.images[this.index] || {};
            }
        }
    }
</script>
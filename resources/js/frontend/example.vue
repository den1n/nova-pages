<template>
    <div class="nova-pages">
        <div class="nova-page" v-if="page">
            <div class="nova-page-title">{{ page.title }}</div>
            <div class="nova-page-content" v-html="page.content"></div>
            <div class="nova-page-footer">{{ page.published_at }}</div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data: () => ({
            page: {},
        }),

        async beforeRouteEnter(to, from, next) {
            let page = {};

            try {
                const { data } = await axios.get('/api/vendor/nova-pages/page/' + to.params.slug);

                page = data;
            } catch (e) {
                page = { title: 'Fetch Error' };

                switch (e.response.status) {
                    case 403: page.content = 'Forbidden'; break;
                    case 404: page.content = 'Not Found'; break;
                    default: page.content = 'Unknown Error';
                }
            } finally {
                next(vm => {
                    vm.page = page;
                });
            }
        },
    };
</script>

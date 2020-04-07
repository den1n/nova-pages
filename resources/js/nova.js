Nova.booting(Vue => {
    Vue.component('index-nova-pages-keywords-field', require('./fields/KeywordsIndexField'));
    Vue.component('detail-nova-pages-keywords-field', require('./fields/KeywordsDetailField'));
    Vue.component('form-nova-pages-keywords-field', require('./fields/KeywordsFormField'));
});

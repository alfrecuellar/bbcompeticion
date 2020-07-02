Vue.filter('date', function (value) {
    let datetime = moment(value);
    return value ? datetime.format('DD-MM-YYYY') : '';
});
Vue.filter('longdate', function (value) {
    let datetime = moment(value);
    return value ? datetime.format('DD MMMM YYYY') : '';
});
Vue.filter('amount', function (value) {
    return '$ ' + Math.round(value);
});
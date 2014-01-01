$(document).ready(function() {

    $('form[name=kassner_financesbundle_dashboard_category] select').change(function() {
        $(this).parents('form').get(0).submit();
    });

});
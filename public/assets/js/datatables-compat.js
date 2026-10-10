/* Preserve existing row actions and ordering during the upgrade. */
(function ($) {
    'use strict';
    $.extend(true, $.fn.dataTable.defaults, {
        deferRender: false,
        column: { orderSequence: ['asc', 'desc'] }
    });
}(jQuery));

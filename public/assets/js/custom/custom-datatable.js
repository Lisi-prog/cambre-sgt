/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./resources/assets/js/custom/custom-datatable.js ***!
  \********************************************************/


$.extend($.fn.dataTable.defaults, {
  'paging': true,
  'info': true,
  'ordering': true,
  'autoWidth': false,
  'pageLength': 10,
  'language': {
    'search': '',
    'sSearch': 'Search'
  },
  "preDrawCallback": function preDrawCallback() {
    customSearch();
  }
});
function customSearch() {
  $('.dt-search input').addClass("form-control");
  $('.dt-search input').attr("placeholder", "Search");
}
/******/ })()
;
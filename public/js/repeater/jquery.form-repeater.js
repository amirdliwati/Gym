/* Form Repeater */

$(document).ready(function () {
  'use strict';

  $('.repeater-default').repeater();

  $('.repeater-custom-show-hide').repeater({
    show: function () {
      $(this).slideDown();
    },
    hide: function (remove) {
      {
        $(this).slideUp(remove);
      }
    }
  });
});

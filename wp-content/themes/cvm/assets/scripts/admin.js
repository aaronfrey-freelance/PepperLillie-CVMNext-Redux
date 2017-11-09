(function($) {

  // Admin Options Validation
  $("#admin-options-form").validate({
    rules: {
      'cvm_theme_options[facebook_url]': {
        url: true
      },
      'cvm_theme_options[linkedin_url]': {
        url: true
      }
    }
  });

})(jQuery);

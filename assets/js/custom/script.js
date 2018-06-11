$(document).ready(function() {
	$('#captchaCode').on('validatecaptcha', function(event, isCorrect) {
	  if (isCorrect) {
		// UI Captcha validation passed
	  } else {
		// UI Captcha validation failed
	  }
	})
	var captcha = $('#botdetect-captcha').captcha({
      captchaEndpoint: '/botdetect-java-captcha-api-path-at-server-side/botdetectcaptcha'
    });
});
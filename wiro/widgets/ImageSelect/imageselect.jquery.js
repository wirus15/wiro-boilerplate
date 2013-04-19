(function($) {
    var supportsCreateURL = !!(window.URL || window.webkitURL);
    
    $.fn.ImageSelect = function(field, image, opts) {
	var options = $.extend({
	    maxSize: 2097152,
	    wrongTypeError: 'Selected file is not an image file.',
	    tooLargeError: 'Selected file is too large. Maximum file size is {maxSize} bytes.',
	    emptyImage: '',
	    errorField: field + ' + span.error'
	}, opts);
	
	var $field = $(field);
	var $image = $(image);
	var $fallbackField = $('<input type="text" />').insertAfter($image).hide();
	var $errorField = $(options.errorField).hide();
	
	this.click(function(e) {
	    e.preventDefault();
	    $field.trigger('click');
	});
	
	$field.change(function() {
	    $fallbackField.val($field.val());
	    var file = this.files && this.files[0];
	    if (file && validateFile(file)) {
		$errorField.hide();
		if(supportsCreateURL) {
		    var URL = window.URL || window.webkitURL;
		    $image.attr('src', URL.createObjectURL(file));
		} else {
		    $image.hide();
		    $fallbackField.show();
		}
	    }
	});

	function validateFile(file) {
	    if(!/image\/.*/.test(file.type)) {
		displayError(options.wrongTypeError);
		return false;
	    }
	    if(file.size > options.maxSize) {
		displayError(options.tooLargeError.replace('{maxSize}', options.maxSize));
		return false;
	    }	
	    return true;
	}
	
	function displayError(message) {
	    $image.attr('src', options.emptyImage);
	    $errorField.text(message).show();
	}
    };
})(jQuery);


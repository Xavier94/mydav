// IIFE - Immediately Invoked Function Expression
(function(window, document, $) {
	// Listen for the jQuery ready event on the document
	$(function() {

		function getName(personID) {
			var dynamicData = {};
			dynamicData["id"] = personID;
			return $.ajax({
				url: "getName.php",
				type: "get",
				data: dynamicData
			});
		}

		// Use promise
		getName("2342342").done(function (data) {
			// Updates the UI based the ajax result
			$(".person-name").text(data.name);
		});

	});
	// The rest of the code goes here!
}(window, document, window.jQuery));



/**
 * Don't Act on Absent Elements - Best: Add a doOnce plugin.
 * @param func
 * @returns {jQuery.fn}
 * @see https://learn.jquery.com/performance/dont-act-on-absent-elements/
 */
jQuery.fn.doOnce = function(func) {
	this.length && func.apply(this);
	return this;
};

/*
$(function(){
	$.ajax({
				url: form_alerte.data('url'),
				type: form_alerte.attr('method'),
				data: form_alerte.serialize(),
				dataType: 'json',
				timeout: 10000,
				creation_annonce: false,
				success: function(json) {
					//console.log(json);
					if (json.reponse === 'ko') {
						div_msg_erreurs.find('.togglable').each(function () {
							$(this).toggle(!($.inArray($(this).data('erreur'), json.erreurs)));
							if ($(this).data('erreur') == 'max-annonce' && !($.inArray('max-annonce', json.erreurs))) {
								_gaq.push($(this).data('gaq').split(','));
							}
						});
					}
					this.creation_annonce = json.creation;
				},
				error: function(flux, status) {
					div_loading.hide();
					submit_button.show();
					form_alerte.submit();
				},
				complete: function(flux, status) {
					if (status === 'success' && this.creation_annonce === true) {
						form_alerte.submit();
					}
					div_loading.hide();
					submit_button.show();
				}
			});
			e.preventDefault();
			return false;
})
*/

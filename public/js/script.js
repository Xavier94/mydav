/**
 * IIFE - Immediately Invoked Function Expression
 */
;(function(window, document, $) {
	/**
	 * Listen for the jQuery ready event on the document
	 */
	$(function() {

		$('#dir-create').doOnce(dirCreate.init);

		$('.alert').doOnce(alert.init);

	});

	/**
	 * The rest of the code goes here!
	 */

	var dirCreate = {
		init: function(settings) {
			dirCreate.config = {
				form: $('#form-dir-create'),
				inputDirName: $('#form-dir-create-name'),
				groupFile: $('#list-filesystem'),
				button: $('#dir-create')
			};
			// Allow overriding the default config
			$.extend(dirCreate.config, settings);
			dirCreate.setup();
		},
		setup: function() {
			dirCreate.config.button.on('click', function(e) {
				e.preventDefault();
				dirCreate.showForm();
				dirCreate.config.form.on('click', '#form-dir-create-submit', dirCreate.submitAction);
			});
			dirCreate.config.form.on('click', 'a', function(e) {
				e.preventDefault();
				dirCreate.hideForm();
			});
		},
		submitAction: function(e) {
			e.preventDefault();
			var promise = dirCreate.sendAction();
			promise.done(function(data) { // Use promise
				// Updates the UI based the ajax result
				console.log(data);
				if (data.status) {
					dirCreate.hideForm();
				}
				else {
					dirCreate.config.form.find('.error').html('ERROR: not create !');
				}
			});
			promise.fail(function(data) {
				dirCreate.config.form.find('.error').html('ERROR: not create !');
			});
		},
		sendAction: function() {
			return $.post(dirCreate.config.form.attr('action'), dirCreate.config.form.serialize());
		},
		showForm: function() {
			dirCreate.config.form.show();
		},
		hideForm: function() {
			dirCreate.config.form.hide();
			dirCreate.config.inputDirName.val('');
			dirCreate.config.form.find('.error').html('');
		}
	};

	var alert = {
		init: function() {
			alert.config = {
				box: $('.alert')
			};
			alert.setup();
		},
		setup: function() {
			alert.config.box.on('click', 'a', function(e) {
				e.preventDefault();
				$(this).parent().hide(200);
			});
		}
	};

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

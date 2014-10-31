var SAC = new function() {
	var changeAttending = function(theEventId, theAction) {
		$('#panel-event-' + theEventId).html('<i class="fa fa-circle-o-notch fa-spin"></i>');

		$.ajax({
		  type: 'POST',
		  url: 'ajax-attending.php',
		  data: {'event': theEventId, 'action' : theAction }
		})
		.done(function( msg ) {
			$('#panel-event-' + theEventId).html(msg);
			SAC.loadPaymentInfo('payment-panel');
		})
		.fail(function(jqXHR, textStatus) {
			$('#panel-event-' + theEventId).html('<strong>Oops!</strong> Algum erro aconteceu. Tente novamente.');
		});
	};
	
	this.subscribe = function(theEventId, theConfirm) {
		if(!theConfirm || confirm('Essa atividade possui vagas limitadas, então inscreva-se apenas se você realmente conseguirá participar!')) {
			changeAttending(theEventId, 'subscribe');
		}
	};
	
	this.unsubscribe = function(theEventId) {
		changeAttending(theEventId, 'unsubscribe');
	};
	
	this.loadPaymentInfo = function(theContainerId) {
		$('#' + theContainerId).html('<i class="fa fa-circle-o-notch fa-spin"></i> Carregando informações sobre pagamentos...');

		$.ajax({
		  type: 'POST',
		  url: 'ajax-payments.php'
		})
		.done(function( msg ) {
			$('#' + theContainerId).fadeOut(function() {
				$(this).html(msg).fadeIn();
			});
		})
		.fail(function(jqXHR, textStatus) {
			$('#' + theContainerId).html('<strong>Oops!</strong> Algum erro aconteceu. Tente novamente.');
		});
	};
	
	this.registrationToggleFields = function() {
		var aIsUFFS = $('#uffs').val() == 1;

		if(aIsUFFS) {
			$('.uffs').slideDown();
			$('.nao-uffs').slideUp();
		} else {
			$('.uffs').slideUp();
			$('.nao-uffs').slideDown();
		}
	};
};
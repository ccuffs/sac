var SAC = new function() {
	var changeAttending = function(theEventId, theAction) {
		$('#panel-event-' + theEventId).html('<i class="fa fa-circle-o-notch fa-spin"></i>');

		$.ajax({
		  type: 'POST',
		  url: 'api/attending-event/update-subscription',
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
	
	this.deleteEvent = function(theEventId) {
		if(confirm('Deseja mesmo apagar esse evento?')) {
			document.location = 'event-manager.php?delete=' + theEventId;
		}
	};
	
	this.createTeam = function(theCompetitionId) {
		if(confirm('Seu time será mostrado na lista de times participantes do campeonato. Continuar?')) {
			document.location = 'competition.php?competition='+theCompetitionId+'&register=true';
		}
	};
	
	this.deletePayment = function(theId) {
		if(confirm('Deseja mesmo apagar esse pagamento?')) {
			document.location = 'payment-manager.php?delete=' + theId;
		}
	}
	
	this.loadPaymentInfo = function(theContainerId) {
		$('#' + theContainerId).html('<i class="fa fa-circle-o-notch fa-spin"></i> Carregando informações sobre pagamentos...');

		$.ajax({
		  url: 'api/payment/'
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

	this.userPermission = function() {
		const USER_LEVEL_EXTERNAL = 1;
		const USER_LEVEL_UFFS = 2;
		const CO_ORGANIZER = 3;
		const USER_LEVEL_ADMIN = 4;
		const colorClasses = ['bg-danger', 'bg-warning', 'bg-success', 'bg-info']
		/*$(".edit").click(function(e) {
			let target = e.currentTarget;
			let selectInput = target.nextElementSibling.nextElementSibling.children[0];

			$(selectInput).css('display', 'block');
			// console.log(e);
		});*/

		function removeColorClass(colorClass, card){
			colorClasses.forEach(color => {
				if (colorClass.match(color))
					$(card).removeClass(color);
			});
		}

		$("#permission").change(function(e){
			let card = e.currentTarget.offsetParent.lastElementChild;
			let permission = $(this).val();
			let userId = $(e.currentTarget.offsetParent.children[0].children[0]).val();
			
			let colorClass = $(card).attr('class');
			removeColorClass(colorClass, card);
			$(card).addClass(colorClasses[permission - 1]);

			$.ajax({
				type: 'POST',
				url : 'http://localhost/sac/admin/permissoes/'+userId,
				data: {
					'type' : permission
				},
			})
			.done(function(data){
				console.log(data);
			})
			.fail(function(data){
				console.log(data);
			});

		});
		
	}
};
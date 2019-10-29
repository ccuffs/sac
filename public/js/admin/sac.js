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
		const colorClasses = ['bg-danger', 'bg-warning', 'bg-success', 'bg-info']

		function removeColorClass(colorClass, card){
			colorClasses.forEach(color => {
				if (colorClass.match(color))
					$(card).removeClass(color);
			});
		}

		$(".permission").change(function(e){

			let card = e.currentTarget.offsetParent.lastElementChild;
			let permission = $(this).val();
			let userId = $(e.currentTarget.offsetParent.children[0].children[0]).val();

			$.ajax({
				type: 'POST',
				url : BASE_URL + '/admin/permissoes/'+userId,
				data: {
					'type' : permission
				},
				success : function(data, textStatus, request) {
					let colorClass = $(card).attr('class');
					removeColorClass(colorClass, card);
					$(card).addClass(colorClasses[permission - 1]);
					toastr.success(request.getResponseHeader('message'), {timeOut : 30, extendedTimeOut : 60});
				},
				error : function(request, textStatus, errorThrown) {
					toastr.error(request.getResponseHeader('message'), {timeOut : 30, extendedTimeOut : 60});
				}
			});
		});
	}

	this.addMasks = function(){
		$("input[name=amount], input[name=price]").maskMoney({
			prefix:'R$ ',
			allowNegative: false,
			thousands:'.',
			decimal:',',
			affixesStay: false,
			allowZero: true
		});
		$("input[name=cpf]").mask('000.000.000-00');
	}

	window.onload = function() {

		let tableRow = document.querySelectorAll("tr");

		let pageUrl = document.URL;

		let correctView = pageUrl.includes('pagamento') || pageUrl.includes('perfil');

		if (correctView && tableRow.length != 1){

			for(let i=1; i < tableRow.length; i++) {
				let cpf = tableRow[i].children[2].innerHTML;

				if (cpf.length == 10)
					cpf = '0' + cpf;

				tableRow[i].children[2].innerHTML = cpf.substr(0,3) +'.' +cpf.substr(3, 3) + '.' + cpf.substr(6, 3) + '-' + cpf.substr(9,8);
			}

		}

	}
};

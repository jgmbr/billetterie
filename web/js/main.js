$(document).ready(function(){

	$('#booking_date_booking').datepicker({
		monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
		monthNamesShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
		dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
		dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
		dayNamesMin: ['Di', 'Lu', 'Mar', 'Me', 'Je', 'Ve', 'Sa'],
		weekHeader: 'Sm',
		firstDay: 1,
		dateFormat: 'yy-mm-dd',
		minDate: 0,
		beforeShowDay: function (date) {
			return [!(date.getDay() == 0 ||
			date.getDay() == 2 ||
			(date.getMonth() == 0 && date.getDate() == 1) ||
			(date.getMonth() == 4 && date.getDate() == 1) ||
			(date.getMonth() == 4 && date.getDate() == 8) ||
			(date.getMonth() == 6 && date.getDate() == 14) ||
			(date.getMonth() == 7 && date.getDate() == 15) ||
			(date.getMonth() == 10 && date.getDate() == 1) ||
			(date.getMonth() == 10 && date.getDate() == 11) ||
			(date.getMonth() == 11 && date.getDate() == 25))];
		},
		onSelect: function (date) {
			
		}
	});
			
	$( ".datepicker" ).datepicker({
			monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			monthNamesShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
			dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
			dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
			dayNamesMin: ['Di', 'Lu', 'Mar', 'Me', 'Je', 'Ve', 'Sa'],
			weekHeader: 'Sm',
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: "-100:+0" 
	});

	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollToTop').fadeIn();
		} else {
			$('.scrollToTop').fadeOut();
		}
	});

	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},500);
		return false;
	});

	$('#ChangeToggle').click(function() {
		$('#navbar-hamburger').toggleClass('hidden');
		$('#navbar-close').toggleClass('hidden');
	});

});
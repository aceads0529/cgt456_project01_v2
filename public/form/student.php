<?php include '.\..\header.php';
require_login(); ?>

<div class="ribbon">
	<img src="http://104.248.58.191/456/assign1/form/images/Ribbon-Final-01.png">
</div>
	
<ul id="progressbar">
    <li id= "0" class="active">Employer</li>
    <li id= "1">Work Session</li>
	<li id= "2">Questionnaire</li>
</ul>


<form id="form-student"></form>
<script src="../scripts/form-student.js"></script>

<script type="text/javascript">

$(document).ready(function () {

    $('.next').click(function () {
       $('.current').removeClass('current').hide().next().show().addClass('current');
       $('#progressbar li.active').next().addClass('active');

       if ($('#progress')) {};

    });

    $('.previous').click(function () {
        $('.current').removeClass('current').hide().prev().show().addClass('current');
        $('#progressbar li.active').removeClass('active').prev().addClass('active');
    });
 });
	
	function progressbar() {
	
	if (forms.value() = 0) {
		$('#0').attr('class', 'active');
		$('#1').attr('class', '');
		$('#2').attr('class', '');
	}
	else if (1) {
		.next 
		$('#0').attr('class', 'active');
		$('#1').attr('class', 'active');
		$('#2').attr('class', '');
	}
	else if (2)	{
		$('#0').attr('class', 'active');
		$('#1').attr('class', 'active');
		$('#2').attr('class', 'active');
	};
}
	
	
	


<?php include '.\..\footer.php'; ?>


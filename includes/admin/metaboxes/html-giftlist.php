<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	<?php 
		// output_form_input_text(array(
		// 	'name'=>'event_date',
		// 	'type'=>'text',
		// 	'class'=>'',
		// 	'value'=>  $giftlist? $giftlist->date : '',
		// 	'required'=>true,
		// 	'description'=>'Autor'
		// ));
	?>



	<?= 
		output_form_input_text(array(
			'name'=>'event_date',
			'type'=>'date',
			'class'=>'datepicker',
			'value'=>  $giftlist? $giftlist->date : '',
			'required'=>true,
			'description'=>'Data do evento'
		));
	?>

<?= 
		output_form_input_text(array(
			'name'=>'event_location',
			'type'=>'text',
			'class'=>'',
			'value'=>  $giftlist? $giftlist->location : '',
			'required'=>true,
			'description'=>'Localização'
		));
	?>

<?= 
		output_form_input_text(array(
			'name'=>'event_message',
			'type'=>'textarea',
			'class'=>'',
			'value'=>  $giftlist? $giftlist->message : '',
			'required'=>true,
			'description'=>'Mensagem'
		));
	?>



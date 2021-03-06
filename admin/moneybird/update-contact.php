<?php

function update_moneybird_contact($post_id, $moneybird_id){
	
	$domein = get_option('moneybird_domain');
	$email = get_option('moneybird_email');
	$pass = get_option('moneybird_pass');
	$key = get_option('moneybird_key');
	
	if($domein != '' && $email != '' && $pass != '' && $key != '') :
	
	$check = create_moneybird_settings($domain,$email,$pass,$key);
	
		if($check != 'error1' || $check != 'error2' || $check != 'error3') : 
			require_once("api/Api.php");
			$meta = get_post_custom($post_id->ID);
			$mbapi = new MoneybirdApi($domein, $email, $pass);
			$contact = $mbapi->getContact($moneybird_id);
			$contact->company_name = ''.$meta['bedrijf'][0].'';
			$contact->firstname = ''.$meta['voornaam'][0].'';
			$contact->lastname = ''.$meta['achternaam'][0].'';
			$contact->address1 = ''.$meta['adres'][0].'';
			$contact->zipcode = ''.$meta['postcode'][0].'';
			$contact->city = ''.$meta['plaats'][0].'';
			$contact->country = 'Nederland';
			$contact->email = ''.$meta['email'][0].'';
			$contact->phone = ''.$meta['telefoon'][0].'';
			$contact = $mbapi->saveContact($contact);
			$contact->save();
			
		endif;
	
	endif;

}

?>
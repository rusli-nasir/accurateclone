<?php
/*
 *buat helper dengan nama kirim_sms_helper
 *kirim_sms_helper.php
 *simpan kirim_sms_helper.php di /application/helper
 *Author : Anton (Jhe)
 * terimakasih

*/
function __construct()
{ }
function kirim_sms($nohp, $message, $return = '0')
{
	$CI = &get_instance();
	$CI->load->database();
	$CI->db->select('*');
	$CI->db->from('api');
	$query = $CI->db->get();
	$data = $query->result_array();
	foreach ($data as $info) {

		$userkey = $info['userkey'];
		$passkey = $info['passkey'];
	}
	$smsgatewayurl = 'https://reguler.zenziva.net/';
	$userkey = $info['userkey'];
	$passkey = $info['passkey'];
	$message = urlencode($message);
	$elementapi = '/apps/smsapi.php';
	$parameterapi = $elementapi . '?userkey=' . $userkey . '&passkey=' . $passkey . '&nohp=' . $nohp . '&pesan=' . $message;
	$smsgatewaydata = $smsgatewayurl . $parameterapi;
	$url = $smsgatewaydata;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	if (!$output) {
		$output = file_get_contents($smsgatewaydata);
	}
	if ($return == '1') {
		return $output;
	} else {
		echo "Berhasil Dikirimm";
	}
}

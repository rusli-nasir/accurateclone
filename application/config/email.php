<?php defined('BASEPATH') or exit('No direct script access allowed');

$config = array(
  'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
  'smtp_host' => 'mail.rocketjaket.com',
  'smtp_port' => 465,
  'smtp_user' => 'info@rocketjaket.com',
  'smtp_pass' => 'Rocket00!',
  'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
  'mailtype' => 'html', //plaintext 'text' mails or 'html'
  'smtp_timeout' => '4', //in seconds
  'charset' => 'utf-8',
  'wordwrap' => TRUE
);

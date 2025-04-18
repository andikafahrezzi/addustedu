<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'ssl://smtp.gmail.com';
$config['smtp_port']   = 465;
$config['smtp_user']   = $_ENV['mail_user'];     // GANTI: Email kamu
$config['smtp_pass']   = $_ENV['mail_keyapps']; // GANTI: Password dari langkah 1
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['wordwrap']    = TRUE;

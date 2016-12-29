$facebook = new Facebook();
$userProfile = $facebook->GetSession();

// User profile vai conter os dados do usuário:
// [id] => 4903490234934
// [email] => email@email.com
// [first_name] => Nome
// [gender] => male
// [last_name] => Sobrenome
// [link] => https://...
// [locale] => en_US
// [middle_name] => Nome do Meio
// [name] => Nome Sobrenome
// [timezone] => -3
// [updated_time] => 2015-06-06T03:29:08+0000
// [verified] => 1
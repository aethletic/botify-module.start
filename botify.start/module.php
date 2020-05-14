<?php

/**
 * @package Оповещения о новых пользователях.
 * @version 1.0.0
 * @author  Botify <hello@botify.ru>
 * @link    https://botify.ru
 */

if (stripos($bot->message, '/start') === false)
    return;

if ($bot->config['db.driver'] && !$bot->user->isNewUser)
    return;

if (!is_numeric($chat_id) && stripos($chat_id, '@') == false)
    $chat_id = "@{$chat_id}";

[$cmd, $from] = $bot->parse();
$from = $from ?? 'Неизвестно';

$chat_id = $bot->config['botify.start']['chat_id'];
$bot_name = $bot->config['botify.start']['bot_name'];

$username = $bot->username;
$user_id = $bot->user_id;
$full_name = $bot->full_name;
$user_link = $username ? "[{$full_name}](tg://user?id={$user_id})" : "{$full_name}";

$msg  = "*Новый пользователь: * $user_link\n";
$msg .= "*Откуда:* `{$from}`\n";
$msg .= "*Бот:* @{$bot_name}\n";

if ($bot->config['db.driver']) {
    $count_all = $bot->db->table('users')->count();
    $msg .= "*Всего пользователей:* `{$count_all}`\n";
}

$msg .= "#{$bot_name} #{$from}";

$bot->sendMessage($chat_id, $msg);

<?php
/**
 * XSS対策
 * @param str フォームで入力されたデータ
 * @return str XSS対策されたデータ
 */
function h($form_data)
{
    return htmlspecialchars($form_data, ENT_QUOTES);
}

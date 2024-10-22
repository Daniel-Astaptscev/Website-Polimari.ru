<?php
// Токен
const TOKEN = '<secret-key>';

// ID чата
const CHATID = '<secret-key>';

// Проверяем была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
 
    // Создаем POST запрос
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '<secret-key>';
    $recaptcha_response = $_POST['recaptcha_response'];
 
    // Отправляем POST запрос и декодируем результаты ответа
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
 
    // Принимаем меры в зависимости от полученного результата 0.3 или 0.5 легитимный пользователь
    if ($recaptcha->score >= 0.5) {
        // Проверка пройдена - отправляем сообщение.
        
        // Проверяем не пусты ли поля с именем и телефоном
        if (!empty($_POST['FirstName']) && !empty($_POST['Phone'])) {
            // Если не пустые, то валидируем эти поля и сохраняем и добавляем в тело сообщения. Минимально для теста так:
            $txt = "";
            // Не забываем про заголовок
            if (isset($_POST['theme']) && !empty($_POST['theme'])) {
                $name0 = "Мариночка, ";
                $Name0 = "<b>".$name0."</b> ";
                $txt .= $Name0 . strip_tags(urlencode($_POST['theme'])) . "%0A %0A";
            }
            // Имя
            if (isset($_POST['FirstName']) && !empty($_POST['FirstName'])) {
                $name1 = 'Имя: ';
                $FirstName = "<b>".$name1."</b> ";
                $txt .= $FirstName . strip_tags(trim(urlencode($_POST['FirstName']))) . "%0A";
            }
            // Номер телефона
            if (isset($_POST['Phone']) && !empty($_POST['Phone'])) {
                $phone = 'Контактный телефон: ';
                $Phone = "<b>".$phone."</b> ";
                $txt .= $Phone . strip_tags(trim(urlencode($_POST['Phone']))) . "%0A";
            }
            $textSendStatus = @file_get_contents('https://api.telegram.org/bot'. TOKEN .'/sendMessage?chat_id=' . CHATID . '&parse_mode=html&text=' . $txt); 
              header("location: ../../order.html");
            }
        }   
    else {
        // Проверка не пройдена. Показываем ошибку.
        header("location: ../../error.html");
    }
}
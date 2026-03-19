<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

// Подключение к БД
$user = 'u82277';
$pass = '1452026';
$db = new PDO('mysql:host=localhost;dbname=u82277', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// Функция для генерации логина и пароля
function generateCredentials() {
    $login = 'user_' . bin2hex(random_bytes(4)); // например: user_1a2b3c4d
    $password = bin2hex(random_bytes(8)); // например: 5e6f7a8b9c0d1e2f
    return ['login' => $login, 'password' => $password];
}

// Функция для сохранения данных в Cookies на год
function saveToCookies($data) {
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $value = implode(',', $value);
        }
        setcookie("saved_$key", $value, time() + 365*24*60*60, '/');
    }
}

// Функция для загрузки сохраненных данных из Cookies
function loadFromCookies() {
    $data = [];
    foreach ($_COOKIE as $key => $value) {
        if (strpos($key, 'saved_') === 0) {
            $field = substr($key, 6);
            if ($field === 'languages' && strpos($value, ',') !== false) {
                $data[$field] = explode(',', $value);
            } else {
                $data[$field] = $value;
            }
        }
    }
    return $data;
}

// Функция валидации с регулярными выражениями
function validateForm($data) {
    $errors = [];
    
    // 1. ФИО
    if (empty($data['full_name'])) {
        $errors['full_name'] = 'ФИО обязательно для заполнения';
    } elseif (!preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]+$/u', $data['full_name'])) {
        $errors['full_name'] = 'ФИО может содержать только буквы, пробелы и дефисы';
    } elseif (strlen($data['full_name']) > 150) {
        $errors['full_name'] = 'ФИО не должно превышать 150 символов';
    }
    
    // 2. Телефон
    if (empty($data['phone'])) {
        $errors['phone'] = 'Телефон обязателен для заполнения';
    } elseif (!preg_match('/^[\+\d\s\-\(\)]{6,20}$/', $data['phone'])) {
        $errors['phone'] = 'Телефон может содержать только цифры, пробелы, дефисы, скобки и + (6-20 символов)';
    }
    
    // 3. Email
    if (empty($data['email'])) {
        $errors['email'] = 'Email обязателен для заполнения';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Некорректный формат email (пример: name@domain.com)';
    }
    
    // 4. Дата рождения
    if (empty($data['birth_date'])) {
        $errors['birth_date'] = 'Дата рождения обязательна для заполнения';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['birth_date'])) {
        $errors['birth_date'] = 'Дата должна быть в формате ГГГГ-ММ-ДД';
    } else {
        $date = DateTime::createFromFormat('Y-m-d', $data['birth_date']);
        if (!$date) {
            $errors['birth_date'] = 'Некорректная дата';
        } elseif ($date > new DateTime()) {
            $errors['birth_date'] = 'Дата рождения не может быть в будущем';
        }
    }
    
    // 5. Пол
    if (empty($data['gender'])) {
        $errors['gender'] = 'Выберите пол';
    } elseif (!in_array($data['gender'], ['male', 'female'])) {
        $errors['gender'] = 'Некорректное значение пола';
    }
    
    // 6. Языки
    if (empty($data['languages']) || !is_array($data['languages'])) {
        $errors['languages'] = 'Выберите хотя бы один язык программирования';
    } else {
        foreach ($data['languages'] as $lang_id) {
            if (!preg_match('/^[1-9]$|^1[0-2]$/', $lang_id)) {
                $errors['languages'] = 'Выбран недопустимый язык программирования';
                break;
            }
        }
    }
    
    // 7. Биография
    if (empty($data['biography'])) {
        $errors['biography'] = 'Биография обязательна для заполнения';
    } elseif (strlen($data['biography']) > 5000) {
        $errors['biography'] = 'Биография не должна превышать 5000 символов';
    }
    
    // 8. Чекбокс
    if (!isset($data['contract_accepted'])) {
        $errors['contract_accepted'] = 'Необходимо подтвердить ознакомление с контрактом';
    }
    
    return $errors;
}

// Обработка выхода
if (isset($_GET['logout'])) {
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header('Location: index.php');
    exit();
}

// Обработка входа
if (isset($_POST['login_submit'])) {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $db->prepare("SELECT * FROM applications WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_login'] = $user['login'];
        header('Location: index.php');
        exit();
    } else {
        $login_error = 'Неверный логин или пароль';
    }
}

// GET запрос - показываем форму
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Если есть параметр save - успех
    if (!empty($_GET['save'])) {
        $success_message = 'Спасибо, результаты сохранены.';
    }
    
    // Если пользователь авторизован - загружаем его данные из БД
    $user_data = [];
    if (isset($_SESSION['user_id'])) {
        $stmt = $db->prepare("SELECT * FROM applications WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user_data = $stmt->fetch();
        
        // Загружаем языки пользователя
        $stmt = $db->prepare("SELECT language_id FROM application_languages WHERE application_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $langs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if ($langs) {
            $user_data['languages'] = $langs;
        }
    }
    
    // Загружаем сохраненные данные из Cookies (для неавторизованных)
    $saved_data = loadFromCookies();
    
    // Если авторизован, данные из БД приоритетнее cookies
    if (isset($_SESSION['user_id']) && !empty($user_data)) {
        $saved_data = $user_data;
    }
    
    // Загружаем ошибки из Cookies (если есть)
    $errors = [];
    if (isset($_COOKIE['form_errors'])) {
        $errors = json_decode($_COOKIE['form_errors'], true);
        setcookie('form_errors', '', time() - 3600, '/');
    }
    
    // Загружаем старые данные из Cookies (если есть ошибки)
    $old_data = [];
    if (isset($_COOKIE['old_data'])) {
        $old_data = json_decode($_COOKIE['old_data'], true);
        setcookie('old_data', '', time() - 3600, '/');
    }
    
    include 'form.php';
    exit();
}

// POST запрос - проверяем и сохраняем
$errors = validateForm($_POST);

if (!empty($errors)) {
    // Сохраняем ошибки в Cookies (на время сессии)
    setcookie('form_errors', json_encode($errors), 0, '/');
    setcookie('old_data', json_encode($_POST), 0, '/');
    header('Location: index.php');
    exit();
}

// Если ошибок нет - сохраняем в БД
try {
    $db->beginTransaction();
    
    // Генерируем логин и пароль для новой записи
    $credentials = generateCredentials();
    $login = $credentials['login'];
    $password_hash = password_hash($credentials['password'], PASSWORD_DEFAULT);
    
    // Определяем ID записи (если редактирование)
    $application_id = null;
    
    if (isset($_SESSION['user_id'])) {
        // Редактирование существующей записи
        $application_id = $_SESSION['user_id'];
        
        // Обновляем данные
        $stmt = $db->prepare("
            UPDATE applications 
            SET full_name = ?, phone = ?, email = ?, birth_date = ?, 
                gender = ?, biography = ?, contract_accepted = ?
            WHERE id = ?
        ");
        
        $contract = isset($_POST['contract_accepted']) ? 1 : 0;
        
        $stmt->execute([
            $_POST['full_name'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['birth_date'],
            $_POST['gender'],
            $_POST['biography'],
            $contract,
            $application_id
        ]);
        
        // Удаляем старые языки
        $stmt = $db->prepare("DELETE FROM application_languages WHERE application_id = ?");
        $stmt->execute([$application_id]);
        
    } else {
        // Новая запись
        $stmt = $db->prepare("
            INSERT INTO applications 
            (full_name, phone, email, birth_date, gender, biography, contract_accepted, login, password_hash) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $contract = isset($_POST['contract_accepted']) ? 1 : 0;
        
        $stmt->execute([
            $_POST['full_name'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['birth_date'],
            $_POST['gender'],
            $_POST['biography'],
            $contract,
            $login,
            $password_hash
        ]);
        
        $application_id = $db->lastInsertId();
        
        // Сохраняем логин и пароль в сессию для показа один раз
        $_SESSION['new_credentials'] = [
            'login' => $login,
            'password' => $credentials['password']
        ];
    }
    
    // Вставляем языки
    if (!empty($_POST['languages'])) {
        $stmt = $db->prepare("
            INSERT INTO application_languages (application_id, language_id) 
            VALUES (?, ?)
        ");
        
        foreach ($_POST['languages'] as $lang_id) {
            $stmt->execute([$application_id, $lang_id]);
        }
    }
    
    $db->commit();
    
    // Сохраняем данные в Cookies на год (для неавторизованных)
    if (!isset($_SESSION['user_id'])) {
        saveToCookies($_POST);
    }
    
    // Успех - редирект с параметром save
    header('Location: index.php?save=1');
    exit();
    
} catch(PDOException $e) {
    $db->rollBack();
    setcookie('form_errors', json_encode(['db' => 'Ошибка базы данных: ' . $e->getMessage()]), 0, '/');
    setcookie('old_data', json_encode($_POST), 0, '/');
    header('Location: index.php');
    exit();
}
?>

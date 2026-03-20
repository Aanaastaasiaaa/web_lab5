<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анкета программиста</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background: linear-gradient(145deg, #fbbf24 0%, #f59e0b 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }
        
        .container {
            max-width: 820px;
            margin: 0 auto;
            background: #fff9e6;
            border-radius: 20px;
            border: 1px solid #fde68a;
            overflow: hidden;
        }
        
        .header {
            background: #fffbeb;
            padding: 35px 30px;
            text-align: center;
            border-bottom: 2px solid #fcd34d;
            position: relative;
        }
        
        .header h1 {
            color: #92400e;
            font-size: 2.2em;
            margin-bottom: 8px;
        }
        
        .header p {
            color: #b45309;
            font-size: 1.1em;
        }
        
        .auth-section {
            position: absolute;
            top: 20px;
            right: 30px;
        }
        
        .auth-button {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9em;
            text-decoration: none;
        }
        
        .auth-button:hover {
            background: #d97706;
        }
        
        .auth-form {
            background: #fefce8;
            border: 2px solid #fde68a;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .auth-form h3 {
            color: #92400e;
            margin-bottom: 15px;
        }
        
        .auth-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid #fde68a;
            border-radius: 8px;
            background: white;
        }
        
        .auth-form .auth-buttons {
            display: flex;
            gap: 10px;
        }
        
        .auth-form button {
            flex: 1;
            padding: 10px;
            background: #f59e0b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        
        .auth-form button:hover {
            background: #d97706;
        }
        
        .auth-form .logout-btn {
            background: #6b7280;
        }
        
        .auth-form .logout-btn:hover {
            background: #4b5563;
        }
        
        /* ИСПРАВЛЕННЫЙ БЛОК ДЛЯ ЛОГИНА И ПАРОЛЯ */
        .credentials-message {
            background: #f0fdf4;
            color: #166534;
            padding: 25px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: 2px solid #86efac;
            text-align: center;
        }
        
        .credentials-message h3 {
            margin-bottom: 20px;
            font-size: 1.3em;
            color: #166534;
        }
        
        .credentials-box {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .credential-item {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            border: 2px solid #86efac;
            min-width: 200px;
        }
        
        .credential-item strong {
            display: block;
            color: #166534;
            margin-bottom: 8px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .credential-value {
            font-size: 1.3em;
            font-family: monospace;
            background: #f0fdf4;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px dashed #86efac;
            word-break: break-all;
        }
        
        .credentials-warning {
            font-size: 0.9em;
            color: #166534;
            background: #dcfce7;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #86efac;
            margin-top: 10px;
        }
        
        .credentials-warning::before {
            content: "⚠️ ";
            font-size: 1.1em;
        }
        
        .form-content {
            padding: 35px;
            background: white;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group.has-error label {
            color: #dc2626;
        }
        
        .form-group.has-error input,
        .form-group.has-error textarea,
        .form-group.has-error select {
            border-color: #dc2626;
            background: #fef2f2;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #92400e;
            font-weight: 600;
        }
        
        .required::after {
            content: " *";
            color: #dc2626;
        }
        
        .error-message {
            color: #dc2626;
            font-size: 0.85em;
            margin-top: 5px;
            padding: 5px 10px;
            background: #fef2f2;
            border-radius: 6px;
            border-left: 3px solid #dc2626;
        }
        
        .global-error {
            background: #fef2f2;
            color: #991b1b;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: 2px solid #fca5a5;
        }
        
        .global-error ul {
            margin-left: 20px;
            margin-top: 10px;
        }
        
        .success-message {
            background: #f0fdf4;
            color: #166534;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: 2px solid #86efac;
            text-align: center;
        }
        
        .success-message a {
            color: #166534;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 2px solid #86efac;
        }
        
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #fde68a;
            border-radius: 12px;
            font-size: 1em;
            transition: border-color 0.2s;
            background: #fefce8;
        }
        
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #f59e0b;
            background: white;
        }
        
        .radio-group {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            background: #fefce8;
            padding: 15px 20px;
            border-radius: 12px;
            border: 2px solid #fde68a;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
        }
        
        .radio-option input[type="radio"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            accent-color: #f59e0b;
        }
        
        .radio-option label {
            margin-bottom: 0;
            font-weight: 500;
            color: #92400e;
        }
        
        select[multiple] {
            height: 200px;
            padding: 10px;
        }
        
        select[multiple] option {
            padding: 8px 12px;
        }
        
        select[multiple] option:checked {
            background: #fbbf24;
            color: #92400e;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            background: #fefce8;
            padding: 15px 20px;
            border-radius: 12px;
            border: 2px solid #fde68a;
        }
        
        .checkbox-group input[type="checkbox"] {
            margin-right: 12px;
            width: 20px;
            height: 20px;
            accent-color: #f59e0b;
        }
        
        .checkbox-group label {
            margin-bottom: 0;
            font-weight: 500;
            color: #92400e;
            flex: 1;
        }
        
        .hint {
            font-size: 0.85em;
            color: #b45309;
            margin-top: 5px;
        }
        
        button[type="submit"] {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 16px 32px;
            font-size: 1.2em;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s;
        }
        
        button[type="submit"]:hover {
            background: #d97706;
        }
        
        .edit-note {
            text-align: center;
            margin-top: 15px;
            color: #92400e;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .form-content { padding: 20px; }
            .header h1 { font-size: 1.8em; }
            .radio-group { flex-direction: column; }
            .auth-section { position: static; margin-top: 15px; }
            .credentials-box { flex-direction: column; align-items: center; }
            .credential-item { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Анкета </h1>
            <p><?= isset($_SESSION['user_id']) ? 'Редактирование анкеты' : 'Заполните форму ' ?></p>
            
            <div class="auth-section">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="#login" class="auth-button" onclick="toggleLoginForm()">Войти</a>
                <?php else: ?>
                    <a href="?logout=1" class="auth-button">Выйти (<?= htmlspecialchars($_SESSION['user_login']) ?>)</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-content">
            <!-- Форма входа (скрыта по умолчанию) -->
            <div id="login-form" class="auth-form" style="display: none;">
                <h3>Вход в личный кабинет</h3>
                <form method="POST">
                    <input type="text" name="login" placeholder="Логин" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <?php if (isset($login_error)): ?>
                        <div class="error-message"><?= $login_error ?></div>
                    <?php endif; ?>
                    <div class="auth-buttons">
                        <button type="submit" name="login_submit">Войти</button>
                        <button type="button" class="logout-btn" onclick="toggleLoginForm()">Отмена</button>
                    </div>
                </form>
            </div>
            
            <?php if (isset($success_message)): ?>
                <div class="success-message">
                    <?= $success_message ?>
                    <br><br>
                    <a href="index.php">Заполнить новую анкету</a>
                </div>
            <?php endif; ?>
            
            <!-- ИСПРАВЛЕННЫЙ БЛОК: логин и пароль при первой отправке -->
            <?php if (isset($_SESSION['new_credentials'])): ?>
                <div class="credentials-message">
                    <h3> Ваши данные для входа в личный кабинет</h3>
                    
                    <div class="credentials-box">
                        <div class="credential-item">
                            <strong>Логин</strong>
                            <div class="credential-value"><?= htmlspecialchars($_SESSION['new_credentials']['login']) ?></div>
                        </div>
                        
                        <div class="credential-item">
                            <strong>Пароль</strong>
                            <div class="credential-value"><?= htmlspecialchars($_SESSION['new_credentials']['password']) ?></div>
                        </div>
                    </div>
                    
                    <div class="credentials-warning">
                        Сохраните эти данные! Они показываются только один раз.
                    </div>
                </div>
                <?php unset($_SESSION['new_credentials']); ?>
            <?php endif; ?>
            
            <?php if (!empty($errors) && !isset($errors['db'])): ?>
                <div class="global-error">
                    <strong>Пожалуйста, исправьте следующие ошибки:</strong>
                    <ul>
                        <?php foreach ($errors as $field => $error): ?>
                            <?php if ($field !== 'db'): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (isset($errors['db'])): ?>
                <div class="global-error">
                    <?= htmlspecialchars($errors['db']) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="index.php">
                <!-- ФИО -->
                <div class="form-group <?= isset($errors['full_name']) ? 'has-error' : '' ?>">
                    <label for="full_name" class="required">ФИО</label>
                    <input type="text" id="full_name" name="full_name" 
                           value="<?= htmlspecialchars($old_data['full_name'] ?? $saved_data['full_name'] ?? '') ?>" 
                           placeholder="Иванов Иван Иванович" required>
                    <div class="hint">Только буквы, пробелы и дефисы, не более 150 символов</div>
                    <?php if (isset($errors['full_name'])): ?>
                        <div class="error-message"><?= $errors['full_name'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Телефон -->
                <div class="form-group <?= isset($errors['phone']) ? 'has-error' : '' ?>">
                    <label for="phone" class="required">Телефон</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?= htmlspecialchars($old_data['phone'] ?? $saved_data['phone'] ?? '') ?>" 
                           placeholder="+7 (999) 123-45-67" required>
                    <div class="hint">Цифры, пробелы, дефисы, скобки, + (6-20 символов)</div>
                    <?php if (isset($errors['phone'])): ?>
                        <div class="error-message"><?= $errors['phone'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Email -->
                <div class="form-group <?= isset($errors['email']) ? 'has-error' : '' ?>">
                    <label for="email" class="required">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?= htmlspecialchars($old_data['email'] ?? $saved_data['email'] ?? '') ?>" 
                           placeholder="ivan@example.com" required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="error-message"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Дата рождения -->
                <div class="form-group <?= isset($errors['birth_date']) ? 'has-error' : '' ?>">
                    <label for="birth_date" class="required">Дата рождения</label>
                    <input type="date" id="birth_date" name="birth_date" 
                           value="<?= htmlspecialchars($old_data['birth_date'] ?? $saved_data['birth_date'] ?? '') ?>" 
                           required>
                    <?php if (isset($errors['birth_date'])): ?>
                        <div class="error-message"><?= $errors['birth_date'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Пол -->
                <div class="form-group <?= isset($errors['gender']) ? 'has-error' : '' ?>">
                    <label class="required">Пол</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="male" name="gender" value="male" required
                                <?= (($old_data['gender'] ?? $saved_data['gender'] ?? '') == 'male') ? 'checked' : '' ?>>
                            <label for="male">Мужской</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="female" name="gender" value="female" required
                                <?= (($old_data['gender'] ?? $saved_data['gender'] ?? '') == 'female') ? 'checked' : '' ?>>
                            <label for="female">Женский</label>
                        </div>
                    </div>
                    <?php if (isset($errors['gender'])): ?>
                        <div class="error-message"><?= $errors['gender'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Языки -->
                <div class="form-group <?= isset($errors['languages']) ? 'has-error' : '' ?>">
                    <label for="languages" class="required">Любимые языки программирования</label>
                    <select name="languages[]" id="languages" multiple required size="6">
                        <?php
                        $selected_langs = $old_data['languages'] ?? $saved_data['languages'] ?? [];
                        if (!is_array($selected_langs)) {
                            $selected_langs = explode(',', $selected_langs);
                        }
                        $languages = [
                            1 => 'Pascal', 2 => 'C', 3 => 'C++', 4 => 'JavaScript',
                            5 => 'PHP', 6 => 'Python', 7 => 'Java', 8 => 'Haskell',
                            9 => 'Clojure', 10 => 'Prolog', 11 => 'Scala', 12 => 'Go'
                        ];
                        foreach ($languages as $id => $name): ?>
                            <option value="<?= $id ?>" 
                                <?= in_array((string)$id, $selected_langs) ? 'selected' : '' ?>>
                                <?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="hint">Держите Ctrl для выбора нескольких</div>
                    <?php if (isset($errors['languages'])): ?>
                        <div class="error-message"><?= $errors['languages'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Биография -->
                <div class="form-group <?= isset($errors['biography']) ? 'has-error' : '' ?>">
                    <label for="biography" class="required">Биография</label>
                    <textarea id="biography" name="biography" rows="6" 
                              placeholder="Расскажите о себе..." 
                              required><?= htmlspecialchars($old_data['biography'] ?? $saved_data['biography'] ?? '') ?></textarea>
                    <div class="hint">Максимум 5000 символов</div>
                    <?php if (isset($errors['biography'])): ?>
                        <div class="error-message"><?= $errors['biography'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Чекбокс -->
                <div class="form-group <?= isset($errors['contract_accepted']) ? 'has-error' : '' ?>">
                    <div class="checkbox-group">
                        <input type="checkbox" id="contract" name="contract_accepted" value="1" required
                            <?= (isset($old_data['contract_accepted']) || isset($saved_data['contract_accepted'])) ? 'checked' : '' ?>>
                        <label for="contract" class="required">Я ознакомлен(а) с условиями</label>
                    </div>
                    <?php if (isset($errors['contract_accepted'])): ?>
                        <div class="error-message"><?= $errors['contract_accepted'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Кнопка -->
                <button type="submit"><?= isset($_SESSION['user_id']) ? 'Обновить анкету' : 'Сохранить анкету' ?></button>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="edit-note">
                        Вы редактируете свою анкету. После сохранения данные будут обновлены.
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    
    <script>
    function toggleLoginForm() {
        var form = document.getElementById('login-form');
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
    
    // Показать форму входа если была ошибка
    <?php if (isset($login_error)): ?>
    document.getElementById('login-form').style.display = 'block';
    <?php endif; ?>
    </script>
</body>
</html>

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

session_start();
$dataFile = dirname(__FILE__) . '/data/database.json';
$uploadDir = dirname(__FILE__) . '/uploads/';

if (!file_exists(dirname(__FILE__) . '/data')) {
    mkdir(dirname(__FILE__) . '/data', 0777, true);
}
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

function readDatabase() {
    global $dataFile;
    if (!file_exists($dataFile)) {
        $defaultData = [
            'profile' => ['avatar' => '', 'about' => 'Привет! Я Даша Шмакова — full-stack разработчик.', 'name' => 'ДАША ШМАКОВА'],
            'projects' => [
                ['id' => 1, 'title' => 'Лендинг AI сервис', 'image' => '', 'tech' => ['React', 'Tailwind'], 'role' => 'Fullstack', 'tags' => ['Сайты'], 'likes' => 12, 'rating' => 5],
                ['id' => 2, 'title' => 'FitTrack приложение', 'image' => '', 'tech' => ['Flutter', 'Firebase'], 'role' => 'Mobile dev', 'tags' => ['Мобильные'], 'likes' => 8, 'rating' => 5],
                ['id' => 3, 'title' => 'Дизайн магазина', 'image' => '', 'tech' => ['Figma', 'XD'], 'role' => 'UI/UX', 'tags' => ['Дизайн'], 'likes' => 24, 'rating' => 5]
            ],
            'blog' => [
                ['id' => 1, 'title' => 'Как я начала программировать', 'content' => 'Мой путь в IT начался с простого интереса к веб-сайтам. Я начала с HTML и CSS, потом изучила JavaScript, React, Node.js. Сейчас я full-stack разработчик и помогаю другим входить в IT. Главный совет — не бойтесь ошибок, каждая ошибка делает вас лучше. Практикуйтесь каждый день, делайте свои проекты, и результат не заставит себя ждать.', 'date' => '2025-02-10', 'image' => ''],
                ['id' => 2, 'title' => 'Советы начинающим разработчикам', 'content' => '1. Начните с малого — сделайте простой сайт-визитку. 2. Учитесь каждый день по 30-60 минут. 3. Не копируйте код, пишите сами. 4. Используйте Git с первого дня. 5. Задавайте вопросы в сообществах. 6. Делайте пет-проекты для портфолио. 7. Изучайте английский язык. 8. Следите за трендами, но не гонитесь за всеми технологиями. 9. Учитесь читать чужой код. 10. Не сдавайтесь при первых трудностях.', 'date' => '2025-02-15', 'image' => '']
            ],
            'services' => [
                ['id' => 1, 'name' => 'Разработка сайтов', 'desc' => 'Создание современных адаптивных сайтов любой сложности под ключ', 'price' => 'от 25 000 ₽'],
                ['id' => 2, 'name' => 'Мобильные приложения', 'desc' => 'Кроссплатформенные приложения для iOS и Android на Flutter', 'price' => 'от 50 000 ₽'],
                ['id' => 3, 'name' => 'UI/UX дизайн', 'desc' => 'Создание удобного и красивого интерфейса для вашего продукта', 'price' => 'от 15 000 ₽']
            ],
            'reviews' => [],
            'user_messages' => [],
            'bookings' => [],
            'users' => [
                ['id' => 1, 'username' => 'dasha.shmakova', 'password' => password_hash('admin123', PASSWORD_DEFAULT), 'role' => 'admin', 'balance' => 0, 'created_at' => '2025-03-29', 'avatar' => '']
            ],
            'support_chats' => [],
            'payments' => [],
            'likes' => [],
            'ratings' => [],
            'reviews_auth' => []
        ];
        file_put_contents($dataFile, json_encode($defaultData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $defaultData;
    }
    $content = file_get_contents($dataFile);
    return json_decode($content, true);
}

function writeDatabase($data) {
    global $dataFile;
    return file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$db = readDatabase();
$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

// ========== АВТОРИЗАЦИЯ ==========

if ($action === 'register' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    
    if (!$username || !$password) {
        echo json_encode(['success' => false, 'error' => 'Заполните все поля']);
        exit;
    }
    
    foreach ($db['users'] as $u) {
        if ($u['username'] === $username) {
            echo json_encode(['success' => false, 'error' => 'Пользователь уже существует']);
            exit;
        }
    }
    
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $newUserId = time();
    $db['users'][] = [
        'id' => $newUserId,
        'username' => $username,
        'password' => $hashed,
        'role' => 'user',
        'balance' => 0,
        'created_at' => date('Y-m-d'),
        'avatar' => ''
    ];
    
    $db['support_chats'][] = [
        'chat_id' => $newUserId,
        'username' => $username,
        'created_at' => date('Y-m-d H:i:s'),
        'messages' => [],
        'unread_admin' => 0,
        'unread_user' => 0
    ];
    
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'login' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    
    foreach ($db['users'] as $u) {
        if ($u['username'] === $username && password_verify($password, $u['password'])) {
            $_SESSION['user'] = $u;
            echo json_encode(['success' => true, 'user' => [
                'username' => $u['username'], 
                'role' => $u['role'], 
                'balance' => $u['balance'], 
                'avatar' => $u['avatar'], 
                'id' => $u['id']
            ]]);
            exit;
        }
    }
    echo json_encode(['success' => false, 'error' => 'Неверное имя или пароль']);
    exit;
}

if ($action === 'checkSession') {
    if (isset($_SESSION['user'])) {
        echo json_encode(['success' => true, 'user' => $_SESSION['user']]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

if ($action === 'logout') {
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}

// ========== ЗАГРУЗКА ИЗОБРАЖЕНИЙ ==========

if ($action === 'uploadProjectImage' && $method === 'POST') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false, 'error' => 'Доступ запрещён']);
        exit;
    }
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $filename = 'project_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                echo json_encode(['success' => true, 'url' => 'uploads/' . $filename]);
                exit;
            }
        }
    }
    echo json_encode(['success' => false]);
    exit;
}

if ($action === 'uploadBlogImage' && $method === 'POST') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false, 'error' => 'Доступ запрещён']);
        exit;
    }
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $filename = 'blog_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                echo json_encode(['success' => true, 'url' => 'uploads/' . $filename]);
                exit;
            }
        }
    }
    echo json_encode(['success' => false]);
    exit;
}

if ($action === 'uploadUserAvatar' && $method === 'POST') {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false]);
        exit;
    }
    
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $filename = 'avatar_' . $_SESSION['user']['username'] . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $filename)) {
                $avatarUrl = 'uploads/' . $filename;
                foreach ($db['users'] as &$u) {
                    if ($u['username'] === $_SESSION['user']['username']) {
                        $u['avatar'] = $avatarUrl;
                        $_SESSION['user']['avatar'] = $avatarUrl;
                        break;
                    }
                }
                writeDatabase($db);
                echo json_encode(['success' => true, 'url' => $avatarUrl]);
                exit;
            }
        }
    }
    echo json_encode(['success' => false]);
    exit;
}

if ($action === 'uploadAvatar' && $method === 'POST') {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $filename = 'site_avatar_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $filename)) {
                echo json_encode(['success' => true, 'url' => 'uploads/' . $filename]);
                exit;
            }
        }
    }
    echo json_encode(['success' => false]);
    exit;
}

// ========== ПРОФИЛЬ САЙТА ==========

if ($action === 'getProfile') {
    echo json_encode($db['profile']);
    exit;
}

if ($action === 'updateProfile' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    foreach ($input as $k => $v) {
        if (isset($db['profile'][$k])) $db['profile'][$k] = $v;
    }
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

// ========== ПРОЕКТЫ ==========

if ($action === 'getProjects') { 
    echo json_encode($db['projects']); 
    exit; 
}

if ($action === 'addProject' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $input['id'] = time();
    $input['likes'] = 0;
    $input['rating'] = 0;
    $db['projects'][] = $input;
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'updateProject' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input && isset($input['id'])) {
        foreach ($db['projects'] as $k => $p) {
            if ($p['id'] == $input['id']) {
                $db['projects'][$k] = array_merge($p, $input);
                break;
            }
        }
        writeDatabase($db);
        echo json_encode(['success' => true]);
    }
    exit;
}

if ($action === 'deleteProject' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $db['projects'] = array_values(array_filter($db['projects'], fn($p) => $p['id'] != $input['id']));
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

// ========== БЛОГ ==========

if ($action === 'getBlog') { 
    echo json_encode($db['blog']); 
    exit; 
}

if ($action === 'addBlog' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $input['id'] = time();
    $input['date'] = date('Y-m-d');
    $db['blog'][] = $input;
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'updateBlog' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input && isset($input['id'])) {
        foreach ($db['blog'] as $k => $b) {
            if ($b['id'] == $input['id']) {
                $db['blog'][$k] = array_merge($b, $input);
                break;
            }
        }
        writeDatabase($db);
        echo json_encode(['success' => true]);
    }
    exit;
}

if ($action === 'deleteBlog' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $db['blog'] = array_values(array_filter($db['blog'], fn($b) => $b['id'] != $input['id']));
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

// ========== УСЛУГИ ==========

if ($action === 'getServices') { 
    echo json_encode($db['services']); 
    exit; 
}

if ($action === 'addService' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $input['id'] = time();
    $db['services'][] = $input;
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'updateService' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input && isset($input['id'])) {
        foreach ($db['services'] as $k => $s) {
            if ($s['id'] == $input['id']) {
                $db['services'][$k] = array_merge($s, $input);
                break;
            }
        }
        writeDatabase($db);
        echo json_encode(['success' => true]);
    }
    exit;
}

if ($action === 'deleteService' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $db['services'] = array_values(array_filter($db['services'], fn($s) => $s['id'] != $input['id']));
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

// ========== ЛАЙКИ И РЕЙТИНГИ ==========

if ($action === 'likeProject' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'error' => 'Войдите в аккаунт']);
        exit;
    }
    $userId = $_SESSION['user']['username'];
    $projectId = $input['id'];
    
    foreach ($db['likes'] as $like) {
        if ($like['user'] === $userId && $like['project'] == $projectId) {
            echo json_encode(['success' => false, 'error' => 'Вы уже поставили лайк']);
            exit;
        }
    }
    
    $db['likes'][] = ['user' => $userId, 'project' => $projectId];
    foreach ($db['projects'] as &$p) {
        if ($p['id'] == $projectId) {
            $p['likes'] = ($p['likes'] ?? 0) + 1;
            break;
        }
    }
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'rateProject' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'error' => 'Войдите в аккаунт']);
        exit;
    }
    $userId = $_SESSION['user']['username'];
    $projectId = $input['id'];
    $rating = $input['rating'];
    
    foreach ($db['ratings'] as $r) {
        if ($r['user'] === $userId && $r['project'] == $projectId) {
            echo json_encode(['success' => false, 'error' => 'Вы уже оценили']);
            exit;
        }
    }
    
    $db['ratings'][] = ['user' => $userId, 'project' => $projectId, 'rating' => $rating];
    foreach ($db['projects'] as &$p) {
        if ($p['id'] == $projectId) {
            $p['rating'] = $rating;
            break;
        }
    }
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

// ========== ОТЗЫВЫ ==========

if ($action === 'addReviewAuth' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'error' => 'Войдите в аккаунт']);
        exit;
    }
    $input['id'] = time();
    $input['author'] = $_SESSION['user']['username'];
    $input['date'] = date('Y-m-d');
    array_unshift($db['reviews_auth'], $input);
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'getReviewsAuth') {
    echo json_encode($db['reviews_auth']);
    exit;
}

// ========== БАЛАНС ==========

if ($action === 'getBalance') {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false]);
        exit;
    }
    foreach ($db['users'] as $u) {
        if ($u['username'] === $_SESSION['user']['username']) {
            echo json_encode(['success' => true, 'balance' => $u['balance']]);
            exit;
        }
    }
    exit;
}

if ($action === 'addBalance' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false]);
        exit;
    }
    $username = $input['username'] ?? '';
    $amount = floatval($input['amount'] ?? 0);
    foreach ($db['users'] as &$u) {
        if ($u['username'] === $username) {
            $u['balance'] += $amount;
            writeDatabase($db);
            echo json_encode(['success' => true]);
            exit;
        }
    }
    echo json_encode(['success' => false]);
    exit;
}

// ========== ПЛАТЕЖИ ==========

if ($action === 'requestPayment' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false]);
        exit;
    }
    $db['payments'][] = [
        'id' => time(),
        'username' => $_SESSION['user']['username'],
        'amount' => floatval($input['amount'] ?? 0),
        'comment' => $input['comment'] ?? '',
        'status' => 'pending',
        'date' => date('Y-m-d H:i:s')
    ];
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'getPayments') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode([]);
        exit;
    }
    echo json_encode($db['payments']);
    exit;
}

if ($action === 'confirmPayment' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false]);
        exit;
    }
    foreach ($db['payments'] as &$p) {
        if ($p['id'] == $input['id']) {
            $p['status'] = 'confirmed';
            foreach ($db['users'] as &$u) {
                if ($u['username'] === $p['username']) {
                    $u['balance'] += $p['amount'];
                    break;
                }
            }
            break;
        }
    }
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'rejectPayment' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false]);
        exit;
    }
    foreach ($db['payments'] as &$p) {
        if ($p['id'] == $input['id']) {
            $p['status'] = 'rejected';
            break;
        }
    }
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

// ========== БРОНИРОВАНИЯ ==========

if ($action === 'addBooking' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'error' => 'Войдите в аккаунт']);
        exit;
    }
    $input['id'] = time();
    $input['username'] = $_SESSION['user']['username'];
    $input['status'] = 'pending';
    $db['bookings'][] = $input;
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'getUserBookings') {
    if (!isset($_SESSION['user'])) {
        echo json_encode([]);
        exit;
    }
    $userBookings = array_filter($db['bookings'], fn($b) => $b['username'] === $_SESSION['user']['username']);
    echo json_encode(array_values($userBookings));
    exit;
}

if ($action === 'getBookings') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode([]);
        exit;
    }
    echo json_encode($db['bookings']);
    exit;
}

if ($action === 'updateBooking' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false]);
        exit;
    }
    foreach ($db['bookings'] as &$b) {
        if ($b['id'] == $input['id']) {
            $b['status'] = $input['status'];
            $b['reject_reason'] = $input['reason'] ?? '';
            break;
        }
    }
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'deleteBooking' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false]);
        exit;
    }
    $db['bookings'] = array_values(array_filter($db['bookings'], fn($b) => $b['id'] != $input['id']));
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'getAvailableSlots') {
    $date = $_GET['date'] ?? date('Y-m-d');
    $now = new DateTime('now', new DateTimeZone('Europe/Moscow'));
    $booked = array_filter($db['bookings'], fn($b) => $b['date'] === $date && $b['status'] !== 'cancelled');
    $bookedTimes = array_map(fn($b) => $b['time'], $booked);
    $allSlots = ['10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00', '18:00'];
    $available = [];
    foreach ($allSlots as $slot) {
        $slotTime = DateTime::createFromFormat('Y-m-d H:i', "$date $slot", new DateTimeZone('Europe/Moscow'));
        if ($slotTime > $now && !in_array($slot, $bookedTimes)) {
            $available[] = $slot;
        }
    }
    echo json_encode($available);
    exit;
}

// ========== СООБЩЕНИЯ В ПРОФИЛЬ ==========

if ($action === 'sendUserMessage' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = trim($input['msg'] ?? '');
    $name = trim($input['name'] ?? 'Аноним');
    
    if (empty($message)) {
        echo json_encode(['success' => false, 'error' => 'Сообщение не может быть пустым']);
        exit;
    }
    
    $username = isset($_SESSION['user']) ? $_SESSION['user']['username'] : null;
    
    $newMessage = [
        'id' => time() . rand(100, 999),
        'message' => $message,
        'name' => $name,
        'date' => date('Y-m-d H:i:s'),
        'status' => 'pending',
        'admin_reply' => null,
        'admin_reply_date' => null,
        'reject_reason' => null
    ];
    
    if ($username) {
        $newMessage['username'] = $username;
        $found = false;
        foreach ($db['user_messages'] as &$userMsg) {
            if ($userMsg['username'] === $username) {
                $userMsg['messages'][] = $newMessage;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $db['user_messages'][] = [
                'username' => $username,
                'name' => $name,
                'messages' => [$newMessage]
            ];
        }
    } else {
        $found = false;
        foreach ($db['user_messages'] as &$userMsg) {
            if ($userMsg['name'] === $name && !isset($userMsg['username'])) {
                $userMsg['messages'][] = $newMessage;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $db['user_messages'][] = [
                'name' => $name,
                'messages' => [$newMessage]
            ];
        }
    }
    
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'getMyMessages') {
    if (!isset($_SESSION['user'])) {
        echo json_encode([]);
        exit;
    }
    
    $username = $_SESSION['user']['username'];
    
    foreach ($db['user_messages'] as $userData) {
        if (isset($userData['username']) && $userData['username'] === $username) {
            $messages = array_reverse($userData['messages']);
            echo json_encode($messages);
            exit;
        }
    }
    
    echo json_encode([]);
    exit;
}

if ($action === 'getAllUserMessages') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode([]);
        exit;
    }
    
    $result = [];
    foreach ($db['user_messages'] as $userData) {
        if (!empty($userData['messages'])) {
            $lastMessage = end($userData['messages']);
            $userData['last_message_date'] = $lastMessage['date'];
            $userData['last_message_preview'] = mb_substr($lastMessage['message'], 0, 50);
            $userData['pending_count'] = count(array_filter($userData['messages'], fn($m) => $m['status'] === 'pending'));
            $result[] = $userData;
        }
    }
    
    usort($result, function($a, $b) {
        return strtotime($b['last_message_date']) - strtotime($a['last_message_date']);
    });
    
    echo json_encode($result);
    exit;
}

if ($action === 'replyToUserMessage' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false, 'error' => 'Доступ запрещён']);
        exit;
    }
    
    $messageId = $input['message_id'];
    $reply = trim($input['reply'] ?? '');
    $actionType = $input['action_type'] ?? 'reply';
    
    foreach ($db['user_messages'] as &$userData) {
        foreach ($userData['messages'] as &$msg) {
            if ($msg['id'] == $messageId) {
                if ($actionType === 'reject') {
                    $msg['status'] = 'rejected';
                    $msg['reject_reason'] = $reply;
                } else {
                    $msg['status'] = 'answered';
                    $msg['admin_reply'] = $reply;
                    $msg['admin_reply_date'] = date('Y-m-d H:i:s');
                }
                writeDatabase($db);
                echo json_encode(['success' => true]);
                exit;
            }
        }
    }
    
    echo json_encode(['success' => false, 'error' => 'Сообщение не найдено']);
    exit;
}

// ========== ЧАТЫ ПОДДЕРЖКИ ==========

if ($action === 'getUserChat') {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'error' => 'Не авторизован']);
        exit;
    }
    
    $username = $_SESSION['user']['username'];
    $userId = $_SESSION['user']['id'];
    
    $chatIndex = -1;
    foreach ($db['support_chats'] as $i => $chat) {
        if ($chat['username'] === $username) {
            $chatIndex = $i;
            break;
        }
    }
    
    if ($chatIndex === -1) {
        $db['support_chats'][] = [
            'chat_id' => $userId,
            'username' => $username,
            'created_at' => date('Y-m-d H:i:s'),
            'messages' => [],
            'unread_admin' => 0,
            'unread_user' => 0
        ];
        writeDatabase($db);
        $chatIndex = count($db['support_chats']) - 1;
    }
    
    $db['support_chats'][$chatIndex]['unread_user'] = 0;
    writeDatabase($db);
    
    echo json_encode([
        'success' => true,
        'chat' => $db['support_chats'][$chatIndex]
    ]);
    exit;
}

if ($action === 'sendChatMessage' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'error' => 'Войдите в аккаунт']);
        exit;
    }
    
    $message = trim($input['message'] ?? '');
    if (empty($message)) {
        echo json_encode(['success' => false, 'error' => 'Сообщение не может быть пустым']);
        exit;
    }
    
    $username = $_SESSION['user']['username'];
    
    foreach ($db['support_chats'] as &$chat) {
        if ($chat['username'] === $username) {
            $chat['messages'][] = [
                'id' => time() . rand(100, 999),
                'from' => 'user',
                'username' => $username,
                'message' => $message,
                'date' => date('Y-m-d H:i:s'),
                'read' => false
            ];
            $chat['unread_admin']++;
            writeDatabase($db);
            echo json_encode(['success' => true]);
            exit;
        }
    }
    
    echo json_encode(['success' => false, 'error' => 'Чат не найден']);
    exit;
}

if ($action === 'adminSendMessage' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false, 'error' => 'Доступ запрещён']);
        exit;
    }
    
    $chatId = $input['chat_id'] ?? '';
    $message = trim($input['message'] ?? '');
    
    if (empty($message)) {
        echo json_encode(['success' => false, 'error' => 'Сообщение не может быть пустым']);
        exit;
    }
    
    foreach ($db['support_chats'] as &$chat) {
        if ($chat['chat_id'] == $chatId || $chat['username'] === $chatId) {
            $chat['messages'][] = [
                'id' => time() . rand(100, 999),
                'from' => 'admin',
                'username' => 'admin',
                'message' => $message,
                'date' => date('Y-m-d H:i:s'),
                'read' => false
            ];
            $chat['unread_user']++;
            writeDatabase($db);
            echo json_encode(['success' => true]);
            exit;
        }
    }
    
    echo json_encode(['success' => false, 'error' => 'Чат не найден']);
    exit;
}

if ($action === 'getAllChats') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode([]);
        exit;
    }
    
    $chats = $db['support_chats'];
    foreach ($chats as &$chat) {
        if (!empty($chat['messages'])) {
            $lastMessage = end($chat['messages']);
            $chat['last_message_date'] = $lastMessage['date'];
            $chat['last_message'] = $lastMessage['message'];
        } else {
            $chat['last_message_date'] = $chat['created_at'];
            $chat['last_message'] = 'Нет сообщений';
        }
    }
    
    usort($chats, function($a, $b) {
        return strtotime($b['last_message_date']) - strtotime($a['last_message_date']);
    });
    
    echo json_encode($chats);
    exit;
}

if ($action === 'getChatMessages') {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false]);
        exit;
    }
    
    $chatId = $_GET['chat_id'] ?? '';
    $isAdmin = $_SESSION['user']['role'] === 'admin';
    
    foreach ($db['support_chats'] as &$chat) {
        if ($chat['chat_id'] == $chatId || $chat['username'] === $chatId) {
            if (!$isAdmin && $chat['username'] !== $_SESSION['user']['username']) {
                echo json_encode(['success' => false, 'error' => 'Доступ запрещён']);
                exit;
            }
            
            if ($isAdmin) {
                $chat['unread_admin'] = 0;
            } else {
                $chat['unread_user'] = 0;
            }
            writeDatabase($db);
            
            echo json_encode([
                'success' => true,
                'messages' => $chat['messages'],
                'chat' => $chat
            ]);
            exit;
        }
    }
    
    echo json_encode(['success' => false, 'error' => 'Чат не найден']);
    exit;
}

if ($action === 'getUnreadCounts') {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false]);
        exit;
    }
    
    $isAdmin = $_SESSION['user']['role'] === 'admin';
    $username = $_SESSION['user']['username'];
    $unreadCount = 0;
    
    if ($isAdmin) {
        foreach ($db['support_chats'] as $chat) {
            $unreadCount += $chat['unread_admin'];
        }
    } else {
        foreach ($db['support_chats'] as $chat) {
            if ($chat['username'] === $username) {
                $unreadCount = $chat['unread_user'];
                break;
            }
        }
    }
    
    echo json_encode(['success' => true, 'unread' => $unreadCount]);
    exit;
}

// ========== ПОЛЬЗОВАТЕЛИ (АДМИН) ==========

if ($action === 'getUsers') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode([]);
        exit;
    }
    $users = array_map(function($u) {
        return ['username' => $u['username'], 'role' => $u['role'], 'balance' => $u['balance'], 'avatar' => $u['avatar'] ?? '', 'id' => $u['id']];
    }, $db['users']);
    echo json_encode($users);
    exit;
}

if ($action === 'addUser' && $method === 'POST') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false]);
        exit;
    }
    $input = json_decode(file_get_contents('php://input'), true);
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    $role = $input['role'] ?? 'user';
    
    if (!$username || !$password) {
        echo json_encode(['success' => false, 'error' => 'Заполните поля']);
        exit;
    }
    foreach ($db['users'] as $u) {
        if ($u['username'] === $username) {
            echo json_encode(['success' => false, 'error' => 'Пользователь уже существует']);
            exit;
        }
    }
    $newUserId = time();
    $db['users'][] = [
        'id' => $newUserId,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => $role,
        'balance' => 0,
        'created_at' => date('Y-m-d'),
        'avatar' => ''
    ];
    
    $db['support_chats'][] = [
        'chat_id' => $newUserId,
        'username' => $username,
        'created_at' => date('Y-m-d H:i:s'),
        'messages' => [],
        'unread_admin' => 0,
        'unread_user' => 0
    ];
    
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'deleteUser' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode(['success' => false]);
        exit;
    }
    $username = $input['username'] ?? '';
    
    $db['support_chats'] = array_values(array_filter($db['support_chats'], fn($c) => $c['username'] !== $username));
    $db['users'] = array_values(array_filter($db['users'], fn($u) => $u['username'] !== $username));
    writeDatabase($db);
    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['error' => 'Invalid action']);
?>

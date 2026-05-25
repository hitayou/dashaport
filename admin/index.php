<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Админ панель | Даша Шмакова</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #f8f9fa;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: #f1f3f5;
            --text-primary: #212529;
            --text-secondary: #495057;
            --text-muted: #868e96;
            --border: #dee2e6;
            --border-hover: #adb5bd;
            --accent: #4f46e5;
            --accent-gradient: linear-gradient(135deg, #4f46e5, #6366f1);
            --accent-glow: rgba(79, 70, 229, 0.1);
            --error: #dc2626;
            --success: #10b981;
            --warning: #f59e0b;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-primary);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        h1 {
            color: var(--text-primary);
            font-size: 24px;
            font-weight: 600;
        }

        .nav-links {
            display: flex;
            gap: 12px;
        }

        .nav-link {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            padding: 8px 20px;
            border-radius: 40px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        h2 {
            color: var(--text-primary);
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
            border-bottom: 2px solid var(--accent);
            padding-bottom: 10px;
            display: inline-block;
        }

        h3 {
            color: var(--text-primary);
            margin-bottom: 16px;
            font-size: 18px;
            font-weight: 500;
        }

        .badge {
            background: var(--error);
            color: white;
            border-radius: 30px;
            padding: 2px 8px;
            font-size: 11px;
            margin-left: 8px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px 14px;
            margin: 8px 0 16px;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 14px;
            transition: all 0.2s;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        button {
            background: var(--accent-gradient);
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 40px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            margin-right: 8px;
            margin-top: 8px;
            transition: all 0.2s;
            box-shadow: var(--shadow);
        }

        button:hover {
            opacity: 0.9;
        }

        .danger {
            background: var(--error);
        }

        .success {
            background: var(--success);
        }

        .edit-btn {
            background: var(--warning);
        }

        .reply-btn {
            background: #3b82f6;
        }

        .item {
            background: var(--bg-primary);
            padding: 16px;
            margin: 12px 0;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            border: 1px solid var(--border);
        }

        .item-info {
            flex: 1;
        }

        .item-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
            font-size: 14px;
        }

        .item-desc {
            font-size: 12px;
            color: var(--text-muted);
        }

        .item-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 16px;
            border: 3px solid var(--accent);
        }

        .booking-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background: var(--warning);
            color: white;
        }

        .status-confirmed {
            background: var(--success);
            color: white;
        }

        .status-cancelled {
            background: var(--error);
            color: white;
        }

        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            border-bottom: 1px solid var(--border);
            padding-bottom: 12px;
        }

        .tab-btn {
            background: transparent;
            color: var(--text-secondary);
            border: none;
            padding: 8px 20px;
            border-radius: 40px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            margin: 0;
            box-shadow: none;
        }

        .tab-btn:hover {
            background: var(--accent-glow);
            color: var(--accent);
        }

        .tab-btn.active {
            background: var(--accent-gradient);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: var(--bg-secondary);
            border-radius: 24px;
            padding: 28px;
            width: 500px;
            max-width: 90%;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-hover);
        }

        .modal-content h3 {
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .close-modal {
            float: right;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 24px;
        }

        .close-modal:hover {
            color: var(--text-primary);
        }

        /* Отчёт */
        .report-container {
            background: white;
            border-radius: 16px;
            padding: 20px;
            overflow-x: auto;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8fafc;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid var(--accent);
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #1a1035;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .report-table th,
        .report-table td {
            padding: 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
        }

        .report-table th {
            background: #f3f4f6;
            font-weight: 600;
        }

        .report-table td.text-right {
            text-align: right;
        }

        .report-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #999;
        }

        /* Чат */
        .chat-item {
            background: var(--bg-primary);
            padding: 16px;
            margin: 12px 0;
            border-radius: 16px;
            cursor: pointer;
            border: 1px solid var(--border);
            transition: all 0.2s;
        }

        .chat-item:hover {
            border-color: var(--accent);
            background: var(--accent-glow);
        }

        .chat-unread {
            border-left: 4px solid var(--error);
        }

        .chat-messages-area {
            background: var(--bg-primary);
            border-radius: 16px;
            padding: 16px;
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 16px;
        }

        .chat-message {
            margin-bottom: 16px;
            padding: 10px 14px;
            border-radius: 16px;
            max-width: 80%;
        }

        .chat-message.user {
            background: var(--accent-glow);
            margin-left: auto;
        }

        .chat-message.admin {
            background: rgba(16, 185, 129, 0.1);
            margin-right: auto;
        }

        .chat-message .sender {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--text-muted);
        }

        .chat-message .text {
            font-size: 14px;
            color: var(--text-primary);
        }

        .chat-message .time {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 4px;
            text-align: right;
        }

        .chat-input-area {
            display: flex;
            gap: 10px;
            margin-top: 16px;
        }

        .chat-input-area input {
            flex: 1;
            margin: 0;
        }

        .filter-group {
            background: var(--bg-primary);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .date-range {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
            .item {
                flex-direction: column;
                align-items: flex-start;
            }
            body {
                padding: 16px;
            }
            .card {
                padding: 16px;
            }
            .report-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            .date-range {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .header, .tabs, .nav-links, .filter-group, .no-print {
                display: none !important;
            }
            .card {
                box-shadow: none;
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Админ панель</h1>
        <div class="nav-links">
            <a href="../index.html" class="nav-link">На сайт</a>
            <button onclick="logout()" style="background: #6c757d;">Выйти</button>
        </div>
    </div>

    <div class="tabs">
        <button class="tab-btn active" data-tab="reports">Бухгалтерия</button>
        <button class="tab-btn" data-tab="chats">Чаты</button>
        <button class="tab-btn" data-tab="messages">Сообщения</button>
        <button class="tab-btn" data-tab="projects">Проекты</button>
        <button class="tab-btn" data-tab="blog">Блог</button>
        <button class="tab-btn" data-tab="services">Услуги</button>
        <button class="tab-btn" data-tab="payments">Оплаты</button>
        <button class="tab-btn" data-tab="bookings">Консультации</button>
        <button class="tab-btn" data-tab="users">Пользователи</button>
        <button class="tab-btn" data-tab="profile">Профиль</button>
    </div>

    <!-- БУХГАЛТЕРИЯ -->
    <div id="tab-reports" class="tab-content active">
        <div class="card">
            <h2>Бухгалтерский отчёт</h2>
            <div class="filter-group">
                <div class="date-range">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 13px;">Дата начала</label>
                        <input type="date" id="startDate">
                    </div>
                    <div style="text-align: center; padding-top: 25px;">—</div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 13px;">Дата окончания</label>
                        <input type="date" id="endDate">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button id="applyReportBtn" class="success">Сформировать</button>
                    <button id="exportPdfBtn">Сохранить PDF</button>
                    <button id="printReportBtn">Печать</button>
                </div>
            </div>
            <div id="reportContainer" class="report-container">
                <div style="text-align: center; padding: 60px; color: #999;">Выберите период для формирования отчёта</div>
            </div>
        </div>
    </div>

    <!-- ЧАТЫ ПОДДЕРЖКИ -->
    <div id="tab-chats" class="tab-content">
        <div class="card">
            <h2>Чаты поддержки</h2>
            <div style="display: grid; grid-template-columns: 300px 1fr; gap: 20px; min-height: 500px;">
                <div style="background: var(--bg-primary); border-radius: 16px; padding: 16px; overflow-y: auto;">
                    <h3 style="margin-top: 0;">Диалоги</h3>
                    <div id="chatsList"></div>
                </div>
                <div style="background: var(--bg-primary); border-radius: 16px; padding: 16px;">
                    <div id="chatMainArea">
                        <div style="text-align: center; padding: 60px; color: var(--text-muted);">Выберите диалог слева</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- СООБЩЕНИЯ -->
    <div id="tab-messages" class="tab-content">
        <div class="card">
            <h2>Сообщения от пользователей</h2>
            <div id="messagesList"></div>
        </div>
    </div>

    <!-- ПРОЕКТЫ -->
    <div id="tab-projects" class="tab-content">
        <div class="card">
            <h2>Проекты</h2>
            <div class="grid-2">
                <input type="text" id="projTitle" placeholder="Название">
                <input type="text" id="projRole" placeholder="Роль">
                <input type="text" id="projTech" placeholder="Технологии">
                <input type="text" id="projTags" placeholder="Теги">
            </div>
            <input type="text" id="projImage" placeholder="URL картинки">
            <input type="file" id="projImageFile" accept="image/*">
            <button onclick="addProject()">Добавить проект</button>
            <div id="projectsList"></div>
        </div>
    </div>

    <!-- БЛОГ -->
    <div id="tab-blog" class="tab-content">
        <div class="card">
            <h2>Статьи блога</h2>
            <input type="text" id="blogTitle" placeholder="Заголовок">
            <textarea id="blogContent" rows="4" placeholder="Содержание"></textarea>
            <input type="text" id="blogImage" placeholder="URL картинки">
            <input type="file" id="blogImageFile" accept="image/*">
            <button onclick="addBlog()">Добавить статью</button>
            <div id="blogList"></div>
        </div>
    </div>

    <!-- УСЛУГИ -->
    <div id="tab-services" class="tab-content">
        <div class="card">
            <h2>Услуги</h2>
            <input type="text" id="servName" placeholder="Название">
            <input type="text" id="servPrice" placeholder="Цена">
            <textarea id="servDesc" rows="3" placeholder="Описание"></textarea>
            <button onclick="addService()">Добавить услугу</button>
            <div id="servicesList"></div>
        </div>
    </div>

    <!-- ОПЛАТЫ -->
    <div id="tab-payments" class="tab-content">
        <div class="card">
            <h2>Заявки на пополнение</h2>
            <div id="paymentsList"></div>
        </div>
    </div>

    <!-- КОНСУЛЬТАЦИИ -->
    <div id="tab-bookings" class="tab-content">
        <div class="card">
            <h2>Записи на консультацию</h2>
            <div id="bookingsList"></div>
        </div>
    </div>

    <!-- ПОЛЬЗОВАТЕЛИ -->
    <div id="tab-users" class="tab-content">
        <div class="card">
            <h2>Пользователи</h2>
            <div class="grid-2">
                <input type="text" id="newUsername" placeholder="Имя">
                <input type="password" id="newPassword" placeholder="Пароль">
                <select id="newRole">
                    <option value="user">Пользователь</option>
                    <option value="admin">Админ</option>
                </select>
            </div>
            <button onclick="addUser()">Добавить</button>
            <div id="usersList"></div>
            <div style="margin-top: 20px;">
                <h3>Пополнить баланс</h3>
                <div class="grid-2">
                    <input type="text" id="balanceUsername" placeholder="Username">
                    <input type="number" id="balanceAmount" placeholder="Сумма">
                </div>
                <button onclick="addBalance()">Пополнить</button>
            </div>
        </div>
    </div>

    <!-- ПРОФИЛЬ САЙТА -->
    <div id="tab-profile" class="tab-content">
        <div class="card">
            <h2>Профиль сайта</h2>
            <div id="avatarPreview" style="text-align: center;"></div>
            <input type="file" id="avatarFile" accept="image/*">
            <input type="text" id="profileName" placeholder="Имя">
            <textarea id="profileAbout" rows="4" placeholder="О себе"></textarea>
            <button onclick="saveProfile()">Сохранить</button>
        </div>
    </div>
</div>

<!-- Модалки -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeEditModal()">&times;</span>
        <h3 id="editModalTitle">Редактирование</h3>
        <div id="editModalFields"></div>
        <button onclick="saveEdit()">Сохранить</button>
        <button class="danger" onclick="closeEditModal()">Отмена</button>
    </div>
</div>

<div id="replyModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeReplyModal()">&times;</span>
        <h3>Ответить пользователю</h3>
        <input type="text" id="replyToUser" placeholder="Кому" readonly>
        <textarea id="replyMessageText" rows="5" placeholder="Введите ответ..."></textarea>
        <button onclick="sendReply()">Отправить</button>
        <button class="danger" onclick="closeReplyModal()">Отмена</button>
    </div>
</div>

<script>
const API_URL = '../api.php';
let currentEditType = null;
let currentEditId = null;
let currentMessageId = null;
let currentChatUser = null;
let currentChatId = null;
let chatsInterval = null;

async function api(action, method = 'GET', data = null, query = '') {
    let url = `${API_URL}?action=${action}${query}`;
    let opt = { method, headers: { 'Content-Type': 'application/json' }, credentials: 'include' };
    if (data) opt.body = JSON.stringify(data);
    let res = await fetch(url, opt);
    return await res.json();
}

async function uploadProjectImage(file) {
    let formData = new FormData();
    formData.append('image', file);
    let res = await fetch(`${API_URL}?action=uploadProjectImage`, { method: 'POST', body: formData });
    let result = await res.json();
    return result.success ? result.url : null;
}

async function uploadBlogImage(file) {
    let formData = new FormData();
    formData.append('image', file);
    let res = await fetch(`${API_URL}?action=uploadBlogImage`, { method: 'POST', body: formData });
    let result = await res.json();
    return result.success ? result.url : null;
}

async function uploadAvatar(file) {
    let formData = new FormData();
    formData.append('avatar', file);
    let res = await fetch(`${API_URL}?action=uploadAvatar`, { method: 'POST', body: formData });
    let result = await res.json();
    return result.success ? result.url : null;
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, m => m === '&' ? '&amp;' : (m === '<' ? '&lt;' : '&gt;'));
}

async function logout() {
    await api('logout');
    window.location.href = 'index.php';
}

// ========== БУХГАЛТЕРИЯ ==========

function setDefaultDates() {
    let today = new Date();
    let firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    document.getElementById('startDate').value = firstDayOfMonth.toISOString().split('T')[0];
    document.getElementById('endDate').value = today.toISOString().split('T')[0];
}

async function generateReport() {
    let startDate = document.getElementById('startDate').value;
    let endDate = document.getElementById('endDate').value;

    if (!startDate || !endDate) {
        alert('Выберите даты');
        return;
    }

    let services = await api('getServices');
    let payments = await api('getPayments');
    let bookings = await api('getBookings');
    let users = await api('getUsers');

    let start = new Date(startDate);
    start.setHours(0, 0, 0, 0);
    let end = new Date(endDate);
    end.setHours(23, 59, 59, 999);

    let filteredPayments = payments.filter(p => {
        if (p.status !== 'confirmed') return false;
        let date = new Date(p.date);
        return date >= start && date <= end;
    });

    let filteredBookings = bookings.filter(b => {
        if (b.status !== 'confirmed') return false;
        let date = new Date(b.date);
        return date >= start && date <= end;
    });

    let servicesStats = [];
    let totalIncome = 0;
    let totalCount = 0;

    for (let service of services) {
        let priceValue = parseInt(service.price.replace(/\D/g, '')) || 0;
        let count = 0;
        let total = 0;

        for (let payment of filteredPayments) {
            if (payment.comment && payment.comment.toLowerCase().includes(service.name.toLowerCase())) {
                count++;
                total += payment.amount;
            }
        }

        servicesStats.push({
            name: service.name,
            price: priceValue,
            count: count,
            total: total
        });

        totalIncome += total;
        totalCount += count;
    }

    let userStats = [];
    for (let user of users) {
        let userPayments = filteredPayments.filter(p => p.username === user.username);
        let userTotal = userPayments.reduce((sum, p) => sum + p.amount, 0);
        if (userTotal > 0) {
            userStats.push({
                username: user.username,
                total: userTotal,
                payments_count: userPayments.length
            });
        }
    }
    userStats.sort((a, b) => b.total - a.total);

    let nds = totalIncome * 0.2;
    let netIncome = totalIncome - nds;

    let startFormatted = new Date(startDate).toLocaleDateString('ru-RU');
    let endFormatted = new Date(endDate).toLocaleDateString('ru-RU');
    let daysCount = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;

    let reportHtml = `
        <div id="reportContent">
            <div class="report-header">
                <h2>ОТЧЁТ О ДОХОДАХ</h2>
                <p>Период: с ${startFormatted} по ${endFormatted} (${daysCount} дней)</p>
                <p style="font-size: 11px; color: #999;">Дата формирования: ${new Date().toLocaleString('ru-RU')}</p>
            </div>

            <div class="report-stats">
                <div class="stat-card">
                    <div class="stat-number">${totalCount}</div>
                    <div class="stat-label">Выполнено услуг</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${filteredBookings.length}</div>
                    <div class="stat-label">Консультаций</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${userStats.length}</div>
                    <div class="stat-label">Клиентов</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${totalIncome.toLocaleString()} ₽</div>
                    <div class="stat-label">Общий доход</div>
                </div>
            </div>

            <h3>Детализация по услугам</h3>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Услуга</th>
                        <th style="text-align: center;">Количество</th>
                        <th style="text-align: center;">Цена</th>
                        <th style="text-align: right;">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    ${servicesStats.filter(s => s.count > 0 || s.total > 0).map(s => `
                        <tr>
                            <td>${escapeHtml(s.name)}</td>
                            <td style="text-align: center;">${s.count}</td>
                            <td style="text-align: center;">${s.price.toLocaleString()} ₽</td>
                            <td style="text-align: right; font-weight: bold;">${s.total.toLocaleString()} ₽</td>
                        </tr>
                    `).join('') || '<tr><td colspan="4" style="text-align: center;">Нет данных</td></tr>'}
                </tbody>
                <tfoot>
                    <tr style="background: #f3f4f6; font-weight: bold;">
                        <td colspan="3">ИТОГО:</td>
                        <td style="text-align: right; color: #10b981;">${totalIncome.toLocaleString()} ₽</td>
                    </tr>
                </tfoot>
            </table>

            ${userStats.length > 0 ? `
                <h3>Клиенты</h3>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Клиент</th>
                            <th style="text-align: center;">Платежей</th>
                            <th style="text-align: right;">Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${userStats.map(u => `
                            <tr>
                                <td>${escapeHtml(u.username)}</td>
                                <td style="text-align: center;">${u.payments_count}</td>
                                <td style="text-align: right;">${u.total.toLocaleString()} ₽</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            ` : ''}

            <h3>Бухгалтерский расчёт</h3>
            <table class="report-table">
                <tr>
                    <td style="width: 50%; font-weight: bold;">Общий доход (брутто)</td>
                    <td style="text-align: right;">${totalIncome.toLocaleString()} ₽</td>
                </tr>
                <tr>
                    <td>НДС (20%)</td>
                    <td style="text-align: right;">${nds.toLocaleString()} ₽</td>
                </tr>
                <tr style="background: #f0fdf4;">
                    <td style="font-weight: bold;">Доход нетто</td>
                    <td style="text-align: right; font-weight: bold; color: #10b981;">${netIncome.toLocaleString()} ₽</td>
                </tr>
            </table>

            <div class="report-footer">
                <div>ИП Шмакова Д.А.</div>
                <div>ИНН: 1234567890</div>
                <div>${new Date().toLocaleDateString('ru-RU')}</div>
            </div>
        </div>
    `;

    document.getElementById('reportContainer').innerHTML = reportHtml;
}

function exportToPdf() {
    let reportContent = document.getElementById('reportContent');
    if (!reportContent) {
        alert('Сначала сформируйте отчёт');
        return;
    }

    let printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Отчёт</title>
            <meta charset="UTF-8">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: Arial, sans-serif; padding: 30px; }
                .report-header { text-align: center; margin-bottom: 30px; }
                .report-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px; }
                .stat-card { background: #f8fafc; padding: 15px; border-radius: 12px; text-align: center; }
                .stat-number { font-size: 28px; font-weight: bold; }
                table { width: 100%; border-collapse: collapse; margin: 15px 0; }
                th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
                th { background: #f5f5f5; }
                .report-footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; display: flex; justify-content: space-between; }
                @media print { body { padding: 0; } }
            </style>
        </head>
        <body>
            ${reportContent.outerHTML}
            <div style="text-align: center; margin-top: 20px;">
                <button onclick="window.print()" style="padding: 10px 30px; background: #4f46e5; color: white; border: none; border-radius: 8px;">Печать</button>
                <button onclick="window.close()" style="padding: 10px 30px; background: #6c757d; color: white; border: none; border-radius: 8px;">Закрыть</button>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
}

function printReport() {
    let reportContent = document.getElementById('reportContent');
    if (!reportContent) {
        alert('Сначала сформируйте отчёт');
        return;
    }

    let printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Печать</title>
            <meta charset="UTF-8">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: Arial, sans-serif; padding: 20px; }
                .report-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin: 20px 0; }
                .stat-card { background: #f8fafc; padding: 15px; border-radius: 12px; text-align: center; }
                .stat-number { font-size: 28px; font-weight: bold; }
                table { width: 100%; border-collapse: collapse; margin: 15px 0; }
                th, td { padding: 10px; border: 1px solid #ddd; }
                th { background: #f5f5f5; }
            </style>
        </head>
        <body>
            ${reportContent.outerHTML}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// ========== ЧАТЫ ==========

async function loadChats() {
    let res = await api('getAllChats');
    let container = document.getElementById('chatsList');
    if (!res || res.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--text-muted);">Нет чатов</div>';
        return;
    }
    container.innerHTML = res.map(chat => `
        <div class="chat-item ${chat.unread_admin > 0 ? 'chat-unread' : ''}" data-username="${escapeHtml(chat.username)}" data-chatid="${chat.chat_id}">
            <div><strong>${escapeHtml(chat.username)}</strong></div>
            <div style="font-size: 12px; color: var(--text-muted);">${chat.last_message_date?.substring(0, 16) || ''}</div>
            <div style="font-size: 13px; margin-top: 5px;">${escapeHtml(chat.last_message || 'Нет сообщений')}</div>
            ${chat.unread_admin > 0 ? `<span style="background: var(--error); display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 11px; margin-top: 5px;">${chat.unread_admin} новых</span>` : ''}
        </div>
    `).join('');

    document.querySelectorAll('.chat-item').forEach(el => {
        el.onclick = () => {
            let username = el.dataset.username;
            let chatId = el.dataset.chatid;
            openChat(username, chatId);
        };
    });
}

async function openChat(username, chatId) {
    currentChatUser = username;
    currentChatId = chatId;

    document.querySelectorAll('.chat-item').forEach(el => {
        el.style.background = '';
        if (el.dataset.username === username) {
            el.style.background = 'var(--accent-glow)';
        }
    });

    let res = await api('getChatMessages', 'GET', null, `&chat_id=${chatId}`);
    let mainArea = document.getElementById('chatMainArea');

    if (res && res.success) {
        let messages = res.messages || [];
        mainArea.innerHTML = `
            <h3 style="margin-top: 0;">Чат с ${escapeHtml(username)}</h3>
            <div class="chat-messages-area" id="chatMsgsArea">
                ${messages.length === 0 ? '<div style="text-align: center; padding: 40px;">Нет сообщений</div>' : messages.map(msg => `
                    <div class="chat-message ${msg.from}">
                        <div class="sender">${msg.from === 'admin' ? 'Администратор' : escapeHtml(msg.username)}</div>
                        <div class="text">${escapeHtml(msg.message)}</div>
                        <div class="time">${msg.date}</div>
                    </div>
                `).join('')}
            </div>
            <div class="chat-input-area">
                <input type="text" id="chatInput" placeholder="Введите ответ...">
                <button id="sendChatBtn">Отправить</button>
            </div>
        `;

        let msgsArea = document.getElementById('chatMsgsArea');
        if (msgsArea) msgsArea.scrollTop = msgsArea.scrollHeight;

        document.getElementById('sendChatBtn').onclick = async () => {
            let input = document.getElementById('chatInput');
            let message = input.value.trim();
            if (!message) return;

            let btn = document.getElementById('sendChatBtn');
            btn.disabled = true;
            btn.textContent = 'Отправка...';

            let res2 = await api('adminSendMessage', 'POST', { chat_id: chatId, message });
            if (res2 && res2.success) {
                input.value = '';
                openChat(username, chatId);
                loadChats();
            } else {
                alert('Ошибка отправки');
            }
            btn.disabled = false;
            btn.textContent = 'Отправить';
        };

        document.getElementById('chatInput').onkeypress = (e) => {
            if (e.key === 'Enter') {
                document.getElementById('sendChatBtn').click();
            }
        };
    } else {
        mainArea.innerHTML = '<div style="text-align: center; padding: 60px; color: var(--text-muted);">Ошибка загрузки чата</div>';
    }
}

function startChatsPolling() {
    if (chatsInterval) clearInterval(chatsInterval);
    chatsInterval = setInterval(() => {
        loadChats();
        if (currentChatUser) {
            api('getChatMessages', 'GET', null, `&chat_id=${currentChatId}`).then(res => {
                if (res && res.success) {
                    let messages = res.messages || [];
                    let msgsArea = document.getElementById('chatMsgsArea');
                    if (msgsArea) {
                        let wasBottom = msgsArea.scrollHeight - msgsArea.scrollTop - msgsArea.clientHeight < 100;
                        msgsArea.innerHTML = messages.length === 0 ? '<div style="text-align: center; padding: 40px;">Нет сообщений</div>' : messages.map(msg => `
                            <div class="chat-message ${msg.from}">
                                <div class="sender">${msg.from === 'admin' ? 'Администратор' : escapeHtml(msg.username)}</div>
                                <div class="text">${escapeHtml(msg.message)}</div>
                                <div class="time">${msg.date}</div>
                            </div>
                        `).join('');
                        if (wasBottom) msgsArea.scrollTop = msgsArea.scrollHeight;
                    }
                }
            });
        }
    }, 3000);
}

// ========== СООБЩЕНИЯ ==========

async function loadMessages() {
    let res = await api('getAllUserMessages');
    let container = document.getElementById('messagesList');
    if (!res || res.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--text-muted);">Нет сообщений</div>';
        return;
    }
    container.innerHTML = res.map(user => `
        <div style="background: var(--bg-primary); border-radius: 16px; margin-bottom: 20px; padding: 16px;">
            <h3 style="margin-bottom: 15px;">${escapeHtml(user.name || user.username)}</h3>
            ${user.messages.map(msg => `
                <div style="background: white; border-radius: 12px; padding: 16px; margin-bottom: 12px; border-left: 4px solid ${msg.status === 'pending' ? '#f59e0b' : (msg.status === 'answered' ? '#10b981' : '#dc2626')}">
                    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; margin-bottom: 10px;">
                        <small style="color: #999;">${msg.date}</small>
                        <span class="booking-status status-${msg.status === 'pending' ? 'pending' : (msg.status === 'answered' ? 'confirmed' : 'cancelled')}">
                            ${msg.status === 'pending' ? 'Ожидает' : (msg.status === 'answered' ? 'Отвечено' : 'Отклонено')}
                        </span>
                    </div>
                    <div style="margin-bottom: 10px;">${escapeHtml(msg.message)}</div>
                    ${msg.admin_reply ? `<div style="background: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: 10px; margin-top: 10px;"><strong>Ответ:</strong><br>${escapeHtml(msg.admin_reply)}<br><small>${msg.admin_reply_date || ''}</small></div>` : ''}
                    ${msg.reject_reason ? `<div style="background: rgba(220, 38, 38, 0.1); padding: 12px; border-radius: 10px; margin-top: 10px;"><strong>Причина:</strong><br>${escapeHtml(msg.reject_reason)}</div>` : ''}
                    ${msg.status === 'pending' ? `
                        <div style="margin-top: 12px;">
                            <button class="reply-btn" onclick="openReplyModal('${msg.id}', '${escapeHtml(user.username || user.name)}')">Ответить</button>
                            <button class="danger" onclick="rejectMessage('${msg.id}')">Отклонить</button>
                        </div>
                    ` : ''}
                </div>
            `).join('')}
        </div>
    `).join('');
}

function openReplyModal(messageId, username) {
    currentMessageId = messageId;
    document.getElementById('replyToUser').value = username;
    document.getElementById('replyMessageText').value = '';
    document.getElementById('replyModal').style.display = 'flex';
}

function closeReplyModal() {
    document.getElementById('replyModal').style.display = 'none';
}

async function sendReply() {
    let reply = document.getElementById('replyMessageText').value.trim();
    if (!reply) return alert('Введите ответ');
    await api('replyToUserMessage', 'POST', { message_id: currentMessageId, reply, action_type: 'reply' });
    alert('Ответ отправлен');
    closeReplyModal();
    loadMessages();
}

async function rejectMessage(messageId) {
    let reason = prompt('Причина отклонения:');
    if (reason) {
        await api('replyToUserMessage', 'POST', { message_id: messageId, reply: reason, action_type: 'reject' });
        loadMessages();
    }
}

// ========== ПРОЕКТЫ ==========

async function loadProjects() {
    let res = await api('getProjects');
    let container = document.getElementById('projectsList');
    if (!res || res.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--text-muted);">Нет проектов</div>';
        return;
    }
    container.innerHTML = res.map(p => `
        <div class="item">
            <div class="item-info">
                <div class="item-title">${escapeHtml(p.title)}</div>
                <div class="item-desc">${p.role || ''} | ${(p.tech || []).join(', ')}</div>
            </div>
            <div class="item-actions">
                <button class="edit-btn" onclick="openEditProject(${p.id})">Ред</button>
                <button class="danger" onclick="deleteProject(${p.id})">Дел</button>
            </div>
        </div>
    `).join('');
}

async function addProject() {
    let title = document.getElementById('projTitle').value;
    if (!title) return alert('Введите название');
    let role = document.getElementById('projRole').value;
    let tech = document.getElementById('projTech').value.split(',').map(t => t.trim());
    let tags = document.getElementById('projTags').value.split(',').map(t => t.trim());
    let image = document.getElementById('projImage').value;
    let file = document.getElementById('projImageFile').files[0];
    if (file) {
        let uploaded = await uploadProjectImage(file);
        if (uploaded) image = uploaded;
    }
    await api('addProject', 'POST', { title, role, tech, tags, image });
    alert('Добавлено');
    document.getElementById('projTitle').value = '';
    document.getElementById('projRole').value = '';
    document.getElementById('projTech').value = '';
    document.getElementById('projTags').value = '';
    document.getElementById('projImage').value = '';
    document.getElementById('projImageFile').value = '';
    loadProjects();
}

async function deleteProject(id) {
    if (confirm('Удалить?')) {
        await api('deleteProject', 'POST', { id });
        loadProjects();
    }
}

function openEditProject(id) {
    api('getProjects').then(res => {
        let p = res.find(p => p.id == id);
        if (!p) return;
        currentEditType = 'project';
        currentEditId = id;
        document.getElementById('editModalTitle').innerHTML = 'Редактировать проект';
        document.getElementById('editModalFields').innerHTML = `
            <input type="text" id="editTitle" value="${escapeHtml(p.title)}">
            <input type="text" id="editRole" value="${escapeHtml(p.role || '')}">
            <input type="text" id="editTech" value="${(p.tech || []).join(', ')}">
            <input type="text" id="editTags" value="${(p.tags || []).join(', ')}">
            <input type="text" id="editImage" value="${escapeHtml(p.image || '')}">
            <input type="file" id="editImageFile" accept="image/*">
        `;
        document.getElementById('editModal').style.display = 'flex';
    });
}

// ========== БЛОГ ==========

async function loadBlog() {
    let res = await api('getBlog');
    let container = document.getElementById('blogList');
    if (!res || res.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--text-muted);">Нет статей</div>';
        return;
    }
    container.innerHTML = res.map(b => `
        <div class="item">
            <div class="item-info">
                <div class="item-title">${escapeHtml(b.title)}</div>
                <div class="item-desc">${b.date || ''}</div>
            </div>
            <div class="item-actions">
                <button class="edit-btn" onclick="openEditBlog(${b.id})">Ред</button>
                <button class="danger" onclick="deleteBlog(${b.id})">Дел</button>
            </div>
        </div>
    `).join('');
}

async function addBlog() {
    let title = document.getElementById('blogTitle').value;
    let content = document.getElementById('blogContent').value;
    if (!title || !content) return alert('Заполните поля');
    let image = document.getElementById('blogImage').value;
    let file = document.getElementById('blogImageFile').files[0];
    if (file) {
        let uploaded = await uploadBlogImage(file);
        if (uploaded) image = uploaded;
    }
    await api('addBlog', 'POST', { title, content, image });
    alert('Добавлено');
    document.getElementById('blogTitle').value = '';
    document.getElementById('blogContent').value = '';
    document.getElementById('blogImage').value = '';
    document.getElementById('blogImageFile').value = '';
    loadBlog();
}

async function deleteBlog(id) {
    if (confirm('Удалить?')) {
        await api('deleteBlog', 'POST', { id });
        loadBlog();
    }
}

function openEditBlog(id) {
    api('getBlog').then(res => {
        let b = res.find(b => b.id == id);
        if (!b) return;
        currentEditType = 'blog';
        currentEditId = id;
        document.getElementById('editModalTitle').innerHTML = 'Редактировать статью';
        document.getElementById('editModalFields').innerHTML = `
            <input type="text" id="editTitle" value="${escapeHtml(b.title)}">
            <textarea id="editContent" rows="5">${escapeHtml(b.content)}</textarea>
            <input type="text" id="editImage" value="${escapeHtml(b.image || '')}">
            <input type="file" id="editImageFile" accept="image/*">
        `;
        document.getElementById('editModal').style.display = 'flex';
    });
}

// ========== УСЛУГИ ==========

async function loadServices() {
    let res = await api('getServices');
    let container = document.getElementById('servicesList');
    if (!res || res.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--text-muted);">Нет услуг</div>';
        return;
    }
    container.innerHTML = res.map(s => `
        <div class="item">
            <div class="item-info">
                <div class="item-title">${escapeHtml(s.name)}</div>
                <div class="item-desc">${s.price} - ${s.desc}</div>
            </div>
            <div class="item-actions">
                <button class="edit-btn" onclick="openEditService(${s.id})">Ред</button>
                <button class="danger" onclick="deleteService(${s.id})">Дел</button>
            </div>
        </div>
    `).join('');
}

async function addService() {
    let name = document.getElementById('servName').value;
    if (!name) return alert('Введите название');
    await api('addService', 'POST', {
        name: name,
        price: document.getElementById('servPrice').value,
        desc: document.getElementById('servDesc').value
    });
    alert('Добавлено');
    document.getElementById('servName').value = '';
    document.getElementById('servPrice').value = '';
    document.getElementById('servDesc').value = '';
    loadServices();
}

async function deleteService(id) {
    if (confirm('Удалить?')) {
        await api('deleteService', 'POST', { id });
        loadServices();
    }
}

function openEditService(id) {
    api('getServices').then(res => {
        let s = res.find(s => s.id == id);
        if (!s) return;
        currentEditType = 'service';
        currentEditId = id;
        document.getElementById('editModalTitle').innerHTML = 'Редактировать услугу';
        document.getElementById('editModalFields').innerHTML = `
            <input type="text" id="editName" value="${escapeHtml(s.name)}">
            <input type="text" id="editPrice" value="${escapeHtml(s.price)}">
            <textarea id="editDesc" rows="4">${escapeHtml(s.desc)}</textarea>
        `;
        document.getElementById('editModal').style.display = 'flex';
    });
}

// ========== ОБЩЕЕ РЕДАКТИРОВАНИЕ ==========

async function saveEdit() {
    if (currentEditType === 'project') {
        let image = document.getElementById('editImage').value;
        let file = document.getElementById('editImageFile').files[0];
        if (file) {
            let uploaded = await uploadProjectImage(file);
            if (uploaded) image = uploaded;
        }
        await api('updateProject', 'POST', {
            id: currentEditId,
            title: document.getElementById('editTitle').value,
            role: document.getElementById('editRole').value,
            tech: document.getElementById('editTech').value.split(',').map(t => t.trim()),
            tags: document.getElementById('editTags').value.split(',').map(t => t.trim()),
            image: image
        });
    } else if (currentEditType === 'blog') {
        let image = document.getElementById('editImage').value;
        let file = document.getElementById('editImageFile').files[0];
        if (file) {
            let uploaded = await uploadBlogImage(file);
            if (uploaded) image = uploaded;
        }
        await api('updateBlog', 'POST', {
            id: currentEditId,
            title: document.getElementById('editTitle').value,
            content: document.getElementById('editContent').value,
            image: image
        });
    } else if (currentEditType === 'service') {
        await api('updateService', 'POST', {
            id: currentEditId,
            name: document.getElementById('editName').value,
            price: document.getElementById('editPrice').value,
            desc: document.getElementById('editDesc').value
        });
    }
    alert('Сохранено');
    closeEditModal();
    loadProjects();
    loadBlog();
    loadServices();
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    currentEditType = null;
    currentEditId = null;
}

// ========== ПЛАТЕЖИ ==========

async function loadPayments() {
    let res = await api('getPayments');
    let container = document.getElementById('paymentsList');
    if (!res || res.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--text-muted);">Нет заявок</div>';
        return;
    }
    container.innerHTML = res.map(p => `
        <div class="item">
            <div class="item-info">
                <strong>${escapeHtml(p.username)}</strong> - ${p.amount} ₽<br>
                <small>${p.date}</small><br>
                ${escapeHtml(p.comment)}
            </div>
            <div class="item-actions">
                ${p.status === 'pending' ? `
                    <button class="success" onclick="confirmPayment(${p.id})">Подтвердить</button>
                    <button class="danger" onclick="rejectPayment(${p.id})">Отклонить</button>
                ` : `<span class="booking-status status-${p.status === 'confirmed' ? 'confirmed' : 'cancelled'}">${p.status === 'confirmed' ? 'Подтверждено' : 'Отклонено'}</span>`}
            </div>
        </div>
    `).join('');
}

async function confirmPayment(id) {
    await api('confirmPayment', 'POST', { id });
    loadPayments();
    generateReport();
}

async function rejectPayment(id) {
    if (confirm('Отклонить?')) {
        await api('rejectPayment', 'POST', { id });
        loadPayments();
    }
}

// ========== КОНСУЛЬТАЦИИ ==========

async function loadBookings() {
    let res = await api('getBookings');
    let container = document.getElementById('bookingsList');
    if (!res || res.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--text-muted);">Нет записей</div>';
        return;
    }
    container.innerHTML = res.map(b => `
        <div class="item">
            <div class="item-info">
                <strong>${escapeHtml(b.name)}</strong> [${escapeHtml(b.username)}]<br>
                ${b.date} ${b.time}<br>
                ${b.phone || 'не указан'}<br>
                ${b.message || '-'}
                ${b.reject_reason ? `<div style="color: var(--error); margin-top: 5px;">Причина: ${escapeHtml(b.reject_reason)}</div>` : ''}
            </div>
            <div class="item-actions">
                <span class="booking-status status-${b.status}">${b.status === 'pending' ? 'Ожидает' : (b.status === 'confirmed' ? 'Подтверждено' : 'Отклонено')}</span>
                ${b.status === 'pending' ? `
                    <button class="success" onclick="confirmBooking(${b.id})">Принять</button>
                    <button class="danger" onclick="rejectBooking(${b.id})">Отклонить</button>
                ` : ''}
                <button class="danger" onclick="deleteBooking(${b.id})">Удалить</button>
            </div>
        </div>
    `).join('');
}

async function confirmBooking(id) {
    await api('updateBooking', 'POST', { id, status: 'confirmed' });
    loadBookings();
    generateReport();
}

async function rejectBooking(id) {
    let reason = prompt('Причина:');
    if (reason) {
        await api('updateBooking', 'POST', { id, status: 'cancelled', reason });
        loadBookings();
    }
}

async function deleteBooking(id) {
    if (confirm('Удалить?')) {
        await api('deleteBooking', 'POST', { id });
        loadBookings();
    }
}

// ========== ПОЛЬЗОВАТЕЛИ ==========

async function loadUsers() {
    let res = await api('getUsers');
    let container = document.getElementById('usersList');
    if (!res || res.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--text-muted);">Нет пользователей</div>';
        return;
    }
    container.innerHTML = res.map(u => `
        <div class="item">
            <div class="item-info">
                <strong>${escapeHtml(u.username)}</strong><br>
                ${u.role} - Баланс: ${u.balance} ₽
            </div>
            <div class="item-actions">
                <button class="danger" onclick="deleteUser('${escapeHtml(u.username)}')">Удалить</button>
            </div>
        </div>
    `).join('');
}

async function addUser() {
    let username = document.getElementById('newUsername').value;
    let password = document.getElementById('newPassword').value;
    let role = document.getElementById('newRole').value;
    if (!username || !password) return alert('Заполните поля');
    await api('addUser', 'POST', { username, password, role });
    alert('Добавлен');
    document.getElementById('newUsername').value = '';
    document.getElementById('newPassword').value = '';
    loadUsers();
}

async function addBalance() {
    let username = document.getElementById('balanceUsername').value;
    let amount = document.getElementById('balanceAmount').value;
    if (!username || !amount) return alert('Заполните поля');
    await api('addBalance', 'POST', { username, amount });
    alert('Баланс пополнен');
    document.getElementById('balanceUsername').value = '';
    document.getElementById('balanceAmount').value = '';
    loadUsers();
}

async function deleteUser(username) {
    if (confirm('Удалить?')) {
        await api('deleteUser', 'POST', { username });
        loadUsers();
    }
}

// ========== ПРОФИЛЬ САЙТА ==========

async function loadProfile() {
    let profile = await api('getProfile');
    document.getElementById('profileName').value = profile.name || '';
    document.getElementById('profileAbout').value = profile.about || '';
    let avatarDiv = document.getElementById('avatarPreview');
    if (profile.avatar) {
        let path = profile.avatar.startsWith('http') ? profile.avatar : '../' + profile.avatar;
        avatarDiv.innerHTML = `<img class="avatar-preview" src="${path}" onerror="this.src='https://ui-avatars.com/api/?background=4f46e5&color=fff&bold=true&size=100&name=Site'">`;
    } else {
        avatarDiv.innerHTML = '<div style="color: var(--text-muted); padding: 20px;">Нет аватарки</div>';
    }
}

async function saveProfile() {
    let name = document.getElementById('profileName').value;
    let about = document.getElementById('profileAbout').value;
    let file = document.getElementById('avatarFile').files[0];
    let data = { name, about };
    if (file) {
        let url = await uploadAvatar(file);
        if (url) data.avatar = url;
    }
    await api('updateProfile', 'POST', data);
    alert('Сохранено');
    loadProfile();
}

// ========== ПЕРЕКЛЮЧЕНИЕ ВКЛАДОК ==========

document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.onclick = () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        let tab = btn.dataset.tab;
        document.getElementById(`tab-${tab}`).classList.add('active');

        if (tab === 'reports') generateReport();
        if (tab === 'chats') { loadChats(); startChatsPolling(); }
        if (tab === 'messages') loadMessages();
        if (tab === 'projects') loadProjects();
        if (tab === 'blog') loadBlog();
        if (tab === 'services') loadServices();
        if (tab === 'payments') loadPayments();
        if (tab === 'bookings') loadBookings();
        if (tab === 'users') loadUsers();
        if (tab === 'profile') loadProfile();
    };
});

// ========== ЗАПУСК ==========
setDefaultDates();
document.getElementById('applyReportBtn').onclick = generateReport;
document.getElementById('exportPdfBtn').onclick = exportToPdf;
document.getElementById('printReportBtn').onclick = printReport;

generateReport();
loadMessages();
loadProjects();
loadBlog();
loadServices();
loadPayments();
loadBookings();
loadUsers();
loadProfile();
loadChats();
startChatsPolling();
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - مسجد الخانقية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
            color: white;
        }

        .logo i {
            margin-left: 0.75rem;
            font-size: 2.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .login-form {
            padding: 2rem;
        }

        .page-title {
            position: relative;
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%);
            width: 50px;
            height: 4px;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4a5568;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .alert {
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            display: none;
        }

        .alert-error {
            background: #fed7d7;
            color: #c53030;
            border-left: 4px solid #f56565;
        }

        .alert-success {
            background: #c6f6d5;
            color: #276749;
            border-left: 4px solid #48bb78;
        }

        .text-gradient {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .delayed-1 { animation-delay: 0.1s; }
        .delayed-2 { animation-delay: 0.2s; }
        .delayed-3 { animation-delay: 0.3s; }
        .delayed-4 { animation-delay: 0.4s; }
        .delayed-5 { animation-delay: 0.5s; }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #4f46e5;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <i class="fas fa-mosque"></i>
                <h1 class="text-2xl font-bold">مسجد الخانقية</h1>
            </div>

            <div class="login-form">
                <h2 class="page-title text-2xl font-bold text-gray-800">تسجيل الدخول</h2>

                <div id="alertMessage" class="alert"></div>

                <form id="loginForm">
                    <div class="form-group delayed-1">
                        <label for="phone_number" class="form-label">رقم الهاتف</label>
                        <input type="tel" id="phone_number" name="phone_number" class="form-input" placeholder="أدخل رقم هاتفك" required>
                    </div>

                    <div class="form-group delayed-2">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="أدخل كلمة المرور" required>
                    </div>

                    <button type="submit" class="btn delayed-3">تسجيل الدخول</button>
                </form>

                <div class="forgot-password delayed-4">
                    <a href="/forgot-password">نسيت كلمة المرور؟</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const alertMessage = document.getElementById('alertMessage');

            // دالة لعرض الرسائل
            function showAlert(message, type) {
                alertMessage.textContent = message;
                alertMessage.className = 'alert';
                alertMessage.classList.add(type === 'success' ? 'alert-success' : 'alert-error');
                alertMessage.style.display = 'block';

                // إخفاء الرسالة بعد 5 ثواني
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 5000);
            }

            // معالجة تسجيل الدخول
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const phoneNumber = document.getElementById('phone_number').value;
                const password = document.getElementById('password').value;

                // التحقق من إدخال جميع الحقول
                if (!phoneNumber || !password) {
                    showAlert('يرجى إدخال جميع الحقول المطلوبة', 'error');
                    return;
                }

                try {
                    // إرسال طلب تسجيل الدخول
                const response = await fetch('/api/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        phone_number: phoneNumber,
        password: password
    })
});

                    const data = await response.json();

                    if (data.success) {
                        showAlert('تم تسجيل الدخول بنجاح!', 'success');

                        // حفظ التوكن في التخزين المحلي
                        localStorage.setItem('adminToken', data.token);
                        localStorage.setItem('adminUser', JSON.stringify(data.user));

                        // إعادة التوجيه إلى واجهة layouts بعد تأخير قصير
                        setTimeout(() => {
                            window.location.href = '/dashboard/layouts';
                        }, 1000);
                    } else {
                        showAlert(data.message || 'حدث خطأ أثناء تسجيل الدخول', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('حدث خطأ في الاتصال بالخادم', 'error');
                }
            });

            // التحقق مما إذا كان المستخدم مسجلاً دخوله بالفعل
            // const token = localStorage.getItem('adminToken');
            // if (token) {
            //     // إذا كان مسجلاً دخوله، إعادة التوجيه إلى واجهة layouts
            //     window.location.href = '/layouts';
            // }
        });
    </script>
</body>
</html>

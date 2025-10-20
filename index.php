<?php
session_start();
$pageTitle = 'Login Admin';
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .tab-active {
            background-color: rgba(59, 130, 246, 0.1);
            border-bottom: 3px solid #3b82f6;
            color: #3b82f6;
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        .logo-section {
            background: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
        }
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .mobile-menu.active {
            max-height: 200px;
        }
        @media (max-width: 768px) {
            .desktop-logo {
                display: none;
            }
        }
        @media (min-width: 769px) {
            .mobile-header {
                display: none;
            }
            .mobile-info {
                display: none;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Mobile Header -->
    <div class="mobile-header bg-white shadow-md md:hidden">
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
                <i class="fas fa-chart-line text-2xl text-blue-600 mr-2"></i>
                <h1 class="text-xl font-bold text-gray-800">PageManager</h1>
            </div>
            <button id="mobile-menu-btn" class="text-gray-600 hover:text-blue-600 transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        
        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="mobile-menu bg-white border-t">
            <div class="px-4 py-2">
                <button id="mobile-login-tab" class="w-full text-left py-2 px-3 rounded hover:bg-blue-50 transition-colors">
                    <i class="fas fa-sign-in-alt mr-2 text-blue-500"></i>Login
                </button>
                <button id="mobile-register-tab" class="w-full text-left py-2 px-3 rounded hover:bg-blue-50 transition-colors">
                    <i class="fas fa-user-plus mr-2 text-green-500"></i>Cadastro
                </button>
                <button id="mobile-recovery-tab" class="w-full text-left py-2 px-3 rounded hover:bg-blue-50 transition-colors">
                    <i class="fas fa-key mr-2 text-red-500"></i>Recuperação
                </button>
            </div>
        </div>
    </div>

    <div class="flex min-h-screen">
        <!-- Left Side - Logo and Welcome Message (Desktop) -->
        <div class="desktop-logo hidden md:flex md:w-1/2 logo-section text-white p-8 lg:p-12 flex-col justify-center">
            <div class="max-w-lg mx-auto text-center">
                <div class="mb-8">
                    <i class="fas fa-chart-line text-5xl mb-4 opacity-90"></i>
                    <h1 class="text-3xl lg:text-3xl font-bold mb-2">SmarttBotz - PG</h1>
                    <p class="text-xl lg:text-2xl text-blue-100">PageManager - Sistema de Gerenciamento</p>
                </div>
                
                <div class="space-y-4 text-center">
                    <h2 class="text-2xl font-semibold mb-4">Bem-vindo ao nosso sistema!</h2>
                    <div class="space-y-3 text-center">
                        <div class="flex items-start">
                            <i class="fas fa-facebook text-blue-300 mr-3 mt-1"></i>
                            <p class="text-blue-100 text-center">Gerencie suas páginas do Facebook de forma eficiente e organizada</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-users text-blue-300 mr-3 mt-1"></i>
                            <p class="text-blue-100 text-center">Controle completo de contas e permissões de usuários</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-chart-bar text-blue-300 mr-3 mt-1"></i>
                            <p class="text-blue-100 text-center">Crie campanhas de automação para postagem</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-shield-alt text-blue-300 mr-3 mt-1"></i>
                            <p class="text-blue-100 text-center">Segurança avançada com criptografia de dados</p>
                        </div>
                    </div>
                </div>
            </div>
						<footer class="mt-12 text-sm text-center text-gray-300">
      <p>© <?= date('Y') ?> - SmarttBotz PageManager - Desenvolvido por 4Tags - ME | CNPJ: 22.174.325.0001/23</p>
      <p>Rua dos Guajajaras, 40. 2º andar. Centro - Belo Horizonte/MG</p>
    </footer>
        </div>

        <!-- Right Side - Forms (Desktop) / Full Width (Mobile) -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 md:p-8">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-xl overflow-hidden card-shadow">
                    <!-- Tab Navigation (Desktop) -->
                    <div class="hidden md:flex border-b border-gray-200">
                        <button id="login-tab" class="flex-1 py-4 px-6 text-center font-medium text-gray-700 tab-active transition-all">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </button>
                        <button id="register-tab" class="flex-1 py-4 px-6 text-center font-medium text-gray-700 hover:bg-gray-50 transition-all">
                            <i class="fas fa-user-plus mr-2"></i>Cadastro
                        </button>
                        <button id="recovery-tab" class="flex-1 py-4 px-6 text-center font-medium text-gray-700 hover:bg-gray-50 transition-all">
                            <i class="fa-solid fa-key mr-2"></i>Ajuda
                        </button>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Login Form -->
                        <div id="login-form" class="space-y-4">
                            <div class="text-center">
                                <h2 class="text-2xl font-bold text-gray-800">
                                    <i class="fas fa-user-shield mr-2 text-blue-500"></i>Login
                                </h2>
                                <p class="text-gray-500 mt-1">Acesse sua conta</p>
                            </div>

                            <div id="adminAlert" class="hidden"></div>

                            <form id="adminForm" class="space-y-4">
                                <div>
                                    <label for="adminEmail" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
                                    </label>
                                    <input type="email" id="adminEmail" required 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 input-focus transition-all"
                                           placeholder="admin@exemplo.com">
                                </div>

                                <div>
                                    <label for="adminPassword" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-lock mr-2 text-blue-500"></i>Senha
                                    </label>
                                    <input type="password" id="adminPassword" required 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 input-focus transition-all"
                                           placeholder="Sua senha">
                                </div>

                                <!-- LGPD Compliance -->
                                <div class="text-xs text-gray-600 space-y-2">
                                    <div class="flex items-start">
                                        <input type="checkbox" id="loginTerms" required class="mt-1 mr-2">
                                        <label for="loginTerms">
                                            Concordo com os <a href="/termos_uso.php" class="text-blue-600 hover:underline">Termos de Uso</a> e 
                                            <a href="/politica_privacidade.php" class="text-blue-600 hover:underline">Política de Privacidade</a>
                                        </label>
                                    </div>
                                    <div class="flex items-start">
                                        <input type="checkbox" id="loginLgpd" required class="mt-1 mr-2">
                                        <label for="loginLgpd">
                                            Autorizo o tratamento dos meus dados pessoais conforme a LGPD
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" id="adminLoginBtn" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Entrar
                                </button>
                            </form>
                        </div>
                        
                        <!-- Register Form (Hidden by default) -->
                        <div id="register-form" class="space-y-4 hidden">
                            <div class="text-center">
                                <h2 class="text-2xl font-bold text-gray-800">
                                    <i class="fas fa-user-plus mr-2 text-green-500"></i>Cadastro
                                </h2>
                                <p class="text-gray-500 mt-1">Cadastre-se e tenha <strong>Acesso gratis por 7 Dias!</strong></p>
                            </div>

                            <div id="registerAlert" class="hidden"></div>

                            <form id="registerForm" class="space-y-4">
                                <div>
                                    <label for="registerName" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-user mr-2 text-green-500"></i>Nome completo
                                    </label>
                                    <input type="text" id="registerName" required 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 input-focus transition-all"
                                           placeholder="Seu nome">
                                </div>

                                <div>
                                    <label for="registerEmail" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-envelope mr-2 text-green-500"></i>Email
                                    </label>
                                    <input type="email" id="registerEmail" required 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 input-focus transition-all"
                                           placeholder="seu@email.com">
                                </div>

                                <div>
                                    <label for="registerPassword" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-lock mr-2 text-green-500"></i>Senha
                                    </label>
                                    <input type="password" id="registerPassword" required 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 input-focus transition-all"
                                           placeholder="Sua senha">
                                </div>
                                
                                <div>
                                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-lock mr-2 text-green-500"></i>Confirmar Senha
                                    </label>
                                    <input type="password" id="confirmPassword" required 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 input-focus transition-all"
                                           placeholder="Repita sua senha">
                                </div>

                                <!-- LGPD Compliance -->
                                <div class="text-xs text-gray-600 space-y-2">
                                    <div class="flex items-start">
                                        <input type="checkbox" id="registerTerms" required class="mt-1 mr-2">
                                        <label for="registerTerms">
                                            Concordo com os <a href="/termos_uso.php" class="text-blue-600 hover:underline">Termos de Uso</a> e 
                                            <a href="/politica_privacidade.php" class="text-blue-600 hover:underline">Política de Privacidade</a>
                                        </label>
                                    </div>
                                    <div class="flex items-start">
                                        <input type="checkbox" id="registerLgpd" required class="mt-1 mr-2">
                                        <label for="registerLgpd">
                                            Autorizo o tratamento dos meus dados pessoais conforme a LGPD
                                        </label>
                                    </div>
                                    <div class="flex items-start">
                                        <input type="checkbox" id="registerMarketing" class="mt-1 mr-2">
                                        <label for="registerMarketing">
                                            Desejo receber comunicações de marketing (opcional)
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" id="registerAdminBtn" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all flex items-center justify-center">
                                    <i class="fas fa-user-plus mr-2"></i>Cadastrar
                                </button>
                            </form>
                        </div>
                    
                        <!-- Recovery Form -->
                        <div id="recovery-form" class="space-y-4 hidden">
                            <div class="text-center">
                                <h2 class="text-2xl font-bold text-gray-800">
                                    <i class="fa-solid fa-key mr-2 text-red-500"></i>Recuperação
                                </h2>
                                <p class="text-gray-500 mt-1">Recupere sua conta</p>
                            </div>

                            <div id="recoveryAlert" class="space-y-4"></div>

                            <form id="recoveryForm" class="space-y-4">
                                <div>
                                    <label for="recoveryEmail" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-envelope mr-2 text-red-500"></i>Email
                                    </label>
                                    <input type="email" id="recoveryEmail" required 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 input-focus transition-all"
                                           placeholder="admin@exemplo.com">
                                </div>

                                <div class="text-xs text-gray-600">
                                    <p>Ao solicitar a recuperação, você concorda com o processamento dos seus dados para fins de autenticação.</p>
                                </div>

                                <button type="submit" id="recoveryAdminBtn"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-all flex items-center justify-center">
                                    <i class="fas fa-paper-plane mr-2"></i>Recuperar Senha
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Mobile Info Section -->
    <div class="mobile-info md:hidden bg-white p-6 border-t">
        <div class="text-center mb-6">
            <i class="fas fa-chart-line text-4xl text-blue-600 mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">PageManager</h2>
            <p class="text-gray-600">Sistema de Gerenciamento Completo</p>
        </div>
        
        <div class="space-y-3">
            <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                <i class="fas fa-facebook text-blue-600 mr-3"></i>
                <p class="text-sm text-gray-700">Gerencie páginas do Facebook</p>
            </div>
            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                <i class="fas fa-users text-green-600 mr-3"></i>
                <p class="text-sm text-gray-700">Controle de contas e usuários</p>
            </div>
            <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                <i class="fas fa-chart-bar text-purple-600 mr-3"></i>
                <p class="text-sm text-gray-700">Análises e relatórios</p>
            </div>
            <div class="flex items-center p-3 bg-red-50 rounded-lg">
                <i class="fas fa-shield-alt text-red-600 mr-3"></i>
                <p class="text-sm text-gray-700">Segurança avançada</p>
            </div>
        </div>
    </div>
	

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.0/axios.min.js"></script>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');
            const recoveryTab = document.getElementById('recovery-tab');
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const recoveryForm = document.getElementById('recovery-form');

            // Mobile tabs
            const mobileLoginTab = document.getElementById('mobile-login-tab');
            const mobileRegisterTab = document.getElementById('mobile-register-tab');
            const mobileRecoveryTab = document.getElementById('mobile-recovery-tab');

            function showForm(formToShow) {
                // Hide all forms
                loginForm.classList.add('hidden');
                registerForm.classList.add('hidden');
                recoveryForm.classList.add('hidden');
                
                // Show selected form
                formToShow.classList.remove('hidden');
                
                // Update desktop tabs
                if (loginTab) {
                    loginTab.classList.remove('tab-active');
                    registerTab.classList.remove('tab-active');
                    recoveryTab.classList.remove('tab-active');
                }
                
                // Close mobile menu
                if (mobileMenu) {
                    mobileMenu.classList.remove('active');
                    const icon = mobileMenuBtn.querySelector('i');
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-times');
                }
            }

            // Desktop tab events
            if (loginTab) {
                loginTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.add('tab-active');
                    showForm(loginForm);
                });

                registerTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.add('tab-active');
                    showForm(registerForm);
                });

                recoveryTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.add('tab-active');
                    showForm(recoveryForm);
                });
            }

            // Mobile tab events
            if (mobileLoginTab) {
                mobileLoginTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (loginTab) loginTab.classList.add('tab-active');
                    showForm(loginForm);
                });

                mobileRegisterTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (registerTab) registerTab.classList.add('tab-active');
                    showForm(registerForm);
                });

                mobileRecoveryTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (recoveryTab) recoveryTab.classList.add('tab-active');
                    showForm(recoveryForm);
                });
            }
        });

        // Form submission handlers (keeping your original logic)
        document.getElementById('adminForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            const inputs = this.querySelectorAll('[id]');
            const dataObject = {};

            for (const input of inputs) {
                if (input.type === 'checkbox') {
                    dataObject[input.id] = input.checked;
                } else if (input.id === 'adminPassword') {
                    const hashedPassword = await hashString(input.value);
                    dataObject[input.id] = hashedPassword;
                } else {
                    dataObject[input.id] = input.value;
                }
            }

            const jsonData = [dataObject, {"type":"login"}];

            try {
                const response = await fetch('/proxy.php?endpoint=admin/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(jsonData)
                });

                if (!response.ok) throw new Error('Erro na requisição');
                const data = await response.json();

                if (data.success) {
                    sessionStorage.setItem('admin', JSON.stringify(data.admin));

                    const sessionResponse = await axios.post('/set_admin_session.php', {
                        admin: data.admin
                    });

                    if (sessionResponse.data.success) {
                        await showSweetAlert('success', 'Login realizado!', 'Redirecionando para o dashboard...');
                        window.location.href = '/manage-pages.php';
                    } else {
                        await showSweetAlert('error', 'Erro', 'Falha ao criar sessão, Entre em contato com suporte!');
                    }
                } else {
                    await showSweetAlert('error', 'Erro no login', data.message || 'Credenciais inválidas');
                }

            } catch (error) {
                await showSweetAlert('error', 'Erro ao conectar', error.message || 'Erro desconhecido, entre em contato com suporte!');
            } finally {
                submitBtn.disabled = false;
            }
        });

        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                await showSweetAlert('error', 'Erro no cadastro', 'As senhas não coincidem.');
                submitBtn.disabled = false;
                return;
            }

            const inputs = this.querySelectorAll('[id]');
            const dataObject = {};

            for (const input of inputs) {
                if (input.type === 'checkbox') {
                    dataObject[input.id] = input.checked;
                } else if (input.id === 'registerPassword') {
                    const hashedPassword = await hashString(input.value);
                    dataObject[input.id] = hashedPassword;
                } else if (input.id !== 'confirmPassword') {
                    dataObject[input.id] = input.value;
                }
            }

            const jsonData = [dataObject, {"type":"register"}];

            try {
                const response = await fetch('/proxy.php?endpoint=admin/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(jsonData)
                });

                if (!response.ok) throw new Error('Erro na requisição');
                const data = await response.json();

                if (data.success) {
                    sessionStorage.setItem('admin', JSON.stringify(data.admin));
                    const sessionResponse = await axios.post('/set_admin_session.php', {
                        admin: data.admin
                    });

                    if (sessionResponse.data.success) {
                        await showSweetAlert('success', 'Cadastro realizado!', data.message);
                        window.location.href = '/home.php';
                    } else {
                        await showSweetAlert('error', 'Erro', 'Falha ao criar sessão no servidor.');
                    }

                } else {
                    await showSweetAlert('error', 'Erro no cadastro', data.message || 'Erro ao cadastrar');
                }

            } catch (error) {
                await showSweetAlert('error', 'Erro ao conectar', error.message);
            } finally {
                submitBtn.disabled = false;
            }
        });

        document.getElementById('recoveryForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            const inputs = this.querySelectorAll('[id]');
            const dataObject = {};

            inputs.forEach(input => {
                dataObject[input.id] = input.value;
            });

            const jsonData = [dataObject, { "type": "recovery" }];

            try {
                const response = await fetch('/proxy.php?endpoint=admin/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(jsonData)
                });

                if (!response.ok) throw new Error('Erro na requisição');

                const data = await response.json();

                if (data.success) {
                    await showSweetAlert('success', 'Email Enviado!', 'Verifique seu email para prosseguir!');
                } else {
                    await showSweetAlert('error', 'Erro no login', data.message || 'Credenciais inválidas');
                }

            } catch (error) {
                await showSweetAlert('error', 'Erro ao conectar', error.message || 'Erro desconhecido, entre em contato com suporte!');
            } finally {
                submitBtn.disabled = false;
            }
        });

        // Utility functions
        function showBootstrapAlert(containerId, message, type) {
            const container = document.getElementById(containerId);
            const alertType = type === 'error' ? 'danger' : type;

            container.innerHTML = `
                <div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            if (type === 'success') {
                setTimeout(() => {
                    const alert = bootstrap.Alert.getOrCreateInstance(container.querySelector('.alert'));
                    alert.close();
                }, 3000);
            }
        }

        function showSweetAlert(icon, title, text, confirmText = 'OK') {
            return Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonText: confirmText,
                confirmButtonColor: '#3085d6',
            });
        }

        async function hashString(str) {
            const encoder = new TextEncoder();
            const data = encoder.encode(str);
            const hashBuffer = await crypto.subtle.digest('SHA-256', data);
            return Array.from(new Uint8Array(hashBuffer))
                .map(b => b.toString(16).padStart(2, '0'))
                .join('');
        }
    </script>

</body>

</html>
<?php
session_start();
$pageTitle = 'Ativar conta';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ativar conta</title>
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
                
                <div class="p-6">
                <!-- Register Form (Hidden by default) -->
                    <div id="register-form" class="space-y-4">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-gray-800">
                                <i class="fas fa-check-circle mr-2 text-green-500"></i>Ativar Conta
                            </h2>
                            <p class="text-gray-500 mt-1">Clique no botão abaixo para ativar sua conta</p>
                        </div>

                        <div id="registerAlert" class="hidden"></div>
                        <div id="recoveryAlert" class="hidden"></div>

                        <form id="activateAccountForm" class="space-y-4">
                            <button type="submit" id="activateAccountBtn" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all flex items-center justify-center">
                                <i class="fas fa-power-off mr-2"></i>ATIVA AGORA
                            </button>
                        </form>
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
document.getElementById('activateAccountForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('activateAccountBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Ativando...';

    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');

    if (!token) {
        await showSweetAlert('error', 'Token inválido', 'Token de ativação não encontrado na URL.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-power-off mr-2"></i>ATIVA AGORA';
        return;
    }

    const jsonData = [{ "type": "activateAccount" }, { "token": token }];

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
                await showSweetAlert('success', 'Conta ativada com Sucesso!', data.message);
                window.location.href = '/home.php';
            } else {
                await showSweetAlert('error', 'Erro', 'Falha ao criar sessão.');
            }

        } else {
            await showSweetAlert('error', 'Erro ao ativar conta', data.message || 'Erro ao ativar conta!');
        }

    } catch (error) {
        await showSweetAlert('error', 'Erro ao ativar', error.message);
    } finally {
        submitBtn.disabled = false;
    }
});


// Mostrar alerta estilizado com Bootstrap
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

// Mostrar SweetAlert2 (para mensagens mais importantes)
function showSweetAlert(icon, title, text, confirmText = 'OK') {
    return Swal.fire({
        icon: icon,
        title: title,
        text: text,
        confirmButtonText: confirmText,
        confirmButtonColor: '#3085d6',
    });
}
			
    </script>
</body>
</html>
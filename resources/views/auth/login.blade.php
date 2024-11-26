<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jerk Home - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .eye-container {
            width: 120px;
            height: 60px;
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 50;
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            background-color: #FF5E4D;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .eye {
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
        }

        .pupil {
            width: 16px;
            height: 16px;
            background: #1F2937;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }

        .eyelid {
            width: 150%;
            height: 100%;
            background: #FF5E4D;
            position: absolute;
            top: -100%;
            left: -25%;
            transition: all 0.2s ease;
        }

        .looking-away .pupil {
            transform: translate(calc(-50% + 8px), calc(-50% - 8px)) !important;
        }

        .looking-away {
            transform: translateX(-50%) rotate(-10deg);
        }

        @keyframes blink {
            0% { top: -100%; }
            40% { top: -100%; }
            45% { top: 0; }
            50% { top: -100%; }
            100% { top: -100%; }
        }

        .eyelid {
            animation: blink 4s infinite;
        }

        @keyframes lookAround {
            0% { transform: translate(calc(-50% + 8px), calc(-50% - 8px)); }
            25% { transform: translate(calc(-50% + 8px), calc(-50% + 8px)); }
            50% { transform: translate(calc(-50% - 8px), calc(-50% + 8px)); }
            75% { transform: translate(calc(-50% - 8px), calc(-50% - 8px)); }
            100% { transform: translate(calc(-50% + 8px), calc(-50% - 8px)); }
        }

        .looking-away .pupil {
            animation: lookAround 4s infinite;
        }

        .login-card {
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(8px);
        }

        /* Personalización del checkbox */
        input[type="checkbox"] {
            accent-color: #FF5E4D;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md relative">
            <!-- Logo -->
            <div class="absolute -top-24 left-1/2 transform -translate-x-1/2">
                <img src="/img/logo_pn.png" alt="Jerk Home" class="h-20 w-auto">
            </div>
            
            <!-- Floating Eyes -->
            <div class="eye-container">
                <div class="eye">
                    <div class="pupil"></div>
                    <div class="eyelid"></div>
                </div>
                <div class="eye">
                    <div class="pupil"></div>
                    <div class="eyelid"></div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="login-card rounded-3xl shadow-2xl p-8 pt-16 border border-gray-700">
                <!-- Header -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-white mb-2">Bienvenido</h2>
                    <p class="text-gray-400">Ingrese sus credenciales</p>
                </div>

                <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-200">Correo Electrónico</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-[#FF5E4D]">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   required 
                                   class="focus-input block w-full pl-10 pr-4 py-3 bg-gray-800/50 border border-gray-700 rounded-xl 
                                          text-white placeholder-gray-500 
                                          focus:ring-2 focus:ring-[#FF5E4D] focus:border-transparent
                                          transition duration-200 ease-in-out"
                                   placeholder="ejemplo@jerkhome.com">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-200">Contraseña</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-[#FF5E4D]">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required 
                                   class="focus-input block w-full pl-10 pr-10 py-3 bg-gray-800/50 border border-gray-700 rounded-xl 
                                          text-white placeholder-gray-500 
                                          focus:ring-2 focus:ring-[#FF5E4D] focus:border-transparent
                                          transition duration-200 ease-in-out"
                                   placeholder="••••••••">
                            <button type="button" 
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#FF5E4D] transition-colors">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <label class="flex items-center space-x-2 text-sm text-gray-300 cursor-pointer group">
                            <input type="checkbox" 
                                   name="remember"
                                   class="w-4 h-4 rounded border-gray-700 focus:ring-[#FF5E4D] focus:ring-offset-0 
                                          bg-gray-800/50 cursor-pointer">
                            <span class="group-hover:text-white transition duration-200">Recordar sesión</span>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full py-3 px-4 bg-[#FF5E4D] hover:bg-[#ff4733] text-white font-medium rounded-xl 
                                   transition duration-200 transform hover:-translate-y-0.5 
                                   focus:ring-2 focus:ring-[#FF5E4D] focus:ring-offset-2 focus:ring-offset-gray-900
                                   shadow-lg shadow-[#FF5E4D]/20">
                        Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        const password = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (password.type === 'password') {
            password.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const pupils = document.querySelectorAll('.pupil');
        const inputs = document.querySelectorAll('.focus-input');
        let currentInput = null;

        function updateEyePosition(event) {
            const inputRect = currentInput ? currentInput.getBoundingClientRect() : null;
            
            pupils.forEach(pupil => {
                const eyeRect = pupil.parentElement.getBoundingClientRect();
                let x, y;

                if (currentInput) {
                    x = inputRect.left + inputRect.width / 2;
                    y = inputRect.top + inputRect.height / 2;
                } else {
                    x = event.clientX;
                    y = event.clientY;
                }

                const radian = Math.atan2(
                    y - (eyeRect.top + eyeRect.height / 2),
                    x - (eyeRect.left + eyeRect.width / 2)
                );

                const radius = 8;
                const offsetX = Math.cos(radian) * radius;
                const offsetY = Math.sin(radian) * radius;

                pupil.style.transform = `translate(calc(-50% + ${offsetX}px), calc(-50% + ${offsetY}px))`;
            });
        }

        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                currentInput = this;
                updateEyePosition({ clientX: 0, clientY: 0 });
            });

            input.addEventListener('blur', function() {
                currentInput = null;
            });
        });

        document.addEventListener('mousemove', function(event) {
            if (!currentInput) {
                updateEyePosition(event);
            }
        });
    });
    </script>
</body>
</html>
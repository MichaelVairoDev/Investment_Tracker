# 📈 Investment Tracker

## 📝 Descripción

Una plataforma moderna para el seguimiento y gestión de inversiones construida con Laravel y Tailwind CSS. La aplicación permite a los usuarios gestionar múltiples portafolios de inversiones, realizar un seguimiento detallado de transacciones y analizar el rendimiento de sus inversiones en tiempo real.

## 📸 Capturas de Pantalla

### 🏠 Página Principal

![Página Principal](/screenshots/home.png)
_Vista principal de la plataforma con información sobre las características principales_

### 📊 Dashboard

![Dashboard](/screenshots/dashboard.png)
_Panel de control con resumen de portafolios e inversiones_

### 📁 Lista de Portafolios

![Lista de Portafolios](/screenshots/list-portafolios.png)
_Gestión de portafolios de inversión_

### 💼 Detalle de Portafolio

![Detalle de Portafolio](/screenshots/portafolio.png)
_Vista detallada de un portafolio con sus inversiones_

### 💰 Inversiones

![Inversiones](/screenshots/inversiones.png)
_Lista de inversiones dentro de un portafolio_

### ✏️ Editar Inversión

![Editar Inversión](/screenshots/edit-inversion.png)
_Formulario para editar los detalles de una inversión_

### 👤 Perfil de Usuario

![Perfil](/screenshots/profile.png)
_Gestión del perfil de usuario_

### 🔐 Autenticación

![Login](/screenshots/login.png)
_Página de inicio de sesión_

![Registro](/screenshots/register.png)
_Página de registro de usuario_

## 🚀 Tecnologías Utilizadas

### Frontend

-   🎨 Tailwind CSS para el diseño de la interfaz
-   🔄 Alpine.js para interactividad
-   🎯 Blade como motor de plantillas
-   📱 Diseño responsive

### Backend

-   ⚡ Laravel 10
-   🗃️ SQLite como base de datos
-   🔐 Laravel Breeze para autenticación
-   📝 PHP 8.2

## 🛠️ Requisitos Previos

-   PHP 8.2 o superior
-   Composer
-   Node.js y npm
-   SQLite3

## ⚙️ Configuración del Proyecto

1. **Clonar el repositorio**

```bash
git clone <url-del-repositorio>
cd Investment_Tracker
```

2. **Instalar dependencias**

```bash
composer install
npm install
```

3. **Configurar el entorno**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**

```bash
touch database/database.sqlite
php artisan migrate --seed
```

5. **Compilar assets**

```bash
npm run build
```

## 🚀 Iniciar el Proyecto

1. **Iniciar el servidor de desarrollo**

```bash
php artisan serve
```

2. **Acceder a la aplicación**

-   URL: http://localhost:8000
-   Usuario demo: demo@example.com
-   Contraseña: demo1234

## 📊 Características Principales

-   📁 Gestión de múltiples portafolios
-   💰 Seguimiento de inversiones por tipo (acciones, criptomonedas, ETFs, etc.)
-   📈 Análisis de rendimiento en tiempo real
-   🔄 Registro de transacciones (compras y ventas)
-   📊 Dashboard con resumen general
-   👥 Sistema de autenticación de usuarios
-   📱 Diseño totalmente responsive

## 🔐 Seguridad

-   Autenticación de usuarios con Laravel Breeze
-   Middleware para protección de rutas
-   Validación de datos en frontend y backend
-   Políticas de acceso para recursos

## 🗂️ Estructura del Proyecto

```
Investment_Tracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
├── routes/
└── tests/
```

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

## 📞 Soporte

Para soporte o preguntas, por favor abre un issue en el repositorio.

---

⌨️ con ❤️ por [Michael Vairo]

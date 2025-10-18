# Smart IoT Glove for Real-Time Sign Language Translation

This project is a full-stack monorepo for a real-time sign language translation system. It consists of a Laravel backend, a Vue.js frontend, and a Python microservice that simulates processing data from an IoT smart glove.

---

## 🚀 Tech Stack

-   **Backend:** Laravel (PHP)
-   **Frontend:** Vue.js with Vite
-   **IoT Service:** Python with FastAPI
-   **Real-Time Communication:** WebSockets via Soketi
-   **Database:** MySQL
-   **Development Environment:** Laragon

---

## 🔧 Setup and Installation

### Prerequisites

-   Laragon (or another local server environment)
-   Composer
-   Node.js (v18 recommended) & npm
-   Python

### 1. Backend Setup (Laravel)

1.  Navigate to the backend directory:
    ```bash
    cd backend-laravel
    ```
2.  Install PHP dependencies:
    ```bash
    composer install
    ```
3.  Copy the environment file:
    ```bash
    cp .env.example .env
    ```
4.  Generate an application key:
    ```bash
    php artisan key:generate
    ```
5.  Install JavaScript dependencies:
    ```bash
    npm install
    ```
6.  Configure your `.env` file with your database credentials (`DB_DATABASE=smart_glove_project`) and update the `APP_URL`, `SESSION_DOMAIN`, and `SANCTUM_STATEFUL_DOMAINS` to `http://backend-laravel.test`.
7.  Run the database migrations:
    ```bash
    php artisan migrate
    ```

### 2. IoT Service Setup (Python)

1.  Navigate to the Python service directory:
    ```bash
    cd iot-service-python
    ```
2.  Create and activate a virtual environment:
    ```bash
    python -m venv venv
    .\venv\Scripts\activate
    ```
3.  Install Python dependencies:
    ```bash
    pip install -r requirements.txt
    ```
    *(Note: We'll create the `requirements.txt` file in the next step.)*

---

## ⚙️ Running the Development Servers

You need to have **three separate terminals** running simultaneously.

1.  **Soketi Server (for WebSockets):**
    ```bash
    # (In any terminal)
    soketi start
    ```
2.  **Vite Server (for Frontend):**
    ```bash
    # (Terminal inside backend-laravel)
    npm run dev
    ```
3.  **Python Server (for IoT Service):**
    ```bash
    # (Terminal inside iot-service-python, with venv active)
    uvicorn main:app --reload
    ```

---
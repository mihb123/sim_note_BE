## 🚀 Requirements
- PHP ≥ 8.1
- Composer
- A database (SQLite, MySQL, etc.)
- Docker & Docker Compose (for containerized setup)

---

## ⚙️ Setup & Installation

I've included two ways to get your project running:

### 1. Local Development (without Docker)

This is the traditional way to set up a PHP project on your machine.

1.  **Clone the repository**
    ```bash
    git clone https://github.com/mihb123/sim_note_BE.git
    cd sim_note_BE
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Configure your environment**
    Copy the example environment file and generate an application key.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    Next, open the `.env` file and configure your database connection (`DB_CONNECTION`, `DB_HOST`, etc.). For SQLite, you can simply create the database file:
    ```bash
    touch database/database.sqlite
    ```

4.  **Run database migrations and seeders**
    This will create the necessary tables and populate them with initial data.
    ```bash
    php artisan migrate --seed
    ```

5.  **Start the development server**
    ```bash
    php artisan serve
    ```
    Your API will be running at `http://localhost:8000`.

### 2. Using Docker (Recommended)

Using Docker provides a consistent environment for development and is great for deployment. You'll need to have a `docker-compose.yml` file in your project root.

1.  **Clone the repository and configure the environment**
    ```bash
    git clone https://github.com/mihb123/sim_note_BE.git
    cd sim_note_BE
    cp .env.example .env
    ```
    Make sure your `.env` file is configured to connect to the database service defined in your `docker-compose.yml` (e.g., `DB_HOST=db` for default).

2.  **Build and run the containers**

    ```bash
    docker compose up -d
    ```

3.  **Testing**
    ```bash
    docker ps
    curl -I http://localhost:8000
    ```

Your application should now be running and accessible via the port mapped by your web server container (e.g., `http://localhost:8000`).


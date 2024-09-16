# Task Tracker

## Introduction

**TaskTracker** is a task management platform inspired by [Trello](https://trello.com/). It enables users to efficiently create, organize, and track tasks within projects. TaskTracker prioritizes simplicity and ease of use, offering a more streamlined user experience (UX) compared to Trello.

## Technologies Used

### Front-End Technologies
- **HTML**: For structuring web content.
- **CSS**: For layout and design styling.
- **JavaScript**: For interactivity and dynamic content.
- **Bootstrap**: For responsive design and UI components.

### Back-End Technologies
- **PHP ([Laravel 11.x](https://laravel.com/docs/11.x))**: For server-side logic and API development.
- **MySQL**: For database management.

## Installation

### Prerequisites
Ensure the following software is installed on your system:
- **[PHP 8.2+](https://www.php.net/downloads.php)**: To run the backend logic.
- **[npm](https://nodejs.org/en/download)**: For managing front-end dependencies.
- **[MySQL](https://dev.mysql.com/downloads/mysql/)**: To store data.
- **[Composer](https://getcomposer.org/download/)**: For managing PHP packages.

### Steps to Install

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/MohammedShanan/TaskTracker.git
   ```

2. **Navigate to the Project Directory**:
   ```bash
   cd TaskTracker
   ```

3. **Install PHP Dependencies**:
   ```bash
   composer install
   ```

4. **Install JavaScript Dependencies**:
   ```bash
   npm install
   ```

5. **Set Up the Environment File**:
   ```bash
   cp .env.example .env
   ```

6. **Configure the Database**:  
   Open the `.env` file and configure your database details:
   ```bash
   DB_DATABASE=your_database_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```

7. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

8. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

9. **Build Front-End Assets**:
   ```bash
   npm run dev
   ```

10. **Serve the Application**:
    ```bash
    php artisan serve
    ```

## Usage

After installation, follow these steps to start using TaskTracker:

1. **Access the Application**:  
   Open your browser and go to `http://localhost:8000`.

2. **Sign Up**:  
   - Click "Sign Up" on the homepage.
   - Fill out your information and register.

3. **Log In**:  
   - If already registered, click "Log In" and enter your credentials.

4. **Create a Board**:  
   - On the dashboard, click "Create Board."
   - Enter a name and start organizing tasks in this board.

5. **Add Lists**:  
   - Inside the board, click "Add new List" to categorize tasks (e.g., "To Do," "In Progress").

6. **Manage Boards and Lists**:  
   - Edit or delete boards and lists by clicking their names or respective buttons.

7. **Create and Manage Tasks**:  
   - Add tasks under lists by clicking "Add Task."
   - Update task status or details such as priority, due date, and description by clicking the task name.

8. **View Recently Accessed Boards**:  
   - Quickly access recently used boards from the dashboard.

9. **Logout**:  
   - Securely end your session by clicking "Logout" at the top-right.

## How to Contribute

Contributions are welcome! To contribute to **TaskTracker**, follow these steps:

1. **Fork the Repository**:  
   Click the "Fork" button on the repository's GitHub page to copy the project to your GitHub account.

2. **Clone the Forked Repository**:
   ```bash
   git clone https://github.com/MohammedShanan/TaskTracker.git
   ```

3. **Create a New Branch**:
   ```bash
   git checkout -b your-branch-name
   ```

4. **Make Your Changes**:  
   Improve code, fix bugs, or add new features.

5. **Commit Your Changes**:
   ```bash
   git commit -m "Description of changes"
   ```

6. **Push to Your Branch**:
   ```bash
   git push origin your-branch-name
   ```

7. **Create a Pull Request**:  
   Go to the original repository, navigate to the "Pull Requests" tab, and click "New Pull Request."

8. **Review and Merge**:  
   After approval, your contributions will be merged into the project.

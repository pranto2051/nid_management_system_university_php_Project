# Complete AI Prompt for NID Card Management System

To build this exact application, you can use the following comprehensive prompt. It is designed to be copied and pasted into an AI coding assistant (like Claude, ChatGPT, or Gemini) to generate the entire system, including the complete UI/UX design, database structure, and all functional pages.

---

## 📋 The Master Prompt

**Copy and paste the text below into your AI assistant:**

***

Act as an Expert Full-Stack Developer and Senior UI/UX Designer. I want you to build a complete **"National ID (NID) Card Management System"** from scratch using PHP, MySQL, HTML5, CSS3 (Vanilla), and JavaScript. 

Do not use any heavy CSS frameworks like Tailwind or Bootstrap; rely on Vanilla CSS with a premium, modern design system. Provide the complete code for all files described below.

### 1. Design System & UI/UX Requirements
The application must have a "Premium Modern Aesthetic" featuring **Dark Mode and Glassmorphism**.
*   **Color Palette**: 
    *   Background: Deep dark gradients (e.g., `#0f172a` to `#1e293b`).
    *   Cards/Containers: Semi-transparent white/blue with backdrop-filter blur (Glassmorphism effect).
    *   Primary Accents: Vibrant Electric Blue (`#3b82f6`) and Neon Cyan (`#06b6d4`).
    *   Text: Crisp white and soft light grays for readability.
*   **Typography**: Use Google Fonts 'Inter' or 'Poppins'.
*   **Components**:
    *   Inputs/Buttons: Rounded corners (`border-radius: 8px` or `12px`), smooth hover transitions, and subtle glowing box-shadows on focus.
    *   Tables: Clean, responsive tables with striped rows, hover effects, and modern spacing. Profile photos should be displayed as small circular avatars (`border-radius: 50%; object-fit: cover`).
    *   Animations: Add subtle fade-in animations for page loads and form submissions using CSS keyframes.

### 2. Database Schema (`database.sql`)
Create a MySQL database named `nid_card_management` with the following tables:
1.  **`admins`**: `admin_id` (PK, AI), `full_name` (VARCHAR), `email` (VARCHAR, UNIQUE), `password` (VARCHAR, Hashed).
2.  **`users`**: `user_id` (PK, AI), `nid_number` (BIGINT, UNIQUE), `first_name` (VARCHAR), `last_name` (VARCHAR), `mobile_no` (VARCHAR), `address` (TEXT), `father_name` (VARCHAR), `mother_name` (VARCHAR), `date_of_birth` (DATE), `img` (VARCHAR 255 - to store profile image paths).

*Include an initial INSERT query for a default admin: `admin@nid.com` / `admin123`.*

### 3. Public Portal Pages
Create the following public-facing pages, ensuring they share a common header (navigation bar) and footer.
*   **`config/db_connect.php`**: Standard PDO or MySQLi connection file.
*   **`index.php`**: A stunning landing page with a hero section introducing the NID Management System, a call-to-action button to register, and a brief overview of features.
*   **`registration.php`**: A modern form for citizens to register. It must include fields for First Name, Last Name, NID Number (auto-generated or manual), Mobile, Address, Father's Name, Mother's Name, Date of Birth, and a **File Upload field for a Profile Photo**. Ensure the PHP logic handles the file upload securely, saves it to an `uploads/` folder, and inserts the path into the database.
*   **`find-nid.php`**: A search page where users can input their NID Number or Mobile Number to retrieve and view their details (including their uploaded photo) in a beautifully styled glassmorphism card.
*   **`about.php`**: A beautifully formatted informational page explaining the purpose of the NID system.

### 4. Admin Dashboard (`/admin/`)
Create a secure backend area. All admin pages must be protected by session authentication (redirect to login if not logged in). The layout should consist of a **Top Navbar** (20% height) and a **Body** (80% height), where the body is split into a **Sidebar** (20% width) and **Content Area** (80% width).
*   **`admin/login.php`**: A sleek glassmorphism login form for administrators.
*   **`admin/dashboard.php`**: The main admin hub showing quick statistics (e.g., Total Registered Citizens) using visual metric cards.
*   **`admin/users.php`**: The core management page. 
    *   Display all registered citizens in a modern HTML table.
    *   Include columns for Photo (displaying the actual uploaded image), NID Number, Name, Mobile, and Actions.
    *   **Crucial**: Implement **Numerical Pagination** (e.g., Previous, 1, 2, 3, Next) using PHP and SQL `LIMIT/OFFSET`.
    *   Include a real-time search bar to filter users by NID or Name.
*   **`admin/add-user.php`**: An admin-side form to manually register a new citizen (identical to public registration but styled for the admin panel).
*   **`admin/edit-user.php`**: A form to update a citizen's details and replace their profile photo. Ensure the old photo is deleted from the server when a new one is uploaded.
*   **`admin/delete-user.php`**: A secure script to delete a user record and their associated profile image file from the `uploads/` directory.

### 5. Code Quality & Security
*   Use prepared statements (PDO or MySQLi) for ALL database queries to prevent SQL injection.
*   Use `password_hash()` and `password_verify()` for admin passwords.
*   Sanitize all user inputs.
*   Structure the code cleanly: separate logic from presentation where possible, and use `includes/` for reusable components like the header, footer, and admin sidebar.

Please output the complete file structure and the code for each file required to run this application perfectly.

***

## 💡 Pro-Tips for using this prompt:

1.  **Iterative Generation**: AI models have output limits. If you use this prompt, the AI might stop halfway. Just type **"Continue from where you left off"** or ask it to generate specific files one by one (e.g., "Start by generating the database.sql and db_connect.php").
2.  **Customizing Colors**: If you prefer a light theme, change the "Color Palette" section in the prompt to request "a clean, minimal light theme with soft shadows and a primary color of emerald green."
3.  **Image Uploads**: The prompt explicitly asks the AI to handle file uploads securely. Always ensure your server's `uploads/` folder has the correct read/write permissions.

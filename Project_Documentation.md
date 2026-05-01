# Comprehensive Technical Documentation: NID Management System
**Prepared for University Project Submission**

## 1. Project Overview
The NID Management System is a robust web-based application designed to facilitate the registration, generation, and management of National Identity Cards (NID). It provides an intuitive public portal for citizen registration and a secured administrative panel for data management. The project is developed using **PHP**, **MySQL**, and modern frontend technologies (HTML5, CSS3, JavaScript).

## 2. System Architecture & Components
The application is structured into modular components to ensure maintainability, security, and scalability:

*   **`/config/`**: Contains core configuration files, primarily the database connection logic (`db.php`).
*   **`/includes/`**: Stores reusable UI components such as `header.php` and `footer.php` to maintain a consistent layout across different pages without code duplication.
*   **`/admin/`**: The secured administrative dashboard backend for managing registered citizens and overseeing system metrics.
*   **`/uploads/`**: The designated and secured directory for storing uploaded citizen profile pictures.
*   **`registration.php`**: The public-facing component handling new citizen registrations, file uploads, and form submissions.
*   **`find-nid.php` & `find-nid-form.php`**: Components responsible for searching the database and dynamically rendering the generated digital NID cards.

## 3. Database Architecture & Tables
The system utilizes a relational database named `nid_card_management` consisting of two primary tables.

### 3.1 `users` Table (Citizen Data)
Stores all demographic and identification data for registered citizens.
*   `user_id` (INT, Primary Key, Auto Increment) - Unique internal identifier.
*   `nid_number` (BIGINT, Unique) - The automatically generated 12-digit NID.
*   `first_name`, `last_name` (VARCHAR) - Citizen's full name.
*   `mobile_no` (VARCHAR) - Contact information.
*   `father_name`, `mother_name` (VARCHAR) - Parental information.
*   `date_of_birth` (DATE) - Used for age verification and record keeping.
*   `address` (TEXT) - Full permanent address.
*   `img` (VARCHAR) - File path reference to the uploaded profile picture.
*   `created_at`, `updated_at` (TIMESTAMP) - System audit trails for record tracking.

### 3.2 `admins` Table (System Administrators)
Stores credentials for secure administrative dashboard access.
*   `admin_id` (INT, Primary Key, Auto Increment)
*   `full_name`, `email` (VARCHAR) - Administrator details.
*   `password` (VARCHAR) - Securely stored password credentials.

## 4. PHP Database Connection (PDO Implementation)
The system utilizes **PHP Data Objects (PDO)** for database interaction. PDO is chosen over `mysqli` because it provides an object-oriented interface, supports multiple database types, and adds a strong layer of security against SQL injection attacks via prepared statements.

**Connection File (`config/db.php`):**
```php
<?php
$host = 'localhost';
$db   = 'nid_card_management';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$charset = 'utf8mb4'; // Ensures proper encoding for special characters

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    // Ensures database errors throw exceptions for easier debugging
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Returns data as an associative array (e.g., $row['name'])
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Disables emulation to use native database prepared statements
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     // Establishing the PDO connection
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Connection failed: " . $e->getMessage());
}
?>
```

## 5. Data Handling: POST and GET Methods
The application heavily relies on HTTP POST and GET methods to transfer data securely between the frontend and the backend MySQL database.

### 5.1 Handling Data Insertion (POST Method)
When a user submits the registration form, the data is sent securely to the server using the `POST` method. This process is handled inside `registration.php`.

**Step 1: Receiving Form Data**
The `$_POST` superglobal array captures the submitted form fields. `trim()` is used to remove unnecessary whitespace.
```php
if (isset($_POST['register'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $mobile_no = trim($_POST['mobile_no']);
    $date_of_birth = $_POST['date_of_birth'];
    // ... capturing other form fields
}
```

**Step 2: File/Image Upload Handling**
The system processes file uploads using the `$_FILES` superglobal, renames the file with a timestamp to prevent overwriting, and moves it to the `/uploads/` directory.
```php
$img = "";
if (!empty($_FILES['img_file']['name'])) {
    $target_dir = "uploads/profile/";
    $file_extension = pathinfo($_FILES["img_file"]["name"], PATHINFO_EXTENSION);
    $file_name = time() . "_profile." . $file_extension; // Generating unique name
    
    if (move_uploaded_file($_FILES['img_file']['tmp_name'], $target_dir . $file_name)) {
        $img = $target_dir . $file_name; // Saving path for the database
    }
}
```

**Step 3: Database Insertion using Prepared Statements**
To prevent SQL injection, data is bound to a prepared statement before execution.
```php
$sql = "INSERT INTO users (first_name, last_name, nid_number, mobile_no, father_name, mother_name, date_of_birth, address, img) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

// Executing the statement with the array of captured POST variables
$stmt->execute([$first_name, $last_name, $nid_number, $mobile_no, $father_name, $mother_name, $date_of_birth, $address, $img]);
```

### 5.2 Retrieving Data (GET & POST Methods)
The system retrieves NID information primarily using the `find-nid.php` component. It is designed to be flexible, supporting both `POST` (from a submitted search form) and `GET` (from direct URL links, e.g., `find-nid.php?nid=123456789012`).

**Data Retrieval Logic:**
```php
// Check if the request is via POST form submission OR GET URL parameter
if (isset($_POST['search']) || isset($_GET['nid'])) {
    
    // Ternary operator to dynamically assign the NID number based on the request method
    $nid_number = isset($_POST['nid_number']) ? trim($_POST['nid_number']) : trim($_GET['nid']);

    // Fetch the specific user record safely
    $stmt = $pdo->prepare("SELECT * FROM users WHERE nid_number = ?");
    $stmt->execute([$nid_number]);
    $user = $stmt->fetch();

    if ($user) {
        // Outputting data to the frontend
        // htmlspecialchars() is used to prevent Cross-Site Scripting (XSS)
        echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
        echo htmlspecialchars($user['address']);
    } else {
        // Handle no record found
    }
}
```

## 6. Administrative Operations (CRUD)
The system includes a dedicated administrative panel located in the `/admin/` directory. This panel empowers authorized personnel to perform complete CRUD (Create, Read, Update, Delete) operations on citizen records. 

### 6.1 Adding a New User (`add-user.php`)
Administrators can manually register citizens directly from the dashboard. The backend logic is identical to the public registration portal. It accepts `POST` request data, handles the profile image upload securely, dynamically generates a unique 12-digit NID, and inserts the record into the `users` table using PDO prepared statements.

### 6.2 Updating an Existing User (`edit-user.php`)
The update operation allows administrators to correct or update citizen details dynamically. 
*   **Data Retrieval:** The `$_GET['id']` parameter identifies the specific record, pre-filling the HTML form with the user's existing data.
*   **Update Logic:** On form submission, the system executes an `UPDATE` SQL statement.
```php
$sql = "UPDATE users SET first_name=?, last_name=?, nid_number=?, mobile_no=?, father_name=?, mother_name=?, date_of_birth=?, address=?, img=? WHERE user_id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$first_name, $last_name, $nid_number, $mobile_no, $father_name, $mother_name, $date_of_birth, $address, $img, $id]);
```
*   **Validation:** Before updating, the system ensures that if the NID number is altered, it doesn't conflict with another existing user using: `SELECT user_id FROM users WHERE nid_number = ? AND user_id != ?`.

### 6.3 Removing a User (`delete-user.php`)
Deleting obsolete or erroneous records is strictly restricted to authenticated administrators. The process securely removes the user row from the database using a `DELETE` query bound to the user's ID.
```php
if (isset($_GET['id'])) {
    $id = $_GET['id']; // User ID passed via URL parameters
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$id]);
}
```

## 7. Conclusion
The NID Management System successfully demonstrates the integration of a frontend interface with a robust PHP backend. By utilizing PDO for database connections, properly handling data via GET and POST methods, and offering comprehensive administrative CRUD features, the system ensures data integrity, security, and a seamless user experience.

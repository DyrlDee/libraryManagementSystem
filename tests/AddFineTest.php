<?php
use PHPUnit\Framework\TestCase;

class AddFineTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Simulate database connection with XAMPP socket path
        $this->conn = new mysqli('localhost', 'root', '', 'test_db', null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
        if ($this->conn->connect_error) {
            $this->fail("Database connection failed: " . $this->conn->connect_error);
        }

        // Create test tables for fines, users, and related entities
        $this->conn->query("CREATE TABLE IF NOT EXISTS `fine` (
            `fine_id` INT AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT NOT NULL,
            `loan_id` INT DEFAULT NULL,
            `reserve_id` INT DEFAULT NULL,
            `fine_category` VARCHAR(255) NOT NULL,
            `fine_description` TEXT NOT NULL,
            `fine_fee` DECIMAL(10,2) NOT NULL,
            `status` VARCHAR(20) NOT NULL
        )");

        $this->conn->query("CREATE TABLE IF NOT EXISTS `user` (
            `user_id` INT AUTO_INCREMENT PRIMARY KEY,
            `user_name` VARCHAR(255) NOT NULL,
            `user_email` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `profile_img` VARCHAR(255) DEFAULT NULL
        )");

        // Insert a test user
        $this->conn->query("INSERT INTO `user` (user_name, user_email, password) VALUES ('Test User', 'test@example.com', 'password123')");
    }

    protected function tearDown(): void
    {
        // Clean up the test database
        $this->conn->query("DROP TABLE IF EXISTS `fine`");
        $this->conn->query("DROP TABLE IF EXISTS `user`");
        $this->conn->close();
    }

    public function testAddFineForLoan()
    {
        // Simulate form submission for a loan fine
        $_POST = [
            'user_id' => 1,
            'id' => 1,
            'email' => 'test@example.com',
            'type' => 'loan',
            'fine_category' => 'Late Book Return',
            'fine_description' => 'Book returned late',
            'fine_fee' => 10.00,
            'status' => 'pending'
        ];

        // Include the add_fine_action.php script
        ob_start();
        require_once 'add_fine_action.php'; // Use require_once to avoid redeclaration errors
        $output = ob_get_clean();

        // Check if the fine was inserted into the database
        $result = $this->conn->query("SELECT * FROM `fine` WHERE user_id = 1 AND loan_id = 1");
        $this->assertEquals(1, $result->num_rows, "Fine should be added for the loan.");
    }

    public function testAddFineForReservation()
    {
        // Simulate form submission for a reservation fine
        $_POST = [
            'user_id' => 1,
            'id' => 1,
            'email' => 'test@example.com',
            'type' => 'reservation',
            'fine_category' => 'Late Key Return',
            'fine_description' => 'Key returned late',
            'fine_fee' => 5.00,
            'status' => 'pending'
        ];

        // Include the add_fine_action.php script
        ob_start();
        require_once 'add_fine_action.php'; // Use require_once to avoid redeclaration errors
        $output = ob_get_clean();

        // Check if the fine was inserted into the database
        $result = $this->conn->query("SELECT * FROM `fine` WHERE user_id = 1 AND reserve_id = 1");
        $this->assertEquals(1, $result->num_rows, "Fine should be added for the reservation.");
    }
}
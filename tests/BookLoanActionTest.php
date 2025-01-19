<?php
use PHPUnit\Framework\TestCase;

class BookLoanTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Simulate database connection with XAMPP socket path
        $this->conn = new mysqli('localhost', 'root', '', 'test_db', null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
        if ($this->conn->connect_error) {
            $this->fail("Database connection failed: " . $this->conn->connect_error);
        }

        // Create test tables for books and book loans
        $this->conn->query("CREATE TABLE IF NOT EXISTS `book` (
            `book_id` INT AUTO_INCREMENT PRIMARY KEY,
            `book_name` VARCHAR(255) NOT NULL,
            `book_author` VARCHAR(255) NOT NULL,
            `book_publisher` VARCHAR(255) NOT NULL,
            `book_genre` VARCHAR(255) NOT NULL,
            `book_img` VARCHAR(255)
        )");

        $this->conn->query("CREATE TABLE IF NOT EXISTS `bookloan` (
            `loan_id` INT AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT NOT NULL,
            `book_id` INT NOT NULL,
            `date_start` DATE NOT NULL,
            `date_end` DATE NOT NULL,
            `hasReturn` ENUM('yes', 'no') DEFAULT 'no'
        )");

        // Insert a test book
        $this->conn->query("INSERT INTO `book` (book_name, book_author, book_publisher, book_genre) VALUES ('Test Book', 'Test Author', 'Test Publisher', 'Test Genre')");
    }

    protected function tearDown(): void
    {
        // Clean up the test database
        $this->conn->query("DROP TABLE IF EXISTS `book`");
        $this->conn->query("DROP TABLE IF EXISTS `bookloan`");
        $this->conn->close();
    }

    public function testBookLoanFormDisplay()
    {
        // Simulate a GET request with a book ID
        $_GET = ['book_id' => 1];

        // Start output buffering
        ob_start();
        include 'book_module_loan.php';
        $output = ob_get_clean(); // Get and clean the output buffer

        // Check if the book details are displayed in the form
        $this->assertStringContainsString('Test Book', $output);
    }
}
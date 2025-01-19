<?php
use PHPUnit\Framework\TestCase;

class ReservationRoomTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Simulate database connection with XAMPP socket path
        $this->conn = new mysqli('localhost', 'root', '', 'test_db', null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
        if ($this->conn->connect_error) {
            $this->fail("Database connection failed: " . $this->conn->connect_error);
        }

        // Create test tables for facilities
        $this->conn->query("CREATE TABLE IF NOT EXISTS `facility` (
            `faci_id` INT AUTO_INCREMENT PRIMARY KEY,
            `faci_name` VARCHAR(255) NOT NULL,
            `faci_type` VARCHAR(255) NOT NULL,
            `status` VARCHAR(50) NOT NULL
        )");

        // Insert a test facility
        $this->conn->query("INSERT INTO `facility` (faci_name, faci_type, status) VALUES ('Test Room', 'Meeting Room', 'Available')");
    }

    protected function tearDown(): void
    {
        // Clean up the test database
        $this->conn->query("DROP TABLE IF EXISTS `facility`");
        $this->conn->close();
    }

    public function testReservationRoomFormDisplay()
    {
        // Simulate a GET request with a facility ID
        $_GET = ['faci_id' => 1];

        // Start output buffering
        ob_start();
        include 'reservation_room.php';
        $output = ob_get_clean();

        // Check if the facility details are displayed in the form
        $this->assertStringContainsString('Test Room', $output);
    }
}
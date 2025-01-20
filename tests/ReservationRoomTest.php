<?php
use PHPUnit\Framework\TestCase;

class ReservationRoomTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli('localhost', 'root', '', 'test_db');
        if ($this->conn->connect_error) {
            $this->fail("Database connection failed: " . $this->conn->connect_error);
        }

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
        $this->conn->query("DROP TABLE IF EXISTS `facility`");
        $this->conn->close();
    }

    public function testReservationRoomFormDisplay()
    {
        $_GET = ['faci_id' => 1];

        ob_start();
        include 'reservation_room.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Test Room', $output);
    }
}
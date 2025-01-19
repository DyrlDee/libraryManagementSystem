<?php

use PHPUnit\Framework\TestCase;

class SendNotificationTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Simulate database connection with XAMPP socket path
        $this->conn = new mysqli('localhost', 'root', '', 'test_db', null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
        if ($this->conn->connect_error) {
            $this->fail("Database connection failed: " . $this->conn->connect_error);
        }

        // Create the `notification` table if it doesn't exist
        $this->conn->query("
            CREATE TABLE IF NOT EXISTS `notification` (
                `not_id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `not_description` TEXT NOT NULL
            )
        ");

        // Insert a test user into the `User` table
        $this->conn->query("
            CREATE TABLE IF NOT EXISTS `User` (
                `user_id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_name` VARCHAR(50) NOT NULL,
                `ic_number` VARCHAR(12) NOT NULL,
                `user_email` VARCHAR(100) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `phone_number` VARCHAR(15) DEFAULT NULL,
                `profile_img` VARCHAR(255) DEFAULT NULL,
                `role` INT NOT NULL
            )
        ");

        // Insert a test user
        $this->conn->query("
            INSERT INTO `User` (`user_id`, `user_name`, `ic_number`, `user_email`, `password`, `phone_number`, `profile_img`, `role`)
            VALUES (1, 'Test User', '123456789012', 'test@example.com', 'password123', '1234567890', NULL, 2)
        ");

        // Insert test notifications for the user
        $this->conn->query("
            INSERT INTO `notification` (`user_id`, `not_description`)
            VALUES
                (1, 'Your book is due in 3 days.'),
                (1, 'Your reservation is confirmed.'),
                (1, 'Your fine has been settled.')
        ");
    }

    protected function tearDown(): void
    {
        // Clean up the test database
        $this->conn->query("DROP TABLE IF EXISTS `notification`");
        $this->conn->query("DROP TABLE IF EXISTS `User`");
        $this->conn->close();
    }

    public function testFetchNotificationsForUser()
    {
        // Simulate a logged-in user with user_id = 1
        $_SESSION["user_id"] = 1;

        // Include the send_notification.php script
        ob_start();
        include 'send_notification.php';
        $output = ob_get_clean();

        // Check if the notifications are displayed in the HTML output
        $this->assertStringContainsString('Your book is due in 3 days.', $output);
        $this->assertStringContainsString('Your reservation is confirmed.', $output);
        $this->assertStringContainsString('Your fine has been settled.', $output);
    }

    public function testNoNotificationsForUser()
    {
        // Simulate a logged-in user with no notifications
        $_SESSION["user_id"] = 2;

        // Include the send_notification.php script
        ob_start();
        include 'send_notification.php';
        $output = ob_get_clean();

        // Check if the "no notification" message is displayed
        $this->assertStringContainsString('You have no notification', $output);
    }
}
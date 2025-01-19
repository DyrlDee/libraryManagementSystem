<?php

use PHPUnit\Framework\TestCase;

class SendNotificationTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "librarylms";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            $this->fail("Database connection failed: " . $this->conn->connect_error);
        }

        $this->conn->query("
            CREATE TABLE IF NOT EXISTS `notification` (
                `not_id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `not_description` TEXT NOT NULL
            )
        ");

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

        $this->conn->query("
            INSERT INTO `User` (`user_id`, `user_name`, `ic_number`, `user_email`, `password`, `phone_number`, `profile_img`, `role`)
            VALUES (1, 'Test User', '123456789012', 'test@example.com', 'password123', '1234567890', NULL, 2)
        ");

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
        $this->conn->query("DROP TABLE IF EXISTS `notification`");
        $this->conn->query("DROP TABLE IF EXISTS `User`");
        $this->conn->close();
    }

    public function testFetchNotificationsForUser()
    {
        $_SESSION["user_id"] = 1;

        ob_start();
        include 'send_notification.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Your book is due in 3 days.', $output);
        $this->assertStringContainsString('Your reservation is confirmed.', $output);
        $this->assertStringContainsString('Your fine has been settled.', $output);
    }

    public function testNoNotificationsForUser()
    {
        $_SESSION["user_id"] = 2;

        ob_start();
        include 'send_notification.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('You have no notification', $output);
    }
}
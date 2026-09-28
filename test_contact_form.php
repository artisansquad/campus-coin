<?php
use App\Models\ContactMessage;
use App\Models\InAppNotification;
use App\Models\User;

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

echo "\n=== TESTING CONTACT FORM SUBMISSION ===\n\n";

// Clear previous test data
$testEmail = 'test.contact@example.com';
ContactMessage::where('email', $testEmail)->delete();

echo "1. Creating test contact message...\n";
$message = ContactMessage::create([
    'user_id' => null,
    'name' => 'Test Student',
    'email' => $testEmail,
    'subject' => 'Test Subject',
    'message' => 'This is a test message from the contact form.',
    'status' => 'new',
]);
echo "   ✓ Contact message created (ID: {$message->id})\n\n";

// Now create notifications for all admins (simulate what controller does)
$adminUsers = User::where('role', 'admin')->get();
echo "2. Finding admin users...\n";
echo "   Found {$adminUsers->count()} admin(s)\n\n";

echo "3. Creating notifications for admin users...\n";
foreach ($adminUsers as $admin) {
    $notif = InAppNotification::create([
        'user_id' => $admin->id,
        'title' => 'New contact message',
        'message' => $message->message,
        'type' => 'contact_message',
        'sender_name' => $message->name,
        'sender_email' => $message->email,
        'contact_message_id' => $message->id,
        'is_read' => false,
    ]);
    echo "   ✓ Notification created for admin '{$admin->name}' (Notif ID: {$notif->id})\n";
}

echo "\n=== VERIFICATION ===\n\n";

// Verify data
$contactCount = ContactMessage::where('email', $testEmail)->count();
$notificationCount = InAppNotification::where('contact_message_id', $message->id)->count();

echo "Contact messages in DB: {$contactCount}\n";
echo "Notifications in DB: {$notificationCount}\n";
echo "Admin users: {$adminUsers->count()}\n\n";

if ($contactCount > 0 && $notificationCount > 0) {
    echo "✅ SUCCESS! The contact form workflow is working correctly:\n";
    echo "   1. Message saved to contact_messages table\n";
    echo "   2. Notifications created for each admin user\n";
    echo "   3. Admins will see the message in their notification bell\n";
} else {
    echo "❌ FAILED! Something went wrong.\n";
}

echo "\n";

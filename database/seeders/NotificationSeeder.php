<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        $user = $users->first();

        $notifications = [
            [
                'type' => 'price',
                'title' => 'Bitcoin Price Alert',
                'message' => 'BTC has reached your target price of $45,000',
                'is_read' => false,
                'metadata' => ['price' => 45000, 'percentage' => 5.2]
            ],
            [
                'type' => 'portfolio',
                'title' => 'Portfolio Milestone Reached',
                'message' => 'Congratulations! Your portfolio has grown by 25% this month',
                'is_read' => false,
                'metadata' => ['growth' => 25, 'period' => 'month']
            ],
            [
                'type' => 'security',
                'title' => 'New Login Detected',
                'message' => 'New login from Chrome on Windows 10',
                'is_read' => true,
                'metadata' => ['browser' => 'Chrome', 'os' => 'Windows 10']
            ],
            [
                'type' => 'system',
                'title' => 'System Maintenance Scheduled',
                'message' => 'Scheduled maintenance on Sunday at 2:00 AM UTC',
                'is_read' => false,
                'metadata' => ['date' => '2025-01-12', 'time' => '02:00']
            ],
            [
                'type' => 'price',
                'title' => 'Ethereum Price Drop',
                'message' => 'ETH has dropped 8% in the last hour',
                'is_read' => false,
                'metadata' => ['drop' => 8, 'timeframe' => '1 hour']
            ],
            [
                'type' => 'portfolio',
                'title' => 'Risk Level Increased',
                'message' => 'Your portfolio risk level has increased to HIGH',
                'is_read' => true,
                'metadata' => ['risk_level' => 'HIGH', 'previous' => 'MEDIUM']
            ]
        ];

        foreach ($notifications as $notificationData) {
            Notification::create([
                'user_id' => $user->id,
                'type' => $notificationData['type'],
                'title' => $notificationData['title'],
                'message' => $notificationData['message'],
                'is_read' => $notificationData['is_read'],
                'metadata' => $notificationData['metadata'],
                'read_at' => $notificationData['is_read'] ? now() : null,
                'created_at' => now()->subMinutes(rand(5, 1440)) // Random time within last 24 hours
            ]);
        }

        $this->command->info('Sample notifications created successfully!');
    }
} 
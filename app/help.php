<?php

use Illuminate\Support\Facades\DB;
use App\Models\BasicInfo;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\Seo;

if (!function_exists('getContactInfo')) {
    function getContactInfo()
    {
        $settings = BasicInfo::first();

        return [
            'address' => $settings->address ?? 'N/A',
            'address2' => $settings->address2 ?? 'N/A',
            'phone' => $settings->phone_number ?? 'N/A',
            'email' => $settings->email ?? 'N/A',
            'font1' => $settings->font1 ?? 'N/A',
            'font2' => $settings->font2 ?? 'N/A',
            'facebook' => $settings->facebook ?? 'N/A',
            'instagram' => $settings->instagram ?? 'N/A',
            'thread' => $settings->thread ?? 'N/A',
            'pinterest' => $settings->pinterest ?? 'N/A',
            'twitter' => $settings->twitter ?? 'N/A',
            'site_name' => $settings->site_name ?? 'N/A',
            'footer' => $settings->footer ?? 'N/A',
            'image_light' => !empty($settings->image_light)
                ? asset('basicinfo/' . $settings->image_light)
                : asset('client_assets/images/logos/logo-2.webp'),
        ];
    }
}

if (!function_exists('sendRegistrationEmail')) {
    function sendRegistrationEmail($adminEmail, $subject, $emailContent)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'mail.rizester.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'support@rizester.com';
            $mail->Password = 'C75&R&ikAv@?';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SMTPS for port 465
            $mail->Port = 465;

            $mail->setFrom('support@rizester.com', 'Rizester');
            $mail->addAddress($adminEmail);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<html><body>{$emailContent}</body></html>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }


    if (!function_exists('getSeo')) {
        function getSeo($page_name)
        {
            $seo = Seo::where('page_name', $page_name)->first();

            return [
                'meta_title' => $seo?->meta_title ?? '',
                'meta_keywords' => $seo?->meta_keywords ?? '',
                'meta_description' => $seo?->meta_description ?? '',
            ];
        }
    }


    if (!function_exists('getAdminNotifications')) {
        function getAdminNotifications()
        {
            $notifications = DB::table('notifications')->where('status', 0)
                ->latest()
                ->limit(10)
                ->get()
                ->map(function ($notification) {
                    $type = null;
                    $message = null;
                    $icon = null;
                    $color = null;

                    if ($notification->order_id) {
                        $order = DB::table('orders')->where('id', $notification->order_id)->first();
                        $type = 'order';
                        $message = $order ? 'New Order #' . $order->order_id : 'New Order';
                        $icon = 'mdi-cart-outline';
                        $color = 'text-success';
                    } elseif ($notification->user_id) {
                        $user = DB::table('users')->where('id', $notification->user_id)->first();
                        $type = 'user';
                        $message = $user ? $user->name . ' registered' : 'New User Registered';
                        $icon = 'mdi-account-plus';
                        $color = 'text-purple';
                    } elseif ($notification->review_id) {
                        $review = DB::table('product_reviews')->where('id', $notification->review_id)->first();
                        if ($review) {
                            $reviewUser = DB::table('users')->where('id', $review->user_id)->first();
                            $username = $reviewUser ? $reviewUser->name : 'Someone';
                            $type = 'review';
                            $message = $username . ' left a review';
                            $icon = 'mdi-star-outline';
                            $color = 'text-primary';
                        } else {
                            $type = 'review';
                            $message = 'New Product Review';
                            $icon = 'mdi-star-outline';
                            $color = 'text-primary';
                        }
                    }
                    

                    return [
                        'id' => $notification->id,
                        'type' => $type,
                        'message' => $message,
                        'icon' => $icon,
                        'color' => $color,
                        'time' => \Carbon\Carbon::parse($notification->created_at)->diffForHumans(),
                    ];
                });

            return $notifications; // return top 5
        }
    }
}

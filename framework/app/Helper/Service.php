<?php

declare(strict_types=1);

namespace App\Helper;

use Faster\Helper\Service as BaseService;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Service
 * -----------
 * Class for helping access service component
 *
 * @author Khaerul Anas <anasikova@gmail.com>
 * @since v1.0.0
 * @package App\Helper
 */
class Service extends BaseService
{
    /**
     * mailer
     *
     * @param  bool $enableException
     * @return PHPMailer
     */
    public static function mailer(bool $enableException = true): PHPMailer
    {
        $mailer             = new PHPMailer($enableException);
        $mailer->isSMTP();
        $mailer->Host       = smtp_config('host');
        $mailer->SMTPAuth   = true;
        $mailer->Username   = smtp_config('user');
        $mailer->Password   = smtp_config('pass');
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailer->Port       = smtp_config('port');
        
        return $mailer;
    }
}
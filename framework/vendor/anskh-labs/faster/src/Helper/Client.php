<?php

declare(strict_types=1);

namespace Faster\Helper;

/**
 * Client
 * -----------
 * Client
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Helper
 */
class Client
{
    /**
     * getUserAgent
     *
     * @return string
     */
    public static function getUserAgent(): string
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            // Define a regex pattern to match the browser and version
            $pattern = '/(opera|edge|firefox|msie|chrome|safari)[ \/](\d+)/i';

            if (preg_match($pattern, $_SERVER['HTTP_USER_AGENT'], $matches)) {
                $browser = $matches[1];
                $version = $matches[2];
                
                return $browser . ' / ' . $version;
            }
        }

        return 'Other (Unknown) / 1.0.0';
    }
    /**
     * getIpAddress
     *
     * @return string
     */
    public static function getIpAddress(): string
    {
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // to get shared ISP IP address
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ipAddress) {
                if (!empty($ip)) {
                    // if you prefer, you can check for valid IP address here
                    $ip = $ipAddress;
                    break;
                }
            }
        } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // validate ip
        if (filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4 |
                FILTER_FLAG_IPV6 |
                FILTER_FLAG_NO_PRIV_RANGE |
                FILTER_FLAG_NO_RES_RANGE
        ) === false) {
            return '';
        }

        return $ip;
    }
}

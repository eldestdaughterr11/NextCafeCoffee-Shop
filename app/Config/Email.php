<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /*
    |--------------------------------------------------------------------
    | Email Sender Info
    |--------------------------------------------------------------------
    */
    public string $fromEmail  = 'navarezvanryan1@gmail.com';
    public string $fromName   = 'Starvan Coffee';
    public string $recipients = '';

    /*
    |--------------------------------------------------------------------
    | Email Sending Protocol
    |--------------------------------------------------------------------
    */
    public string $userAgent = 'CodeIgniter';
    public string $protocol  = 'smtp';
    public string $SMTPHost  = 'smtp.gmail.com';
    public string $SMTPUser  = 'navarezvanryan1@gmail.com';
    public string $SMTPPass  = 'ypcabvfnrcprhklq'; // Your Gmail App Password (no spaces)
    public int    $SMTPPort  = 587;
    public string $SMTPCrypto = 'tls';
    public bool   $SMTPKeepAlive = false;
    public int    $SMTPTimeout = 5;

    /*
    |--------------------------------------------------------------------
    | Email Formatting
    |--------------------------------------------------------------------
    */
    public bool   $wordWrap = true;
    public int    $wrapChars = 76;
    public string $mailType = 'html';
    public string $charset  = 'utf-8';
    public bool   $validate = false;
    public int    $priority = 3;

    /*
    |--------------------------------------------------------------------
    | Newlines & Batch
    |--------------------------------------------------------------------
    */
    public string $CRLF   = "\r\n";
    public string $newline = "\r\n";
    public bool   $BCCBatchMode = false;
    public int    $BCCBatchSize = 200;

    /*
    |--------------------------------------------------------------------
    | Delivery Status Notification
    |--------------------------------------------------------------------
    */
    public bool $DSN = false;
}

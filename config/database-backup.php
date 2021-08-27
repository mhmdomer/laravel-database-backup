<?php
return [
    /**
     * Email configuration for backups.
     */
    "mail" => [
        /**
         * Specify if an email with the backup file attached should
         * be sent when creating a backup.
         */
        'send' => env('DB_BACKUP_SEND_MAIL', false),

        /**
         * Specify the email that should receive the backup file.
         */
        'to' => env('DB_BACKUP_EMAIL', 'example@example.com')
    ]
];

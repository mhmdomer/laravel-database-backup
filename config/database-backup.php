<?php
return [

    /*
    |-------------------------------------------------------------------------
    | Maximum Backup Files
    |-------------------------------------------------------------------------
    |
    | The maximum number of files that should be present inside the backup folder,
    | each new backup after this limit will result in removing the oldest backup file
    */

    'maximum_backup_files' => 10,

    /*
    |-------------------------------------------------------------------------
    | Mail Settings
    |-------------------------------------------------------------------------
    | Email configuration for backups.
    */

    "mail" => [

        /*
        |-------------------------------------------------------------------------
        | Send Mail
        |-------------------------------------------------------------------------
        | Specify if an email with the backup file attached should
        | be sent when creating a backup.
        */

        'send' => env('DB_BACKUP_SEND_MAIL', false),

        /*
        |-------------------------------------------------------------------------
        | Backup Mail
        |-------------------------------------------------------------------------
        | Specify the email that should receive the backup file.
        */

        'to' => env('DB_BACKUP_EMAIL', 'example@example.com')
    ]
];

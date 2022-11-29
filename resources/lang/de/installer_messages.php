<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title' => 'Bewertungsportal Installer',
    'next' => 'Nächster Schritt',
    'back' => 'Vorheriger Schritt',
    'finish' => 'Installieren',
    'forms' => [
        'errorTitle' => 'Die folgenden Fehler sind aufgetreten:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'title' => 'Willkommen zum Installer',
        'message' => 'Willkommen zum Bewertungsportal Installationsassistent.',
        'next' => 'Anforderungen überprüfen',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'title' => 'Vorraussetzungen',
        'next' => 'Datei/Verzeichnins Berechtigungen überprüfen',
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'title' => 'Berechtigungen',
        'next' => 'Konfiguration',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'title' => 'Konfiguration',
            'desc' => 'Wie möchten Sie die Konfigurationsdatei bearbeiten?',
            'wizard-button' => 'Assistent',
            'classic-button' => 'Text Editor',
        ],
        'wizard' => [
            'title' => 'Konfigurations-Assistent',
            'tabs' => [
                'environment' => 'Umgebung',
                'database' => 'Datenbank',
                'application' => 'Anwendung',
            ],
            'form' => [
                'name_required' => 'Es wird ein Name für die Konfiguration benötigt.',
                'app_name_label' => 'Name der Anwendung',
                'app_name_placeholder' => 'Anwendungsname',
                'app_environment_label' => 'Name der Konfiguration',
                'app_environment_label_local' => 'Lokal',
                'app_environment_label_developement' => 'Entwicklung',
                'app_environment_label_qa' => 'Qualitätsanalyse',
                'app_environment_label_production' => 'Produktion',
                'app_environment_label_other' => 'anderer',
                'app_environment_placeholder_other' => 'anderen Namen eintragen',
                'app_debug_label' => 'Debugging',
                'app_debug_label_true' => 'Ein',
                'app_debug_label_false' => 'Aus',
                'app_log_level_label' => 'Log-Level',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'URL der Webseite',
                'app_url_placeholder' => 'http://localhost:8000',
                'db_connection_failed' => 'Konnte keine Verbindung zur Datenbank aufbauen.',
                'db_connection_label' => 'Datenbankverbindung',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Datenbank-Server',
                'db_host_placeholder' => 'localhost',
                'db_port_label' => 'Datenbank Port',
                'db_port_placeholder' => '3306',
                'db_name_label' => 'Datenbank-Name',
                'db_name_placeholder' => 'sternebewertung',
                'db_username_label' => 'Datenbank-Benutzer',
                'db_username_placeholder' => 'sternebewertung',
                'db_password_label' => 'Datenbank-Passwort',
                'db_password_placeholder' => 'sehr_geheim123',

                'app_tabs' => [
                    'more_info' => 'Mehr Informationen',
                    'broadcasting_title' => 'Broadcasting, Caching, Sitzung, &amp; Queue',
                    'broadcasting_label' => 'Broadcast Treiber',
                    'broadcasting_placeholder' => 'log',
                    'cache_label' => 'Cache-Schnittstelle',
                    'cache_placeholder' => 'file',
                    'session_label' => 'Sitzungs-Verwaltung',
                    'session_placeholder' => 'file',
                    'queue_label' => 'Queue-Verbindung',
                    'queue_placeholder' => 'sync',
                    'redis_label' => 'Redis',
                    'redis_host' => 'Redis Host',
                    'redis_password' => 'Redis Passwort',
                    'redis_port' => 'Redis Port',

                    'mail_label' => 'Mail',
                    'mail_driver_label' => 'Mail Methode',
                    'mail_driver_placeholder' => 'smtp',
                    'mail_host_label' => 'Mailserver',
                    'mail_host_placeholder' => 'smtp.example.com',
                    'mail_port_label' => 'Mailserver Port',
                    'mail_port_placeholder' => '25',
                    'mail_username_label' => 'Mailserver Benutzer',
                    'mail_username_placeholder' => 'user1@example.com',
                    'mail_password_label' => 'Mailserver Passwort',
                    'mail_password_placeholder' => 'sehr_geheim_465',
                    'mail_encryption_label' => 'Verbindungssicherheit',
                    'mail_encryption_placeholder' => 'tls',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher App Id',
                    'pusher_app_id_palceholder' => '',
                    'pusher_app_key_label' => 'Pusher App Key',
                    'pusher_app_key_palceholder' => '',
                    'pusher_app_secret_label' => 'Pusher App Secret',
                    'pusher_app_secret_palceholder' => '',
                ],
                'buttons' => [
                    'setup_database' => 'Datenbank einrichten',
                    'setup_application' => 'Anwendung einrichten',
                    'install' => 'Installieren',
                ],
            ],
        ],
        'classic' => [
            'title' => 'Klassischer Konfigurations-Editor',
            'save' => 'speichere die Konfiguration',
            'back' => 'Den Asisstenten benutzen',
            'install' => 'Speichern und installieren',
        ],
        'success' => 'Ihre Konfiguration wurde erfolgreich gespeichert',
        'errors' => 'Die Konfiguration konnte nicht gespeichert werden!',
    ],

    /*
     *
     * Final page translations.
     *
     */

    'install' => 'Installieren',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Bewertungsportal Installer erfolgreich installiert auf ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Installation abgeschlossen',
        'finished' => 'Die Anwendung wurde erfolgreich installiert.',
        'migration' => 'Migration &amp; Seed Konsolenausgabe:',
        'console' => 'Konsolenausgabe der Anwendung:',
        'log' => 'Log Einträge der Installation:',
        'env' => 'Endgültige Konfigurations-Datei:',
        'exit' => 'Hier klicken zum Beenden',
    ],

    /*
     *
     * Update specific translations
     *
     */
    'updater' => [
        /*
         *
         * Shared translations.
         *
         */
        'title' => 'Bewertungsportal Updater',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title' => 'Willkommen beim Updater',
            'message' => 'Willkommen beim Aktualisierungs-Assistenten.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title' => 'Übersicht',
            'message' => 'Es ist 1 Update verfügbar.|Es sind :number Updates verfügbar.',
            'install_updates' => 'Updates installieren',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'abgeschlossen',
            'finished' => 'Die Datenbank wurde erfolgreich aktualisiert',
            'exit' => 'hier klicken zum Beenden',
        ],

        'log' => [
            'success_message' => 'Bewertungsportal Installer wurde erfolgreich aktualisiert auf ',
        ],
    ],
];

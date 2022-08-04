-- settings
CREATE TABLE settings (
    pk INT GENERATED ALWAYS AS IDENTITY,
    name TEXT NOT NULL,
    type TEXT NOT NULL,
    value TEXT NULL DEFAULT NULL
);

-- default settings
INSERT INTO settings
( name , type , value )
VALUES
-- smtp-related
( 'SMTP_ENABLED' , 'boolean' , 'FALSE' ),
( 'SMTP_HOST' , 'string' , NULL ),
( 'SMTP_PORT' , 'int' , NULL ),
( 'SMTP_USER' , 'string' , NULL ),
( 'SMTP_PASS' , 'string' , NULL ),
( 'SMTP_SECURITY' , 'string' , NULL ),
( 'SMTP_FROM' , 'string' , NULL ),
-- i18n-related
( 'DEFAULT_LANGUAGE' , 'string' , 'en-us' ),
-- storage-related
( 'STORAGE_TYPE' , 'string' , 'local' ),
( 'STORAGE_AWS_REGION' , 'string' , NULL ),
( 'STORAGE_AWS_BUCKET' , 'string' , NULL ),
( 'STORAGE_AWS_KEY' , 'string' , NULL ),
( 'STORAGE_AWS_SECRET' , 'string' , NULL ),
-- accounts-related
( 'REGISTRATION_ENABLED' , 'boolean' , 'false' ),
( 'PASSWORD_RESET_ENABLED' , 'boolean' , 'false' );

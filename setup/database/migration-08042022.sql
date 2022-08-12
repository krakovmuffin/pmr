-- settings
CREATE TABLE settings (
    pk INT GENERATED ALWAYS AS IDENTITY,
    name TEXT NOT NULL,
    type TEXT NOT NULL,
    value TEXT NULL DEFAULT NULL,

    PRIMARY KEY(pk)
);

-- default settings
INSERT INTO settings
( name , type , value )
VALUES
-- smtp-related
( 'SMTP_ENABLED' , 'boolean' , 'false' ),
( 'SMTP_HOST' , 'string' , NULL ),
( 'SMTP_PORT' , 'int' , NULL ),
( 'SMTP_USER' , 'string' , NULL ),
( 'SMTP_PASS' , 'string' , NULL ),
( 'SMTP_SECURITY' , 'string' , NULL ),
( 'SMTP_FROM' , 'string' , NULL ),
-- i18n-related
( 'I18N_DEFAULT_LOCALE' , 'string' , 'en-us' ),
-- storage-related
( 'STORAGE_TYPE' , 'string' , 'local' ),
( 'STORAGE_S3_HOST' , 'string' , NULL ),
( 'STORAGE_S3_REGION' , 'string' , NULL ),
( 'STORAGE_S3_BUCKET' , 'string' , NULL ),
( 'STORAGE_S3_KEY' , 'string' , NULL ),
( 'STORAGE_S3_SECRET' , 'string' , NULL ),
-- accounts-related
( 'ACCOUNT_REGISTRATION_ENABLED' , 'boolean' , 'false' ),
( 'ACCOUNT_PASSWORD_RESET_ENABLED' , 'boolean' , 'false' );

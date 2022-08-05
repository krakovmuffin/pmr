-- users
CREATE TABLE users (
    pk INT GENERATED ALWAYS AS IDENTITY,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    power TEXT NOT NULL,
    language TEXT NOT NULL,
    date_of_birth TIMESTAMPTZ NOT NULL,

    PRIMARY KEY(pk)
);

-- default user
INSERT INTO users
( name , email , password , power , language , date_of_birth )
VALUES
( 'John Doe' , 'john.doe@gmail.com' , '$2a$12$VWrNG4X/V5No03mnzMT7FeQ3z/STgQM6FRTPASJukZSNI8M920jhu' , 'FAMILY_MANAGER' , 'en-us' , NOW() );

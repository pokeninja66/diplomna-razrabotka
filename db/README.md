# Create mysql users:

## admin:
    CREATE USER admin@localhost IDENTIFIED BY '1q2w3e';
***
    GRANT ALL PRIVILEGES ON '*' TO admin@'localhost';
***
    FLUSH PRIVILEGES;

## standard
    CREATE USER standard@localhost IDENTIFIED BY 'EWq!@3';

***
    GRANT SELECT , INSERT ON `_diplomna`.`users` TO 'standard'@'localhost';
    GRANT SELECT, INSERT, UPDATE, DELETE ON `_diplomna`.`user_posts` TO 'standard'@'localhost';

***
    FLUSH PRIVILEGES;

## readOnly:
    CREATE USER readOnly@localhost IDENTIFIED BY 'qwer1234';
***
    GRANT SELECT ON `_diplomna`.`users` TO 'readOnly'@'localhost';
    GRANT SELECT ON `_diplomna`.`user_posts` TO 'readOnly'@'localhost';
***
    FLUSH PRIVILEGES;
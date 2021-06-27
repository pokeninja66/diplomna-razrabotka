# User info for login:

admin:
- username:  adm
- password: 1q@W3e

normal user:
- username: pokeninja
- password: 1q@W3e
  

***

## admin path
/admin
- can view and delete users
- can view /edit /delete posts

***
## tests
/tests
- hash
- encryption
- decryption
  
***
  
# MySQL Users

- admin
  - this is the main system user. It has all the database privileges
- standard
  - this user can only `SELECT` & `INSERT` from the *users* table.
  - this user can `INSERT`, `SELECT`, `UPDATE` & `DELETE` from the *user_posts* table
- readOnly
  - this user can only `SELECT` from the tables

# Week 7 - Secure auth (password_hash, password_verify, registration)

## Contents
- `register.php` — registration with password_hash() + email validation
- `login.php` — login using password_verify() against hashed passwords
- `logout.php` — session destroy and redirect
- All previous week6 files carried forward (CRUD, orders, ratings)
- `week7_schema.sql` — documents security changes

## Security Improvements
- Passwords stored as bcrypt hashes (not plain text)
- Email format validated with filter_var()
- Empty field checks and password strength (min 6 chars)
- Duplicate username/email detection
- Login error messages for failed attempts

# 🏋️‍♂️ Smart Gym Subscription System

A PHP + MySQL + TAILWIND CSS +JS application for managing **gym subscriptions, payments, and users**, including features like:

- User registration & login  
- Subscription & payment history  
- Receipt generation (PDF download)  
- Password reset with **secure token + PHPMailer (SMTP via Gmail)**  
- CSRF protection & environment variable support  

---

## 🚀 Features

- **Authentication**
  - Register / login
  - Secure password hashing (`password_hash`)
  - CSRF token validation

- **Password Reset**
  - Sends reset link via **PHPMailer**
  - Token expiry & reset validation
  - Secure password update with bcrypt

- **Receipts**
  - Generate PDF receipts using mPDF / Dompdf
  - Auto-download feature

- **Database**
  - MySQL with prepared statements
  - `users`, `payment_history`, `receipts` tables

---

## 📸 Screenshots

### 🔑 Login Page
![Login Page](screenshots/login page.png)

### 📧 Password Reset Request
![Password Reset Request](docs/screenshots/reset-request.png)

### 🔒 Reset Password Form
![Reset Password Form](docs/screenshots/reset-form.png)

### 🧾 PDF Receipt Example
![Receipt PDF](docs/screenshots/receipt-pdf.png)

👉 *To add your own screenshots:*  
1. Create a folder `docs/screenshots/` in your project root.  
2. Save images as `.png` or `.jpg`.  
3. Replace the placeholder links above with your actual file names.  

---

## 📂 Project Structure

``` 
public
 ┣ admin
 ┃ ┣ admin.php
 ┃ ┣ adminlogout.php
 ┃ ┣ attendanceList.php
 ┃ ┣ blacklist.php
 ┃ ┣ fetch.js
 ┃ ┣ fetch.php
 ┃ ┣ main.js
 ┃ ┣ members.js
 ┃ ┣ members.php
 ┃ ┣ payments.php
 ┃ ┣ subscriptionTarifs.php
 ┃ ┣ tariffs.js
 ┃ ┣ trainerList.php
 ┃ ┣ blacklist.js
 ┃ ┗ trainers.js
 ┣ images
 ┃ ┣ favicon.jpg
 ┃ ┗ image1.jpg
 ┣ js
 ┃ ┣ autho.js
 ┃ ┣ csrf.js
 ┃ ┣ csrfmain.js
 ┃ ┣ logout.js
 ┃ ┣ logoutmain.js
 ┃ ┣ main.js
 ┃ ┣ mainmain.js
 ┃ ┣ profile.js
 ┃ ┣ session_status.js
 ┃ ┣ session_statusmain.js
 ┃ ┣ settings.js
 ┃ ┣ plancontainer.js
 ┃ ┣ subscription_sugestion.js
 ┃ ┣ subscription_sugestionmain.js
 ┃ ┣ payment_history.js
 ┃ ┣ resetPassword.js
 ┃ ┗ sendresetEmail.js
 ┣ php
 ┃ ┣ csrfTokenGenerator.php
 ┃ ┣ csrfTokenGeneratormain.php
 ┃ ┣ db_connect.php
 ┃ ┣ functions.php
 ┃ ┣ insertData.php
 ┃ ┣ logout.php
 ┃ ┣ logoutmain.php
 ┃ ┣ payment.php
 ┃ ┣ profile.php
 ┃ ┣ profileData.php
 ┃ ┣ session_status.php
 ┃ ┣ session_statusmain.php
 ┃ ┣ settings.php
 ┃ ┣ fetchplan.php
 ┃ ┣ subscriptionstatus.php
 ┃ ┣ payment_history.php
 ┃ ┣ receipt.php
 ┃ ┣ resetPassword.php
 ┃ ┗ sendresetEmail.php
 ┣ index.html
 ┗ main.css
```

# Frusion - fruit purchase

## Introduction
This document provides an overview of the Frusion application, an online fruit purchasing platform using Docker containers. It will make the work of people with a collection point and their customers easier. The application consists of several containers, each of which serves a specific purpose.

## Docker Containers

#### NGINX (Web Server):</br>
Responsible for serving static files and handling HTTP requests.</br>

#### PHP:</br>
Manages dynamic content and interactions on the server-side.</br>

#### PostgreSQL (pgsql):</br>
A database container for storing user information, transactions, and other relevant data.</br>

#### pgAdmin4:</br>
Provides a web-based interface for PostgreSQL administration.</br>

## Application Features
### User Authentication
#### Login and Registration Views:

##### Registration Process
 1. User data: Users provide their registration data in the registration form, including e-mail address, password, telephone number and branch name.
 2. Administrator-side verification: JavaScript scripts on the website ensure that the entered email address and phone number are in the correct format and that passwords meet the requirements for minimum length (e.g. 4 characters) and special characters (e.g. 1 special character). They also check whether the entered passwords are identical and whether all fields are completed.
 3. Server-Side Verification: The server verifies if the email is unique. If the email is already registered, an error message is returned.
 4. Password Hashing: Before storing the user's information in the database, the system securely hashes the password to enhance data security.
 5. Registration Decision: If the email is unique, the user is redirected to the login page, indicating successful registration. If there are validation errors or the email is not unique, an error message is displayed to the user, and they are prompted to correct the information.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/9569b93a-d982-457a-8e95-da582521e99e)

##### Login Process
 1. Users provide their email and password for authentication.
 2. The system communicates with the PostgreSQL database to verify the existence of the provided email and its corresponding password.
 3. Authentication Decision: If the email and password match, the server grants access, allowing the user to proceed. If there is no match or an error occurs, the server returns an error message, indicating unsuccessful authentication.
 4. You can log in to two types of accounts: the buyer and the customer. In order to check what type of account the person logging in has, both tables are checked: User and Admin and it is checked which table the email is assigned to.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/54cb5056-4e7d-4f6f-aa8d-900dc1d329a2)

#### Logout process 
After clicking the "Log out" button in the menu, cookies are deleted and you are redirected to the login page.

### Admin

##### View of the home page on the buyer's side
On the home page there is a sidebar with a menu. And the main part shows one day of purchasing. We can see the purchase name of the logged in admin. There is a calendar that allows you to select a specific day and transactions and a summary are automatically displayed.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/2e3ff40b-6eae-4e42-8b0e-708894b7a4b7)

 1. After pressing the "buy fruit" button, a window is displayed that allows you to add a transaction. We enter the necessary data there to be checked. For example, it is checked whether the entered user is a client of the currently logged in admin.
 2. When adding a transaction, a "transaction" is started to avoid errors while adding it.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/449ff178-9398-406d-b6b5-40ec32ceab76)

##### View of status frusion
It is possible to select an end date and a start date. After selecting both, a summary of the necessary invoicing data for that period is displayed

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/351ef937-d2b5-423e-9c71-9f3ac152b54d)

##### View of fruit
On the left side, a list of the main panel available on the administration panel is displayed. The admin has several options to choose from: he can change the price of the fruit, download the fruit and remove the fruit.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/e44c215b-3952-48c0-891f-521bb5c1588a)

#### View of boxes
On the left side, you can see the list of mailboxes of the currently logged in admin. On the right, there are options thanks to which the admin can add a mailbox, setting its weight, and remove a mailbox from the list.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/40a9160c-0b94-4839-b3ea-f57e5669c081)


#### View of clients
In this view, the admin can add a customer by entering his details. If a user with the given email address already exists in the logged in admin's user list, appropriate information is displayed.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/501e74ba-2c90-4341-b685-8aa1bd83c211)

### Client

#### Views of home
In the view on the left, general, from all days. However, on the right side we see individual transactions made by the logged in customer. They apply to all purchases attended by the customer.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/d29642b2-91f5-4eb3-b2e3-4322cfc07d3b)

#### Views of change password
The user can change the password to a different one. To do this, enter the password and the new password and repeat it. Validation of data available via JavaScript, including the current password and the new password cannot be identical or similar. When creating an account, the password must contain at least 4 characters, one special character and one number.

![image](https://github.com/siwkoedyta/Frusion/assets/127204259/569ff7e3-0c81-4f6c-b9d3-5134653b0630)


### Getting Started
Clone the repository: git clone https://github.com/siwkoedyta/Frusion.git
Navigate to the project directory: cont
Run Docker Compose: docker-compose up
Access the application through your web browser.

### Dependencies
1. Docker
2. Docker Compose

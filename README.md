# Laravel api integration to Africatalks sms SDK
## Installation

* clone this project into your machine
  ```
  git clone https://github.com/KimelirR/AfricasTalking-laravel-sms.git
  ```

* Install project dependencies

  ```php
   composer install
  ```

  ```javascript
    npm install
  ```

* Create .env file through copy
  ```
    cp .env.example .env
  ```
 
 

* Provide database credentials below in .env file.
  ```
     DB_DATABASE=?
     DB_USERNAME=?
     DB_PASSWORD=?
  ```


* **Provide Africatalk credentials below in .env file**
  ```
     AT_USERNAME="YOUR_USERNAME"
     AT_KEY="YOUR_API_KEY"
     AT_FROM="FROM_CODE"
  ```

* Run migrations
    ```php
    php artisan migrate 
    ```

* Generate key for laravel new application you have installed.
    ```php
    php artisan key:generate && php artisan config:cache
    ```
> Congratulations you have installed laravel app successfully!

* **On terminal split into two**
    * First one || Start our laravel app
      ```php
       php artisan server
      ```
    * Second One || Run vite 
      ```php
       npm run build
      ```

* __*On Postman*__

  * Our api endpoint [http://127.0.0.1:8000/api/africatalks/sendsms]

  * Set the headers as following

    ![alt text](https://github.com/KimelirR/AfricasTalking-laravel-sms/blob/master/public/images/screenshot1.png?raw=true)

  * Set the body this way...Url_encoded

    ![alt text](https://github.com/KimelirR/AfricasTalking-laravel-sms/blob/master/public/images/screenshot2.png?raw=true)



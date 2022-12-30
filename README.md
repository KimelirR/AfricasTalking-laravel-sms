<div>
<p>You will start by cloning this project into your machine</p> 


~~~
cp .env.example .env
~~~
 
~~~
composer install
~~~

**Provide credentials below in .env file**

     DB_DATABASE=?
     DB_USERNAME=?
     DB_PASSWORD=?


**Provide Africatalk credentials below in .env file**

     AT_USERNAME="YOUR_USERNAME"
     AT_KEY="YOUR_API_KEY"
     AT_FROM="FROM_CODE"

Run to set those tables which represent models
~~~
php artisan migrate 
~~~

~~~
npm install
~~~

~~~
npm run dev
~~~
 Generate key for laravel new application you have installed.
~~~
php artisan key:generate && php artisan config:cache
~~~

Congratulations you have installed successfully!

~~~
php artisan serve 
~~~

*On Postman*

Api endpoint [http://127.0.0.1:8000/api/africatalks/sendsms]

Set the headers as following
![alt text](https://github.com/KimelirR/AfricasTalking-laravel-sms/blob/master/public/images/screenshot1.png?raw=true)

Set the body this way...Url_encoded
![alt text](https://github.com/KimelirR/AfricasTalking-laravel-sms/blob/master/public/images/screenshot2.png?raw=true)


</div>


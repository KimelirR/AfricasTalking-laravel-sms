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

## Start Our application
* __*On terminal split into two*__
    * First one || Start our laravel app
      ```php
       php artisan server
      ```
    * Second One || Run vite 
      ```php
       npm run build
      ```

## Postman configuration
* __*On Postman*__

  * Our post api endpoint [http://127.0.0.1:8000/api/africatalks/sendsms]

  * Set the __headers__ as following

    ![alt text](https://github.com/KimelirR/AfricasTalking-laravel-sms/blob/master/public/images/screenshot1.png?raw=true)

  * Set the __body__ this way...Url_encoded

    ![alt text](https://github.com/KimelirR/AfricasTalking-laravel-sms/blob/master/public/images/screenshot2.png?raw=true)

> ! Lastly send messages. The end


# Edited controller to support delivery report

* When Message receivers are more than 1
```php
       $object = json_decode(json_encode($result), false);
        //We save data from response to ensure
        $response_array = $object->data->SMSMessageData->Recipients;
        $message = $request->input('message');

        $count = count($response_array);

        if($count > 1){

            #Initialize array to save since multisave to database
            $saved = [];
            foreach ($response_array as $row) :

                $data->to = $row->number;
                $data->message = $message;
                $data->delivery_status = $row->status;
                if($data->delivery_status == "Success"){
                    $data->delivery_status = 1;
                }
                else{
                    $data->delivery_status = 0;
                }
                $data->created_at =Carbon::now()->format('Y-m-d h:i:s');
                $data->updated_at = date('Y-m-d h:i:s');
                $saved[] = [
                    'to'=>$data->to,
                    'message'=> $data->message,
                    'delivery_status'=> $data->delivery_status,
                    'created_at'=>$data->created_at,
                    'updated_at' => $data->updated_at
                ];

            endforeach;
            // SAVE TO DATABASE FOR BACKUP
            AfricaTalk::insert($saved);

```

* When Sending Message to One receiver

```php
    $number = $response_array[0]->number;
    $status = $response_array[0]->status;
    //SAVE TO DATABASE FOR BACKUP
    $data->to = $number;
    $data->message = $message;
    $data->delivery_status = $status;
    if($data->delivery_status == "Success"){
        $data->delivery_status = 1;
    }
    else{
        $data->delivery_status = 0;
    }
    $data->save();
```

> Migration defualt 0 which represent 'Failed'

```php
  $table->tinyInteger('delivery_status')->default(0);

```




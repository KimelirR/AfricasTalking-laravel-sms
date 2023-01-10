<?php

namespace App\Http\Controllers;


use Exception;
use Carbon\Carbon;
use App\Models\AfricaTalk;
use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Validator;

class AfricaTalkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          // Set your app credentials
        $username  = config('services.africastalking.username');
        $apiKey    = config('services.africastalking.key');
        $from      = config('services.africastalking.from');

        $validator = Validator::make($request->all(), [
            'to' => 'required',
            'message' => 'required',
            'delivery_status' => 'nullable'
        ]);

        if ($validator->fails()) {
            $errors = implode(" ", $validator->errors()->all());
            return response(['status' => 'error', 'message' => $errors]);
        }

            try {

                $data = new AfricaTalk;

                // Initialize africatalks  SDK
                $AT         = new AfricasTalking($username, $apiKey);
                $sms        = $AT->sms();
                //Send message
                $result = $sms->send([
                    'to'      => $request->input('to'),
                    'message' => $request->input('message'),
                    'from'    => $from
                ]);

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

                 }
                 else{
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
                 }

                return response()->json(['response' => $result], 200);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AfricaTalk  $africaTalk
     * @return \Illuminate\Http\Response
     */
    public function show(AfricaTalk $africaTalk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AfricaTalk  $africaTalk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AfricaTalk $africaTalk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AfricaTalk  $africaTalk
     * @return \Illuminate\Http\Response
     */
    public function destroy(AfricaTalk $africaTalk)
    {
        //
    }
}

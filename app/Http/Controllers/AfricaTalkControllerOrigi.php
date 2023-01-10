<?php

namespace App\Http\Controllers;

use Exception;
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

        // Initialize the SDK
        $AT         = new AfricasTalking($username, $apiKey);
        $sms        = $AT->sms();

        $validator = Validator::make($request->all(), [
            'to' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = implode(" ", $validator->errors()->all());
            return response(['status' => 'error', 'message' => $errors]);
        }

        $data = new AfricaTalk();
        if ($data) {
            try {
                //SAVE TO DATABASE FOR BACKUP
                $data->to = $request->input('to');
                $data->message = $request->input('message');
                $data->save();

                $result = $sms->send([
                    'to'      => $request->input('to'),
                    'message' => $request->input('message'),
                    'from'    => $from
                ]);

                return response()->json(['response' => $result], 200);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

        } else {
            return response()->json(['status' => 'error', 'message' => 'Technical error ocurred , contact administrator.'], 404);
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

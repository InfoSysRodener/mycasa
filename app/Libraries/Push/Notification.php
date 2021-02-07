<?php


namespace App\Libraries\Push;


use Aws\Sns\Exception\SnsException;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;


class Notification
{

    public static function sendToArn($message,$device,$payload = [], $category = "mycasa", $title = "MyCasa")
    {
        try{
            $client = App::make('aws')->createClient('sns');

            // re-enable first
            $result = $client->setEndpointAttributes([
                'Attributes' => ['Enabled' => 'true'],
                'EndpointArn' => $device['arn'],
            ]);


            //ios
            $apnsPayload = json_encode(
                (object) [
                    'aps' =>
                        (object) [
                            'alert' => (object) [
                                'title' => $title,
                                'body' => $message
                            ],
                            'category' => $category,
                            'sound' => 'default',
                            'data' => (object) $payload
                        ]
                ]);

             //android
             $gcmPayload = json_encode(
                    (object) [
                        'notification' => (object) [
                            'body' => $message,
                            'title' => $title,
                            'sound' => 'default',
                        ],
                        'category' => $category,
                        'data' => (object) $payload,
                        'time_to_live'      => 3600,
                 ]);


            $platformApplicationArn = '';
            if ($device['platform'] == 'android'){
                $default = ($gcmPayload);
            } else {
                $default = ($apnsPayload);
            }

            $message = json_encode(['GCM' => $gcmPayload, 'APNS' => $apnsPayload, 'APNS_SANDBOX' => $apnsPayload, 'default' => $default]);

            /**
             * Publish a message
             */
            $client->publish(array(
                'TargetArn'         => $device['arn'],
                'Message'           => $message,
                'ttl'               => 60,
                'MessageStructure'  => 'json'
            ));

            // // re-enable first
            // $result = $client->setEndpointAttributes([
            //     'Attributes' => ['Enabled' => 'true'],
            //     'EndpointArn' => $device['arn'],
            // ]);

        }catch (SnsException $e){

            \Log::error('SNS: '.$e->getMessage());
            return response()->json(['error' => "Unexpected Error"], 500);
        }


    }

    public static function registerToken($deviceToken, $platform = 'ios')
    {
        try {

            if ($platform === 'android') {
                $platformApplicationArn = 'arn:aws:sns:ap-southeast-1:851182740742:app/GCM/Android';
            }else{
                $platformApplicationArn = 'arn:aws:sns:ap-southeast-1:851182740742:app/APNS/Ios-prod';
//                $platformApplicationArn = 'arn:aws:sns:ap-southeast-1:851182740742:app/APNS_SANDBOX/ios-dev';
            }

            $client = App::make('aws')->createClient('sns');

            // dd($client);
            $result = $client->createPlatformEndpoint(array(
                'PlatformApplicationArn' => $platformApplicationArn,
                'Token' => $deviceToken,
            ));

            // dd($result);
            return $result;

        } catch (Exception $e) {

            Log::info($e->getMessage());
        }
    }

    /**
     * Subscribe To A Topic
     *
     */
    public static function subscribe($endpointArn)
    {
        $topicArn = 'arn:aws:sns:ap-southeast-1:851182740742:SendMessage';
        $sns = App::make('aws')->createClient('sns');

        $result = $sns->subscribe([
            'Endpoint' => $endpointArn,
            'Protocol' => 'application',
            'TopicArn' => $topicArn
        ]);
        return $result['SubscriptionArn'] ?? '';
    }

    /**
     * Unsubscribe on
     *
     */
    public static function unSubscribe($arn,$subscription_arn)
    {
        $sns = App::make('aws')->createClient('sns');

        $sns->unsubscribe([
            'SubscriptionArn' => $subscription_arn,
        ]);
        $sns->deleteEndpoint([
            'EndpointArn' => $arn
        ]);
    }
}

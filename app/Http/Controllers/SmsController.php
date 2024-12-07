<?php

namespace App\Http\Controllers;

use App\Models\SendAttempt;
use App\Http\Controllers\SmsTransactionController;
use Illuminate\Support\Facades\Log;


class SmsController extends Controller
{

    protected $smsTransactionController;

    /**
     * Constructor for injecting SmstransactiController
     */
    public function __construct(SmsTransactionController $smsTransactionController)
    {
        $this->smsTransactionController = $smsTransactionController;
    }


    /**
     * Method for processing pending SMS attempts
     */
    public function processPendingSmsAttempts()
    {
        //Recover all pending SMS attempts
        $pendingAttempts = SendAttempt::where('status', 'pending')->get();

        foreach ($pendingAttempts as $sendAttempt) {
            try {
                // Recover specific data from the Sendattempt model
                $phone = $sendAttempt->phone;
                $message = $sendAttempt->message;

                // Send SMS using the existing method in SMStransactiController
                $response = $this->smsTransactionController->sendSMS($phone, $message);

                // Verify and update the status of SMS attempt
                $this->updateSmsAttemptStatus($sendAttempt, $response);

            } catch (\Exception $e) {
                // Handle errors in SMS sending
                $this->handleSmsError($sendAttempt, $e);
            }
        }
    }


    /**
     * Method to update the status of SMS attempt
     *
     * @param SendAttempt $sendAttempt SMS attempt
     * @param mixed $response SMS shipping response
     */
    private function updateSmsAttemptStatus(SendAttempt $sendAttempt, $response)
    {
        try {
            // Extract the message shipping id from the answer
            $id_send_message = $response->getData()->response->result[0]->id;

            // Update SMS's attempt with a state 'feel'
            $sendAttempt->update([
                'status' => 'sent',
                'response_id' => $id_send_message,
                'aditional_data' => json_encode($response)
            ]);

        } catch (\Exception $e) {
            // Manejar errores en la actualización
            Log::error('Error actualizando intento de SMS: ' . $e->getMessage());
        }
    }

        /**
     * Method for handling errors in SMS sending
     *
     * @param SendAttempt $sendAttempt SMS attempt
     * @param \Exception $exception Captured exception
     */
    private function handleSmsError(SendAttempt $sendAttempt, \Exception $exception)
    {
        try {
            // Update SMS attempt with a state 'processed'
            $sendAttempt->update([
                'status' => 'processed',
                'aditional_data' => json_encode([
                    'error' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ])
            ]);

            // Register the error
            Log::error('Error en envío de SMS: ' . $exception->getMessage());

        } catch (\Exception $e) {
            // Handle any additional error during registration
            Log::error('Error crítico procesando SMS fallido: ' . $e->getMessage());
        }
    }

    public function indexIndividualSMS()
    {
        return view('sms_individual');
    }


    public function index_smsview() {
        $sendAttempts = SendAttempt::paginate(15);
        return view('sms_attemptview', compact('sendAttempts'));
    }

}

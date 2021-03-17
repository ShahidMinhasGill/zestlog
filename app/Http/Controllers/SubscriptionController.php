<?php

namespace App\Http\Controllers;

use App\Models\FinalPayment;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Stripe;
use App\Traits\ZestLogTrait;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    use ZestLogTrait;

    public function savePaymentStripe(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'amount' => 'required',
            'currency' => 'required',
            'card_number' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',
            'client_id' => 'required',
            'unique_id' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        }else{
            $uniqueId = $request->input('unique_id');

            $ObjFinalPayment = FinalPayment::select('charge_id', 'u.id', 'u.user_name', 'final_payments.reference_number')
                ->join('users as u', 'u.id', 'final_payments.client_id')
                ->where('unique_id', $uniqueId)
                ->first();
            $referenceNumber = '';
            if(!empty($ObjFinalPayment)){
                if (!empty($ObjFinalPayment->reference_number)) {
                    $referenceNumber = $ObjFinalPayment->reference_number;
                }
                if (empty($ObjFinalPayment['charge_id'])) {
                    $userId = $this->userId;
                    $userName = User::find($userId)->user_name;
                    $descriptionString = 'Coach:' . $ObjFinalPayment['user_name'] . ', Client:' . $userName . ', Booking Reference Number:' . $referenceNumber;
                    $amount = $request->input('amount');
                    $currency = $request->input('currency');
                    $cardNumber = $request->input('card_number');
                    $expMonth = $request->input('exp_month');
                    $expYear = $request->input('exp_year');
                    $cvs = $request->input('cvc');
                    $amount = $amount * 100;
                    $stripe = Stripe\Stripe::setApiKey(getenv('STRIPE_KEY'));
                    try {
                        DB::beginTransaction();
                        $response = \Stripe\Token::create(array(
                            'card' => [
                                'number' => $cardNumber,
                                'exp_month' => $expMonth,
                                'exp_year' => $expYear,
                                'cvc' => $cvs,
                            ],
                        ));
                        if (!empty($response['id'])) {
                            $charge = \Stripe\Charge::create([
                                'card' => $response['id'],
                                'currency' => $currency,
                                'amount' => $amount,
                                'description' => $descriptionString,
                                'metadata' => ['Coach' => $ObjFinalPayment['user_name'], 'Client' => $userName, 'BookingReference' => $referenceNumber],
                            ]);
                            if ($charge['status'] == 'succeeded') {
                                FinalPayment::where('user_id', $userId)
                                    ->where('unique_id', $uniqueId)
                                    ->update(['charge_id' => $charge['id']]);
                                $this->success = true;
                                $this->message = 'Payment Save Successfully';
                            }
                        }
                        DB::commit();
                        // Use Stripe's library to make requests...
                    } catch (\Stripe\Exception\CardException $e) {
                        $this->success = false;
                        $this->message = 'Incorrect card information. Please try again.';
                        DB::rollback();
                    } catch (\Stripe\Exception\RateLimitException $e) {
                        $this->success = false;
                        $this->message = $e->getError()->message;
                        DB::rollback();
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        $this->success = false;
                        $this->message = $e->getError()->message;
                        DB::rollback();
                    } catch (\Stripe\Exception\AuthenticationException $e) {
                        $this->success = false;
                        $this->message = $e->getError()->message;
                        DB::rollback();
                    } catch (\Stripe\Exception\ApiConnectionException $e) {
                        $this->success = false;
                        $this->message = $e->getError()->message;
                        DB::rollback();
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        $this->success = false;
                        $this->message = $e->getError()->message;
                        DB::rollback();
                    } catch (Exception $e) {
                        $this->success = false;
                        DB::rollback();
                    }

                } else {
                    $this->message = 'Payment Already received for this plan';
                }
            }else{
                $this->message = 'Something went wrong, please try again later';
                $params['message'] = 'There is some issue in payments of User_id: ' . $request->input('user_id') . ' and Coach_id: ' . $request->input('client_id') . ' with Unique_id = ' . $request->input('unique_id');
                $params['view'] = 'mail';
                $params['to_email'] = 'arash.aaria@gmail.com';
                $params['subject'] = 'Booking Payment Issue';
                $data = array('verification_code' =>  $params['message']);
                \Mail::send(['text' => $params['view']], $data, function ($message) use ($params) {
                    $message->to($params['to_email'], 'Email')
                        ->subject($params['subject']);
                    $message->from('noreply@zestlog.com', 'Zestlog');
                });
            }

        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
}

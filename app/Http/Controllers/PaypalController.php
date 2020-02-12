<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Donation;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;

    use PayPal\Api\Amount;
    use PayPal\Api\Details;
    use PayPal\Api\Item;
    use PayPal\Api\ItemList;
    use PayPal\Api\Payer;
    use PayPal\Api\Payment;
    use PayPal\Api\PaymentExecution;
    use PayPal\Api\RedirectUrls;
    use PayPal\Api\Transaction;
    use PayPal\Auth\OAuthTokenCredential;
    use PayPal\Rest\ApiContext;
    use Redirect;
    use Session;
    use URL;


    class PaypalController extends Controller
    {
        private $_api_context;
        public function __construct(){
            $paypal_conf = \Config::get('paypal');
            $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
            );
            $this->_api_context->setConfig($paypal_conf['settings']);
            
        }
        public function get(){
            $donations = Donation::paginate(20);
            return response()->json(['message' => "Operação realizada com sucesso.", 'donations' => $donations,'success' => true]);
        }
        public function donate(Request $request) {
          

            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric',
                
            ]);
            if($validator->fails()){
                return response()->json([$validator->errors(), 'success' => false], 400);
            }
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $item_1 = new Item();
            $item_1->setName('Doação para APNA')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->amount);
            $item_list = new ItemList();
            $item_list->setItems(array($item_1));
            $amount = new Amount();
            $amount->setCurrency('USD')
            ->setTotal($request->amount);
            $transaction = new Transaction();
            $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Doação para APNA - Be grand');
            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::route('landing'))
            ->setCancelUrl(URL::route('landing'));
            $payment = new Payment();
            $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
            try {
                $payment->create($this->_api_context);
            } catch (\Paypal\Exception\PPConectionExecption $ex) {
               if (\Config::get('app.debug')){
                    \Session::put('error_paypal', 'Falha na conexão.');
                    return Redirect::route('/');
               }
               else{
                \Session::put('error_paypal', 'Falha ao tentar realizar a doação.');
                return Redirect::route('/');
                }
            }
            foreach ($payment->getLinks() as $link) {
                if($link->getRel()== 'approval_url'){
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            if (isset($redirect_urls)){
                return Redirect::away($redirect_url);
            }
            \Session::put('error_paypal', 'Erro desconhecido.');
            return Redirect::route('/');
        }
    
        public function getStatus()
        {
            /** Get the payment ID before session clear **/
            $payment_id = Session::get('paypal_payment_id');
    
            /** clear the session payment ID **/
            Session::forget('paypal_payment_id');
            if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
    
                \Session::put('error', 'Payment failed');
                return Redirect::to('/');
    
            }
    
            $payment = Payment::get($payment_id, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId(Input::get('PayerID'));
    
            /**Execute the payment **/
            $result = $payment->execute($execution, $this->_api_context);
    
            if ($result->getState() == 'approved') {
    
                \Session::put('success', 'Payment success');
                return Redirect::to('/');
    
            }
    
            \Session::put('error', 'Payment failed');
            return Redirect::to('/');
    
        }
    }
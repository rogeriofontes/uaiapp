<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Checkout;
use App\Plan;
use PagSeguro;

class PagSeguroController extends Controller
{
    public function __construct()
    {
        /**
         * contato@uaiapp.com.br
         * Aa248302Aa
         */
    }

    public function payment($dados, $userAccess)
    {
        $checkout = Checkout::create([
            'paymentMethod' => ($dados['paymentMethod']) ?? NULL,
            'plan_id'       => $dados['plan_id'],
            'product_id'    => $dados['product_id'],
            'user_app_id'   => $userAccess->getPerson->getUserApp->id
        ]);

        $plan = Plan::find($dados['plan_id']);

        if($plan->price > 0){

            $senderCpfCnpj = 'senderCPF';

            if ($dados['paymentMethod'] == 1) {
                $pagseguro = PagSeguro::setReference($checkout->id)->setSenderInfo([
                    'senderName' => $userAccess->getPerson->name,
                    'senderPhone' => $userAccess->phone,
                    'senderEmail' => $userAccess->email,
                    'senderHash' => $dados['senderHash'],
                    $senderCpfCnpj => $dados['cpf_cnpj']
                ])->setCreditCardHolder([
                    'creditCardHolderName' => $dados['name'],
                    'creditCardHolderBirthDate' => date("d/m/Y", strtotime($userAccess->getPerson->birthday))
                ])->setShippingAddress([
                    'shippingAddressStreet' => $userAccess->getPerson->getAddress->address,
                    'shippingAddressNumber' => $userAccess->getPerson->getAddress->number,
                    'shippingAddressDistrict' => $userAccess->getPerson->getAddress->neighborhood,
                    'shippingAddressPostalCode' => $userAccess->getPerson->getAddress->cep,
                    'shippingAddressCity' => $userAccess->getPerson->getAddress->getCity->city,
                    'shippingAddressState' => $userAccess->getPerson->getAddress->getCity->getState->state
                ])->setItems([
                    [
                    'itemId' => $checkout->id,
                    'itemDescription' => $checkout->getPlan->plan . '- Uai App',
                    'itemAmount' => $checkout->getPlan->price,
                    'itemQuantity' => '1',
                    ]
                ])->send([
                    'paymentMethod' => 'creditCard',
                    'creditCardToken' => $dados['creditCardToken'],
                    'installmentQuantity' => '1',
                    'installmentValue' => $checkout->getPlan->price
                ]);
            } else if ($dados['paymentMethod'] == 2) {
                $pagseguro = PagSeguro::setReference($checkout->id)->setSenderInfo([
                    'senderName' => $userAccess->getPerson->name,
                    'senderPhone' => $userAccess->phone,
                    'senderEmail' => $userAccess->email,
                    'senderHash' => $dados['senderHash'],
                    $senderCpfCnpj => $dados['cpf_cnpj']
                ])->setShippingAddress([
                    'shippingAddressStreet' => $userAccess->getPerson->getAddress->address,
                    'shippingAddressNumber' => $userAccess->getPerson->getAddress->number,
                    'shippingAddressDistrict' => $userAccess->getPerson->getAddress->neighborhood,
                    'shippingAddressPostalCode' => $userAccess->getPerson->getAddress->cep,
                    'shippingAddressCity' => $userAccess->getPerson->getAddress->getCity->city,
                    'shippingAddressState' => $userAccess->getPerson->getAddress->getCity->getState->state
                ])->setItems([
                    [
                    'itemId' => $checkout->id,
                    'itemDescription' => $checkout->getPlan->plan . '- Uai App',
                    'itemAmount' => $checkout->getPlan->price,
                    'itemQuantity' => '1',
                    ]
                ])->send([
                    'paymentMethod' => 'boleto'
                ]);
            } else {
                //DÉBITO
            }
                
            $checkout->code_pagseguro = $pagseguro->code;
            $checkout->date_pagseguro = date('Y-m-d H:i:s', strtotime($pagseguro->lastEventDate));
            $checkout->status = $pagseguro->status;
            $checkout->link_boleto = $pagseguro->paymentLink;
            $checkout->update();
            
            if ($checkout->status == 'ACTIVE' || $checkout->status == 3) {
                $checkout->getProduct->status = '1';
                $dateNow = Carbon::now();
                $checkout->getProduct->date_end = $dateNow->addDays($checkout->getPlan->days);
                $checkout->getProduct->update();
            }
        }else{
            $checkout->status = 3;
            $checkout->date_pagseguro = date('Y-m-d H:i:s');
            $checkout->update();

            $checkout->getProduct->status = '1';
            $dateNow = Carbon::now();
            $checkout->getProduct->date_end = $dateNow->addDays($checkout->getPlan->days);
            $checkout->getProduct->update();
        }

        return $checkout;
    }

    public function returnInfo(Request $request)
    {
        $dados = $request->all();

        $notification   = PagSeguro::notification($request->notificationCode, $request->notificationType);
        $checkout       = Checkout::find($notification->reference);
        $checkout->date_pagseguro = date('Y-m-d H:i:s', strtotime($notification->lastEventDate));
        $checkout->status         = $notification->status;
        $checkout->update();

        if($checkout->status == 'ACTIVE' || $checkout->status == 3){            
            $checkout->getProduct->status = '1';
            $dateNow = Carbon::now();
            $checkout->getProduct->date_end = $dateNow->addDays($checkout->getPlan->days);
            $checkout->getProduct->update();
        }
    }
}

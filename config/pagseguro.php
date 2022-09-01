<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sandbox
    |--------------------------------------------------------------------------
    |
    | Checa se utilizará o Sandbox ou Production.
    |
    */
    'sandbox' => env('PAGSEGURO_SANDBOX', true),

    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    |
    | Conta de email do Vendedor.
    |
    */
    'email' => env('PAGSEGURO_EMAIL', 'contato@uaiapp.com.br'),
    
    /*
    |--------------------------------------------------------------------------
    | Token
    |--------------------------------------------------------------------------
    |
    | Token do Vendedor.
    
    |4b214489-d090-46c5-8977-0e651195a274d5d025794acdb9fb72145f08d16037e17629-d7bd-48ba-b625-0be71b3148ac
    */
    'token' => env('PAGSEGURO_TOKEN', '637DA852D1EF49DE872C893B1D1962B0'),

    /*
    |--------------------------------------------------------------------------
    | NotificationURL
    |--------------------------------------------------------------------------
    |
    | URL de resposta para notificações do Pagseguro.
    |
    */
    // 'notificationURL' => env('PAGSEGURO_NOTIFICATION', url('pagseguro-notification')),

];

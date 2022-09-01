<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends ModelDefault
{
    protected $fillable = ['code_pagseguro', 'date_pagseguro', 'status', 'link_boleto', 'paymentMethod', 'plan_id','user_app_id', 'product_id'];

    protected $labels = [
                        'code_pagseguro'    => 'Código Pagseguro',
                        'date_pagseguro'    => 'Data Pagseguro',
                        'status'            => 'Status',
                        'link_boleto'       => 'Link Boleto',
                        'paymentMethod'     => 'Método de Pagamento',
                        'plan_id'           => 'Plano',
                        'user_app_id'       => 'Usuário ID',
                        'product_id'        => 'Produto'
                    ];

    public function getLabels()
    {
        return $this->labels;
    }

    public function getUserApp()
    {
        return $this->hasOne(UserApp::class, 'id', 'user_app_id');
    }

    public function getPlan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    
    public function getDatePagseguroAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['date_pagseguro']));
    }

    public function getPaymentMethod()
    {
        $paymentMethod = $this->paymentMethod;

        if($paymentMethod == 1)
        {
          $paymentMethod = 'Cartão';
        }
        elseif($paymentMethod == 2)
        {
          $paymentMethod = 'Boleto';
        }
        elseif($paymentMethod == 3)
        {
          $paymentMethod = 'Débito';
        }
        else if($paymentMethod == 4)
        {
            $paymentMethod = 'Dinheiro';
        }else{
            $paymentMethod = '-';
        }
        
        return $paymentMethod;
    }

    public function getStatusLegend()
    {
        switch($this->attributes['status']){
            case 'INITIATED':
                return 'O comprador iniciou o processo de pagamento, mas abandonou o checkout e não concluiu a compra.';
            break;
            case 'PENDING':
                return 'O processo de pagamento foi concluído e transação está em análise ou aguardando a confirmação da operadora.';
            break;
            case 'ACTIVE':
                return 'A criação da recorrência, transação validadora ou transação recorrente foi aprovada.';
            break;
            case 'PAYMENT_METHOD_CHANGE':
                return 'Uma transação retornou como "Cartão Expirado, Cancelado ou Bloqueado" e o cartão da recorrência precisa ser substituído pelo comprador.';
            break;
            case 'SUSPENDED':
                return 'A recorrência foi suspensa pelo vendedor.';
            break;
            case 'CANCELLED':
                return 'A criação da recorrência foi cancelada pelo PagSeguro.';
            break;
            case 'CANCELLED_BY_RECEIVER':
                return 'A recorrência foi cancelada a pedido do vendedor.';
            break;
            case 'CANCELLED_BY_SENDER':
                return 'A recorrência foi cancelada a pedido do comprador.';
            break;
            case 'EXPIRED':
                return 'A recorrência expirou por atingir a data limite da vigência ou por ter atingido o valor máximo de cobrança definido na cobrança do plano.';
            break;
            case '1':
                return 'Aguardando pagamento';
            break;
            case '2':
                return 'Em análise';
            break;
            case '3':
                return 'Paga';
            break;
            case '4':
                return 'Disponível';
            break;
            case '5':
                return 'Em disputa';
            break;
            case '6':
                return 'Devolvida';
            break;
            case '7':
                return 'Cancelada';
            break;
        }
    }
}

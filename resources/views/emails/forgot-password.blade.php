<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Recuperar senha | UAI APP</title>
    <link href="{{  asset('email_templates/styles.css') }}" media="all" rel="stylesheet" type="text/css" />
</head>

<body>

    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="content-wrap">
                                <table  cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <center>
                                                <img class="img-responsive" width="120" src="{{ asset('img/icone.png') }}"/>
                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <h3>Olá, {{ $user->getPerson->name }}</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Você recebeu esta mensagem porque informou o email para recuperar a senha no aplicativo UAI APP.
                                            Para prosseguir com a recuperação, informe o código abaixo: 
                                           <center><h1>{{ $token }}</h1></center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Não reconhece essa atividade? Desconsidere esse e-mail.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Atenciosamente, <br />Equipe UAI App.
                                        </td>
                                    </tr>                                   
                                  </table>
                            </td>
                        </tr>
                    </table>
                    <div class="footer">
                        <table width="100%">
                            <tr>
                                <td class="aligncenter content-block">© <a target="_blank" href="https://uaiapp.com.br">UAIAPP</a>.</td>
                            </tr>
                        </table>
                    </div></div>
            </td>
            <td></td>
        </tr>
    </table>

</body>
</html>

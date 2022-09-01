<?php

    function isActiveRoute($id, $output = 'active')
    {
        $grands = App\Menu::where('id', $id)->get();

        foreach($grands as $grand){
            if($grand->route == Route::currentRouteName()){
                return $output;
            }else{
                foreach($grand->getChildren as $father){
                    if($father->route == Route::currentRouteName()){
                        return $output;
                    }else{
                        foreach($father->getChildren as $son){
                            if($son->route == Route::currentRouteName()){
                                return $output;
                            }else{
                                foreach($son->getChildren as $children){
                                    if($children->route == Route::currentRouteName()){
                                        return $output;
                                    }
                                }
                            }
                        }
                    }
                }
            }            
        }
    }

    function convertMoney($money)
    {
        $money = str_replace(".", "", $money);
        $money = str_replace(",", ".", $money);

        return $money;
    }

    function cleanString($string)
    {
        $string = trim(str_replace([',', '.', '(', ')', '/', '-'], '', $string));

        return $string;
    }

    function sendNotification($fields)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $headers = array(
            'Authorization: key=AAAAoU1N0MY:APA91bGAe5X0nMzsDFzdCBmwZmOdSENzzkzgx5K_aM13WM8qgBHtDNgAQjiYFPDkutBmMj4aas0iEIjC9lJKdLvcQ5LqnYoJltNsfhilOBOY0jT8EWT2DEZuG9z1BtdsGHRPrEyU2D7m',
            'Content-Type: application/json'
        );

        $ch = curl_init();  

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result['exec'] = curl_exec($ch);
  
        if ($result['exec'] === FALSE) {
            $result['msg'] = curl_error($ch);
            return $result;
        }
       
        curl_close($ch);

        $json = json_decode($result['exec']);
       
        if($json == null){
            $result['msg']  = $result['exec'];
            $result['exec'] = false;
        }else{
            $result['msg']  = $result['exec'];
            $result['exec'] = true;
        }

        return $result;
    }

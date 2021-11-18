<?php

class TiposDeDados {

    public function alfaNumerico($dado) { // Aceita qualquer tipo de valor dentro da string
        if(is_string($dado)) {
            return true;
        } else {
            return false;
        }
    }

    public function numerico($dado) {   //Aceita somente números em string ou não
        if (!ctype_alpha(trim($dado))) {
            if (is_numeric($dado)) {
               return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function inteiro($dado) { //Segue a mesma lógica do numerico
        if(is_numeric($dado)) {
            if(!is_int($dado + 0)){
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function float($dado) { //Aceita valores de qualquer tamanho com ponto flutuante
        if(is_float($dado + 0)) {
            return true;
        } else {
            return false;
        }
    }

    public function monetario($dado) { //Aceita apenas valores monetarios (em string ou não), ex: 17.82
        if(is_float($dado + 0)) {
            $veri = explode('.',$dado);
            if(strlen($veri[1]) != 2) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function data($data, $format = 'Y-m-d') { // Aceita apenas datas validas no padrão Y-m-d, ex: 2010-05-20
        $veri1 = explode('-', $data);
        if (count($veri1) != 3) {
            return false;
        }
        if(strtotime($data == false)) {
            return false;
        }
    
        $vali = checkdate($veri1[1], $veri1[2], $veri1[0]);
        if(!$vali) {
            return false;
        }
    
        $d = DateTime::createFromFormat($format, $data);

        if ($d == false) {
            return false;
        }

        return true;
}

public function dataTime($data, $format = 'Y-m-d H:i:s') { //Segue a mesma logica do função data(), porém com horas, minutos e segundos
    $veri1 = explode('-', $data);

    if (count($veri1) != 3) {
        return false;
    }

    $veri2 = $veri1[0].'-'.$veri1[1].'-'.$veri1[2];
    $veri3 = explode(" ", $veri2);


    if(count($veri3) != 2) {
        return false;
    }

    $veri4 = explode('-', $veri3[0]);
    
    if(count($veri4) != 3) {
        return false;
    }

    if(strlen($veri4[0]) != 4) {
        return false;
    }

    if(strlen($veri4[1]) != 2) {
        return false;
    }

    if(strlen($veri4[2]) != 2) {
        return false;
    }
    
    $veri5 = explode(':', $veri3[1]);
    if(count($veri5) != 3) {
        return false;
    }

    if(strlen($veri5[0]) != 2) {
        return false;
    }

    if(strlen($veri5[1]) != 2) {
        return false;
    }

    if(strlen($veri5[2]) != 2) {
        return false;
    }



    if(strtotime($veri2 == false)) {
        return false;
    }


    $d = DateTime::createFromFormat($format, $veri2);

    if ($d && $d->format($format) != $data) {
        return false;
    }
    

    $date2 = serialize($d);
    $date2 = explode('"', $date2);
    $date3 = $date2[5];
    $dataValida = substr($date3, 0, -7);
    
    if(strtotime($dataValida == false)) {
        return false;
    } 

    return true;
}

public function booleano($dado) { // 0 para false e 1 para true, o que for diferente de 1 é false
    if ($dado != 1) {
        return false;
    } 
    if ($dado < 1) {
        return false;
    }

    if ($dado > 1) {
        return false;
    }

    return true;
}

public function cpfCnpj($cpfCnpj) { // Aceita apenas cpf ou cnpj válidos
    $cpfCnpj = preg_replace('/[^0-9]/is', '', $cpfCnpj);
    if(empty($cpfCnpj)){
        return false;
    }
    
    if(strlen($cpfCnpj) == 11) {
        if (strlen($cpfCnpj) != 11) {
            return false;
        }
        else if (
            $cpfCnpj == '00000000000' || 
            $cpfCnpj == '11111111111' || 
            $cpfCnpj == '22222222222' || 
            $cpfCnpj == '33333333333' || 
            $cpfCnpj == '44444444444' || 
            $cpfCnpj == '55555555555' || 
            $cpfCnpj == '66666666666' || 
            $cpfCnpj == '77777777777' || 
            $cpfCnpj == '88888888888' || 
            $cpfCnpj == '99999999999') {
            return false;
        } else {   
            
            for ($t = 9; $t < 11; $t++) {
                
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpfCnpj{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpfCnpj{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    } else{
        if (strlen($cpfCnpj) != 14) {
            return false;
        } 
        if (
            $cpfCnpj == '00000000000000' || 
            $cpfCnpj == '11111111111111' || 
            $cpfCnpj == '22222222222222' || 
            $cpfCnpj == '33333333333333' || 
            $cpfCnpj == '44444444444444' || 
            $cpfCnpj == '55555555555555' || 
            $cpfCnpj == '66666666666666' || 
            $cpfCnpj == '77777777777777' || 
            $cpfCnpj == '88888888888888' || 
            $cpfCnpj == '99999999999999') {
            return false;
        }
    
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $m = ($t - 7), $i = 0; $i < $t; $i++) {
                $d += $cpfCnpj[$i] * $m;
                $m = ($m == 2 ? 9 : --$m);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpfCnpj[$i] != $d) {
                return false;
            }
        }
        return true;
    } 

        return false;
}

}



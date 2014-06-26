<?php
echo "test";




/*
namespace {
    class rdss
    {
        public function getPutDataString($name, $way) {
            $put_data = "
                <InitSession>
                    <Parameters>
                        <TaskVariant>".$name."</TaskVariant>
                    </Parameters>
                    <DomainNames>
                        <string>".$way."</string>
                    </DomainNames>
                </InitSession>";
            return $put_data;
        }

        function echosessionRds($api_key, $name, $way) {
            $put_data = $this->getPutDataString($name, $way);
            // Инициализируем запрос для создания сессии
            $ch = curl_init("http://recipdonor.com:998/api/session/new");
// Передаем API ключ
            curl_setopt($ch, CURLOPT_USERPWD, "{$api_key}:x");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// При инициализации сессии используется метод PUT
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
// Указываем необходимые заголовки
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: text/xml; charset=utf-8",
                "Content-Length: ".strlen($put_data)));
// Передаем данные для инициализации
            curl_setopt($ch, CURLOPT_POSTFIELDS, $put_data);

// Посылаем запрос
            $initSessionData = curl_exec($ch);
            $responseInfo = curl_getinfo($ch);

            if($responseInfo['http_code'] != 200) exit('Wrong request!');

            curl_close($ch);

// Обрабатываем пришедший ответ
            $sesssionXmlData = new SimpleXMLElement($initSessionData);
// Достаем идентификатор созданой сессии
            $sessionId = $sesssionXmlData->Id;

            $sessionData = null;
            do{
                // Небольшая задержка перед получением данных
                // Инициализируем запрос для получения данных сессии
                $ch = curl_init("http://recipdonor.com:998/api/session/get/{$sessionId}");
                // Передаем API ключ
                curl_setopt($ch, CURLOPT_USERPWD, "{$api_key}:x");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml; charset=utf-8"));

                // Получаем и обрабатываем пришедший ответ
                $response = curl_exec($ch);
                $responseInfo = curl_getinfo($ch);

                if($responseInfo['http_code'] != 200) exit('Wrong request!');

                $sessionData = new SimpleXMLElement($response);
                curl_close($ch);

                // Повоторяем процедуру пока сессия не будет завершена
            }while($sessionData->SessionStatus != 'Completed' && $sessionData->SessionStatus != 'Bankrupt');

// Выводим пришедшие данные
            foreach($sessionData->Domains->DomainData as $domain)
            {
                // Доменное имя
                echo $domain->DomainName.PHP_EOL;

                foreach($domain->Values->Data as $data)
                {
                    echo $data->Parameter.PHP_EOL;
                    echo $data->Value.PHP_EOL;

                    foreach(get_object_vars($data->Value) as $paramKey => $paramValue)
                    {
                        echo "{$paramKey} = {$paramValue}".PHP_EOL;
                    }
                }
                echo PHP_EOL;
            }
        }

        function echositesonipRds($api_key) {
            // Максимальное кол-во результатов
            $count = 10;

// Инициализируем запрос
            $ch = curl_init("http://recipdonor.com:998/api/sitesonip/207.46.232.182/".$count);

// Передаем API ключ
            curl_setopt($ch, CURLOPT_USERPWD, "{$api_key}:x");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Посылаем запрос
            $sitesOnIp = new SimpleXMLElement(curl_exec($ch));

            $responseInfo = curl_getinfo($ch);
            if($responseInfo['http_code'] != 200) exit('Wrong request!');

            curl_close($ch);

            echo $sitesOnIp->CountAll.PHP_EOL;
            $i = 0;
            foreach($sitesOnIp->Collection->SiteItem as $site)
            {
                echo ++$i.". {$site->Url} - {$site->SubDomen}".PHP_EOL;
            }
        }



    }

$rds = new rdss();
// RDS Api ключ пользователя
    $api_key = "089c370e-d4be-4b95-8847-acbc381f4b89";
    $parsed_url = parse_url( 'http://kievacc.com.ua/');
    $ip = gethostbynamel($parsed_url['host']);
    $ip =  $ip[0];
    $put_data = array('Whois','Pr','PageValues','YaBar','Dmoz','IY','IG','Alexa','Semrush','Validator','Majestic','Solomono','CheckDangerous');
    /*$put_data = array('BingIp');
foreach($put_data as $name) {
    $rds->echosessionRds($api_key,$name,"www.bigmir.net");
}*/

    /*$rds->echositesonipRds($api_key);*/






   /* $parsed_url = parse_url( 'http://kievacc.com.ua/');
    $ip = gethostbynamel($parsed_url['host']);
    $ip =  $ip[0];
    $put_data = "
<InitSession>
	<Parameters>
        <TaskVariant>GeoTool</TaskVariant>
        <TaskVariant>BingIp</TaskVariant>
	</Parameters>
	<DomainNames>
		<string>".$ip."</string>
	</DomainNames>
</InitSession>";

}*/


